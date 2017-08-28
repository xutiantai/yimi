<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/28
 * Time: 19:28
 */

namespace app\admin\controller;



use think\Controller;

class Manager extends Controller
{
    /**
     *管理员退出登录
     */
    public function logout()
    {
        session('manager', null);
        if (session('manager') == null) {
            $this->success("退出成功", 'index/index');
        }
    }
    /*
     * 管理员列表
     * */
    public function lst()
    {
        $managerlist = db('manager')->paginate(4);
        $this->assign('manager', $managerlist);
        return $this->fetch("list");
    }
    /**
     *添加管理员页面
     */
    public function addlst()
    {
        return $this->fetch("add");
    }

    /**
     *添加管理员
     */
    public function add()
    {
//        获得数据
        if (request()->isPost()) {
            $manager = [
                'username'=> input('username'),
                'password'=> md5(input('password')),
            ];
        }
        dump('input获取数据');
        dump($manager);
        /*验证数据*/
        /*  $vali=validate('manager');
          $valiret=$vali->scene("add")->check($manager);
          dump($valiret);
          if (!$valiret) {
              dump();
              $this->error($vali->getError());
          }*/
        $validate = validate("Manager");
        if (!$validate->scene("add")->check($manager)) {
            return $this->error($validate->getError());
        };
        dump('开始查找数据库');
        $res=db("manager")->insert($manager);
        dump($res);
        if ($res){
            $this->success("添加成功", 'manager/lst');
        } else {
            $this->error(mysqli_error());
        }
    }
    /**
     *删除管理员
     */
    public function delete()
    {
        $id = input('id');


        if ($id&&isset($id)) {
            if ($id==1) { return $this->error("不具备删除超级管理员的权限", 'manager/lst');
            }
            $res=   db('manager')->where(['id' => $id])->delete();
            if ($res) {
                $this->success("删除成功", 'manager/lst');
            }
        }
    }
    /*冻结*/
    public function ban()
    {
        $id = input('id');
        if ($id&&isset($id)) {
            if ($id==1) {
                return $this->error("不具备冻结超级管理员的权限", 'manager/lst');
            }
            $db=db('manager')->where(['id' =>$id]);
            ($db->find()['is_block'])? $res=$db->update(['id'=>$id,'is_block'=>0]):$res=$db->update(['id'=>$id,'is_block'=>1]);
            if ($res) {
                $this->success('操作成功','manager/lst');
            }

        }
    }
    /**
     *更改管理员页面
     */
    public function updatelst()
    {
//        获取ID
        $id = input('id');
        dump($id);
//       绑定ID
        dump(db('manager')->find($id));
        $this->assign('manager',db('manager')->find());
        return $this->fetch("update");
    }

    /**
     *更改管理员
     */
    public function update()
    {
        if (request()->isPost()) {
            $manager = [
                'id'=>input('id'),
                'username'=> input('name'),
                'password'=> md5(input('psw')),
            ];
            $res=db('manager')->update($manager);
            return $res? $this->success("修改成功",'manager/lst'):$this->error("修改成功",'manager/lst');
        }

    }

}