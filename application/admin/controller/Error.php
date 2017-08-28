<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/28
 * Time: 20:15
 */

namespace app\admin\controller;


use think\Controller;

class Error extends  Controller
{
public function _empty(){

    return $this->error("页面错误");
}

}