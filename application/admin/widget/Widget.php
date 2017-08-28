<?php
/**
 * Created by IntelliJ IDEA.
 * User: XTT
 * Date: 2017/8/28
 * Time: 20:12
 */

namespace app\admin\widget;


use think\Controller;

class Widget extends  Controller
{
    public function top()
    {
        return $this->fetch("common/top");
    }
    public function left()
    {
        return $this->fetch("common/left");
    }
}