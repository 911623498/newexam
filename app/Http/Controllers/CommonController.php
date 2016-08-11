<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class CommonController extends Controller
{

    //公共控制
     public function __construct(Request $request)
     {
         session_start();
         if (empty($_SESSION['user'])) {
             \Redirect::to('/')->send();
             die;
         }
         if ($_SESSION['user']['use_id'] != 1) {
             $arr = $this->getCurrentAction();
             if($arr['controller'] =='Index'){
                 return;
             }
             $status = false;
             foreach ($_SESSION['user']['power'] as $key => $val) {
                 foreach ($val['son'] as $k => $v) {
                     if ($arr['controller'] == $v['controller'] && $arr['function'] == $v['action']) {
                         $status = true;
                     }
                 }
             }
             if ($status == false) {
                 \Redirect::to('login/error?status=3')->send();
             }
        }
     }
    //获取控制器和方法
    public function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $controller = substr($class, strpos($class, 'Controllers') + 12, -10);
        return ['controller' => $controller, 'function' => $method];
    }


}


