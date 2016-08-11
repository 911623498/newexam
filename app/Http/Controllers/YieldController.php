<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class YieldController extends CommonController
{
    public function index(){
//        $_SESSION['user']['role_id']=3;
//        $_SESSION['user']['cla_id']=9;
        $role_id=$_SESSION['user']['role_id'];
        $cla_id=$_SESSION['user']['cla_id'];
        if($role_id==1){
            $list=DB::table("man_class")->where('cla_pid',"$cla_id")->get();
            return view('yield/index',array('list'=>$list));
        }else if($role_id==2){
            $b_list=DB::table('man_class')->where('cla_id',"$cla_id")->first();
            $cla_name=$b_list['cla_pk'];
            $p_list=DB::table('man_class')->where('cla_name',"$cla_name")->first();
            $list[]=$b_list;
            $list[]=$p_list;
            return view('yield/index',array('list'=>$list));
        }else{
            $b_list=DB::table('man_class')->where('cla_id',"$cla_id")->first();
            $data=cl($cla_id);
            $d="";
            foreach($data as $k=>$v){
                $d.="['$k',$v],";
            }
            $d=substr($d,0,-1);
            $bs="[".$d."]";
            return view('yield/yield',array('b_name'=>$b_list['cla_name'],'bs'=>$bs));
        }

    }
    public function yields(){
        $cla_id=$_GET['cla_id'];
        $cla_name=$_GET['cla_name'];
        $data=cl($cla_id);
        $d="";
        foreach($data as $k=>$v){
            $d.="['$k',$v],";
        }
        $d=substr($d,0,-1);
        $bs="[".$d."]";
        return view('yield/yield',array('b_name'=>$cla_name,'bs'=>$bs));
    }
    public function zk(){
//        $_SESSION['user']['role_id']=2;
//        $_SESSION['user']['cla_id']=9;
        $role_id=$_SESSION['user']['role_id'];
        $cla_id=$_SESSION['user']['cla_id'];
        if($role_id==1){
            $list=DB::table("man_class")->where('cla_pid',"$cla_id")->get();
            return view('yield/zk',array('list'=>$list));
        }else if($role_id==2){
            $b_list=DB::table('man_class')->where('cla_id',"$cla_id")->first();
            $cla_name=$b_list['cla_pk'];
            $p_list=DB::table('man_class')->where('cla_name',"$cla_name")->first();
            $list[]=$b_list;
            $list[]=$p_list;
            return view('yield/zk',array('list'=>$list));
        }else{
            $b_list=DB::table('man_class')->where('cla_id',"$cla_id")->first();
            $data=cl($cla_id);
            $bs=zk($data);
            return view('yield/yield',array('b_name'=>$b_list['cla_name'],'bs'=>$bs));
        }
    }
    public function img(){
        $cla_id=$_GET['cla_id'];
        $cla_name=$_GET['cla_name'];
        $data=cl($cla_id);
        $bs=zk($data);
        return view('yield/yield',array('b_name'=>$cla_name,'bs'=>$bs));
    }

}
 function cl($cla_id){

    $bs_list=DB::table('man_student')->where('cla_id',"$cla_id")->get();
    $arr=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
    foreach($bs_list as $k=>$v){
        foreach($v as $kk=>$vv){
            if(in_array($kk,$arr)){
                if(!empty($vv)){
                    $bs_list[$k][$kk]=explode(',',$vv);
                }else{
                    $bs_list[$k][$kk]=array(0,0);
                }
            }
        }
    }
    $array=array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,
        '11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0,'16'=>0,'17'=>0,'18'=>0,'19'=>0,'20'=>0,);
    foreach($bs_list as $k=>$v) {
        foreach ($v as $kk => $vv) {
            if (in_array($kk, $arr)) {
                if ($vv[0] >= 90 && $vv[1] >= 90) {
                    $array[$kk] += 1;
                }
            }
        }
    }
    $sum=count($bs_list);
    foreach($array as $k=>$v){
        if($v!=0){
            $data[$k]=round(($v/$sum)*100,2);
        }else{
            $data[$k]=0;
        }
    }

     return $data;
   // return json_encode($data);

}
function zk($data){
    $zk_list=DB::table('man_date')->where('date_status',"2")->get();
    $array=array();
    foreach($zk_list as $k=>$v){
        $array[]=$v['stu_zduan'];
    }
    $i=1;
    $j=0;
    $arr=array('1'=>0,'2'=>0,'3'=>0);
    foreach($data as $k=>$v){
        if(in_array($k,$array)){
            $arr[$i]+=$v;
            $j++;
            $arr[$i]= round(($arr[$i]/$j),2);
            $j=0;
            $i++;
        }else if($k<=$array[2]){
            $arr[$i]+=$v;
            $j++;
        }else{
            break;
        }
    }
    $d="";
    foreach($arr as $k=>$v){
        $d.="['$k',$v],";
    }
    $d=substr($d,0,-1);
    $bs="[".$d."]";
    return $bs;
}