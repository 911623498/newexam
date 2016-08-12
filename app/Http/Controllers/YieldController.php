<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class YieldController extends CommonController
{
    /**
     * 展示不同角色它所相应的柱状图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $_SESSION['user']['role_id']=8;
        $_SESSION['user']['cla_id']="";
        $role_id=$_SESSION['user']['role_id'];
        $cla_id=$_SESSION['user']['cla_id'];
        switch($role_id){
            case 8:
                $bw_list=DB::table('man_class')->select('cla_id','cla_name')->where('cla_pid',"0")->get();

                foreach($bw_list as $k=>$v){
                    $cla_name=$v['cla_name'];
                    $y_list[$cla_name]=DB::table('man_class')->select('cla_id')->where('cla_pid',$v['cla_id'])->get();
                }
                foreach($y_list as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $b_list[$k][$kk]=DB::table('man_class')->select('cla_id')->where('cla_pid',$vv)->get();
                    }
                }
                foreach($b_list as $k=>$v){
                    foreach($v as $kk=>$vv){
                        foreach($vv as $kkk=>$vvv){
                            $data[$k][$kk][$kkk]=yi($vvv['cla_id']);
                        }
                    }
                }
                foreach($data as $k => $v){
                    foreach($v as $kk=>$vv){
                        $arr[$k][$kk]['a_jg']=jy($vv);
                    }
                }
                foreach($arr as $k=>$v){
                    $arr1[$k]['a_jg']=jy($v);
                }
                $array=array();
                $array=jy($arr1);
                $data=implode(',',$array);
                $a_ks="'".implode("','",array_keys($array))."'";
                $str="{
                        name: '八维',
                        data: [$data]
                    },";
                //print_r($arr1);
                foreach($arr1 as $k=>$v){
                    $a_jg[$k]=implode(',',$v['a_jg']);
                    $a_kk[$k]="'".implode("','",array_keys($v['a_jg']))."'";
                    $str.="{
                        name: '$k',
                        data: [$a_jg[$k]]
                    },";
                }
                $str=substr($str,0,-1);
                break;
            case 1:
            case 6:
            $b_list=DB::table('man_class')->select('cla_id','cla_name')->where('cla_pid',"$cla_id")->get();

            $b_jy=DB::table('man_class')->select('cla_name')->where('cla_id',"$cla_id")->first();
            foreach($b_list as $k=>$v){
                $q_list[]=DB::table('man_class')->select('cla_id')->where('cla_pid',$v['cla_id'])->get();
            }
            foreach($q_list as $k=>$v){
                foreach($v as $kk=>$vv){
                    foreach($vv as $kkk=>$vvv){
                        $data[$k][$kk]=yi($vvv);
                    }
                }
            }
            $arr=array();
            foreach($data as $k => $v){
                $arr[$k]['a_jg']=jy($v);
                $arr[$k]['cla_name']=$b_list[$k]['cla_name'];
            }

            $array=array();
            $array=jy($arr);
            $data=implode(',',$array);
            $a_ks="'".implode("','",array_keys($array))."'";
            $str="{
                        name: '$b_jy[cla_name]',
                        data: [$data]
                    },";

            foreach($arr as $k=>$v){
                $a_jg[$k]=implode(',',$v['a_jg']);
                $a_kk[$k]="'".implode("','",array_keys($v['a_jg']))."'";
                $str.="{
                        name: '$v[cla_name]',
                        data: [$a_jg[$k]]
                    },";
            }
            $a_ks=$a_kk[0];
            $str=substr($str,0,-1);
            break;
            case 7:
                $b_list=DB::table('man_class')->select('cla_id')->where('cla_pid',"$cla_id")->get();
                $b_xi=DB::table('man_class')->select('cla_name')->where('cla_id',"$cla_id")->first();

                foreach($b_list as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $data[$k]=yi($vv);
                    }
                }
               $arr=jy($data);
                $zh_jf=implode(',',$arr);
                $a_ks="'".implode("','",array_keys($arr))."'";
                $str="{
                            name: '$b_xi[cla_name]',
                            data: [$zh_jf]
                        }";
                break;
            case 2:
                $b_list=DB::table('man_class')->select('cla_pk','cla_pid')->where('cla_id',"$cla_id")->first();
                $cla_name=$b_list['cla_pk'];
                $cla_pid=$b_list['cla_pid'];
                $p_list=DB::table('man_class')->select('cla_id')->where(['cla_name'=>$cla_name,'cla_pid'=>$cla_pid])->first();
                //print_r($p_list);
                $data[]=yi($cla_id);
                $data[]=yi($p_list['cla_id']);
                $str="";
                foreach($data as $k=>$v){
                    $a_jg[$k]=implode(',',$v['a_jg']);
                    $a_ks="'".implode("','",array_keys($v['a_jg']))."'";
                    $str.="{
                            name: '$v[cla_name]',
                            data: [$a_jg[$k]]
                        },";
                }

                $str=substr($str,0,-1);;
                break;
            case 3:
            case 5:
                $json=yi($cla_id);
                $data=implode(',',$json['a_jg']);
                $a_ks="'".implode("','",array_keys($json['a_jg']))."'";

                $str="{
                        name: '$json[cla_name]',
                        data: [$data]
                    }";
                //echo $a_ks;
                break;
        }
        return view('yield/yield',array('str'=>$str,'a_ks'=>$a_ks,'cla_id'=>$cla_id,'role_id'=>$role_id));
    }
    public function xq(){
        $cla_id=$_GET['cla_id'];
        $role_id=$_GET['role_id'];
        $b_list=DB::table('man_class')->select('cla_id')->where('cla_pid',"$cla_id")->get();
        $b_xi=DB::table('man_class')->select('cla_name')->where('cla_id',"$cla_id")->first();
        foreach($b_list as $k=>$v){
            foreach($v as $kk=>$vv){
                $data[$k]=yi($vv);
            }
        }
        $str="";
        foreach($data as $k=>$v){
            $a_jg[$k]=implode(',',$v['a_jg']);
            $a_kk[$k]="'".implode("','",array_keys($v['a_jg']))."'";
            $str.="{
                        name: '$v[cla_name]',
                        data: [$a_jg[$k]]
                    },";
            }
            $a_ks=$a_kk[0];
            $str=substr($str,0,-1);
        return view('yield/yield',array('str'=>$str,'a_ks'=>$a_ks,'cla_id'=>$cla_id,'role_id'=>$role_id));
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
function cl($cla_id)
{

    $bs_list = DB::table('man_student')->where('cla_id', "$cla_id")->get();
    $arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
    foreach ($bs_list as $k => $v) {
        foreach ($v as $kk => $vv) {
            if (in_array($kk, $arr)) {
                if (!empty($vv)) {
                    $bs_list[$k][$kk] = explode(',', $vv);
                } else {
                    $bs_list[$k][$kk] = array(0, 0);
                }
            }
        }
    }
    $array = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0,
        '11' => 0, '12' => 0, '13' => 0, '14' => 0, '15' => 0, '16' => 0, '17' => 0, '18' => 0, '19' => 0, '20' => 0,);
    foreach ($bs_list as $k => $v) {
        foreach ($v as $kk => $vv) {
            if (in_array($kk, $arr)) {
                if ($vv[0] >= 90 && $vv[1] >= 90) {
                    $array[$kk] += 1;
                }
            }
        }
    }
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
function yi($cla_id){
    $bs_list=DB::table('man_student')->select('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','yuekao')->where('cla_id',"$cla_id")->get();
    $cla_name=DB::table('man_class')->select('cla_name')->where('cla_id',"$cla_id")->first();
    $sum=count($bs_list);
    $arr=array();
    foreach($bs_list as $k=>$v){

        foreach($v as $kk=>$vv){
            $arr[$kk][$k]=$vv;
        }
    }
    $array=array();
    foreach($arr as $k=>$v){
        $array[$k]=implode('',$v);
        if(empty($array[$k])){
            unset($arr[$k]);
        }
    }
    //print_r($arr);
    $a_jg=array();
    foreach($arr as $k=>$v){
        $a_jg[$k]=0;
        foreach($v as $kk=>$vv){
            if($vv){
                $arr[$k][$kk] = explode(',',$vv);
            }else{
                $arr[$k][$kk][]="";
                $arr[$k][$kk][]="";
            }
            if(($arr[$k][$kk][0]>=90&&$arr[$k][$kk][1]>=90)||($arr[$k][$kk][0]=='监考'&&$arr[$k][$kk][1]=='监考')){
                $a_jg[$k]+=1;
            }
        }
    }
    foreach($a_jg as $k=>$v){
        $a_jg[$k]=round(($v/$sum)*100,2);
    }
    $data['a_jg']=$a_jg;
    $data['cla_name']=$cla_name['cla_name'];
    return $data;

}
function jy($data){
    $zh=array();
    foreach($data as $k=>$v){
        foreach($v as $kk=>$vv){
            if(is_array($vv)){
                foreach($vv as $kkk=>$vvv){
                    $zh[$kkk][$k]=$vvv;
                }
            }
        }
    }
    $count=count($data);
    $arr=array();
    foreach($zh as $k => $v){
        $arr[$k]=round((array_sum($v)/$count),2);
    }
    return $arr;
}