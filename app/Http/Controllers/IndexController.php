<?php

namespace App\Http\Controllers;

use DB;
class IndexController extends CommonController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //print_r($_SESSION);die;
        if($_SESSION['user']['use_id']!=1)
        {
            cz();
        }else{
            $_SESSION['user']['sum']=0;
        }

        return view('index/index');
    }

    /*右侧栏*/
    public function right(){

        return view('public/right');

    }

    /*消息*/
    public function news(){
        $arr = cz();
       return view('news',['arr'=>$arr]);
    }

}

function cz(){
    $role_id=$_SESSION['user']['role_id'];
    $cla_id=$_SESSION['user']['cla_id'];
    $user_names=$_SESSION['user']['use_names'];
    $lis=array('role_id'=>$role_id,'cla_id'=>$cla_id,'user_names'=>$user_names);
    $sum=0;
    if($role_id==3){
        //  echo "select * from man_student where cla_id=$cla_id and stu_name='$user_names' and stu_pid='1'";
        $list = DB::select("select * from man_student where cla_id=$cla_id and stu_name='$user_names' and stu_pid='1'");
        $grou_id=$list[0]['stu_group'];
        $arr = DB::select("select * from check_exam where grou_id=$grou_id and status='1'");
        //
        $sum=count($arr);
    }else{
        $arr="";
    }
    $_SESSION['user']['sum']=$sum;
    return $arr;
}