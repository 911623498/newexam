<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use PHPExcel;
class GradeController extends CommonController
{

    /**
     * 录入成绩
     */
    public function record()
    {

//        $_SESSION['user']['role_id']=3;
//        $_SESSION['user']['use_id']=29;
        $role_id=$_SESSION['user']['role_id'];
        $user_id=$_SESSION['user']['use_id'];
        //print_r($_SESSION);die;
        ///echo $user_id;die;
        //查询角色所在班级
        switch ($role_id)
        {
            case 2:
                //print_r($_SESSION);die;
                ///echo $user_id;die;
                //查询角色所在班级
                $class=DB::select("select * from man_user where use_id = $user_id");
                //print_r($class);die;
                if($class[0]['cla_id']==0)
                {
                    return redirect('index/right');die;
                }
                //echo $class[0]['cla_id'];die;
                $user_class=DB::select("select * from man_class where cla_id =".$class[0]['cla_id']);

                $group=DB::select("select * from man_student where cla_id =" .$class[0]['cla_id']." and stu_pid=1" );
                //print_r($c);
                $num=count($group);
                return view('grade.group',['data'=>$group,'num'=>$num,'class_name'=>$user_class[0]['cla_name']]);

                 break;
            case 3:

                //查询角色所在班级
                $class=DB::select("select * from man_user where use_id = $user_id");
                //print_r($class);die;
                if($class[0]['cla_id']==0)
                {
                    return redirect('index/right');die;
                }
                //echo $class[0]['cla_id'];die;
                $user_class=DB::select("select * from man_class where cla_id =".$class[0]['cla_id']);

                $group=DB::select("select * from man_student where cla_id =" .$class[0]['cla_id']." and stu_pid=1 and stu_care='".$class[0]['use_name']."'" );
                //print_r($group);die;
                $num=count($group);
                return view('grade.group',['data'=>$group,'num'=>$num,'class_name'=>$user_class[0]['cla_name']]);

                break;

        }

        $class=DB::select("select * from man_user where use_id = $user_id");
        //print_r($class);die;
        if($class[0]['cla_id']==0)
        {
            return redirect('index/right');die;
        }
        //echo $class[0]['cla_id'];die;
        $user_class=DB::select("select * from man_class where cla_id =".$class[0]['cla_id']);

        $group=DB::select("select * from man_student where cla_id =" .$class[0]['cla_id']." and stu_pid=1" );
        //print_r($c);
        $num=count($group);
        return view('grade.group',['data'=>$group,'num'=>$num,'class_name'=>$user_class[0]['cla_name']]);
    }

    /**
     * 小组成绩录入
     */
    public function test(Request $request)
    {
        $id = $request->input('id');
        $cla_id=$_SESSION['user']['cla_id'];

        $group=DB::select("select * from man_student where stu_group =$id and cla_id=$cla_id");
        //print_r($group);die;
//        $sum_cla=count($group);
//        for($i=0;$i<$sum_cla;$i++){
//            for($j=1;$j<=20;$j++){
//                $group[$i][$j] = explode(',',$group[$i][$j]);
//            }
//            $group[$i]['yuekao'] = explode(',',$group[$i]['yuekao']);
//        }

        //print_r($group);die;
        $num=count($group);
        //echo $num;die;
        $date = \DB::table('man_date')->get();
        //print_r($date);die;

        foreach($date as $k=>$v)
        {
//           echo $v['stu_zduan'];
            if($v['stu_zduan']=='0')
            {
                unset($date[$k]);
            }
        }

        //print_r($date);
        //print_r($date);die;
        return view('grade.record',['data'=>$group,'num1'=>$num,'date'=>$date]);

    }

    /*
         * 成绩添加
         * */
    public function addgrad(Request $request)
    {
        $day=$request->input('day');
        $user= $request->input('user');
        $grad= $request->input('grad');
        $group= $request->input('group');
        $cla_id= $request->input('cla_id');
        //echo  $group;die;
        $new_user=explode(',',$user);
        $new_grad=explode(',',$grad);
        //print_r($new_user);die;
        $stu_grade=DB::select("select * from man_student where stu_group=$group and cla_id=$cla_id");

        //print_r($stu_grade);die

        foreach($stu_grade as $k1=>$v1)
        {
            // echo $v1[$day]."br";
            if(!empty($v1[$day]))
            {
                echo '0';die;
            }
        }

        $j=1;
        for($i=0;$i<count($new_grad);$i=$i+2)
        {
            $arr[$i]['chengji']=$new_grad[$i].",".$new_grad[$j];
            $j=$j+2;
        }
        $m=0;
        for($k=0;$k<count($new_user);$k++){
            $arr[$m]['id']=$new_user[$k];
            $m=$m+2;
        }
        //print_r($arr);die;

        $re=serialize($arr);
        //print_r(unserialize($re)) ;die;
        unset($arr);
        $check=DB::select("select * from check_exam where grou_id=$group and cla_id=$cla_id and exam_day='$day'");

        //print_r($check);die;
        if(empty($check))
        {
            $affected=DB::insert("insert into check_exam(grou_id,cla_id,exam_day,grade) values ('$group','$cla_id','$day','$re')");
        }
        else
        {
            $affected =DB::update("update check_exam set grade='$re',status=0 where grou_id=$group and cla_id=$cla_id and exam_day='$day'");
        }

//        foreach($arr as $kk=>$vv)
//        {
//
//            $gard=$vv['chengji'];
//            $id=$vv['id'];
//            // echo "update man_student set `$day` ='$gard' where stu_id =$id";die;
//            $affected =DB::update("update man_student set `$day` ='$gard' where stu_id =$id");
//
//        }
        if($affected)
        {
            echo '1';
        }
        //print_r($arr);
    }

    /*
    *修改小组成绩
    *
    * */
    public function upgrade(Request $request)
    {
        $day= $request->input('new_val');
        $cla_id= $request->input('cla_id');
        $group= $request->input('group');

        //echo "select * from man_student where cla_id = $cla_id and stu_grtoup=$group";die;
        $res=DB::select("select * from check_exam where grou_id=$group and cla_id=$cla_id and exam_day='$day'");
        // print_r($res);die;
        if(empty($res))
        {
            echo '1';die;
        }
        else
        {
            $a=$res[0]['grade'];
            $res[0]['grade']= unserialize($a);

        }
        // print_r($res);die;
        $num3=0;
        foreach($res as $kk=>$vv)
        {
            foreach($vv['grade'] as $key=>$val)
            {
                $id=$val['id'];
                $res[$kk]['grade'][$key]['chengji']=explode(',',$val['chengji']);
                $arr=DB::select("select stu_name,stu_care from man_student where stu_id = $id");
                $res[$kk]['grade'][$key]['stu_name']=$arr[$num3]['stu_name'];
                $res[$kk]['grade'][$key]['stu_care']=$arr[$num3]['stu_care'];

            }
        }
        // print_r($res);die;
        return view('grade.upgrade',['data'=>$res]);
    }


    /**
     * 查看成绩
     */
    public function look()
    {
        @$role_id = $_SESSION['user']['role_id'];  //登录用户的角色
        @$cla_id = $_SESSION['user']['cla_id'];  //登录用户的学院（班级）
        switch ($role_id){
            case 1 :
                //校长
                $res = DB::table('man_class')->where(["cla_pid" => 0])->get();
                $data['data'] = $res;
                return view('grade.xiaolook',$data);
                break;
            case 2 :

                //查询考试标题
                $date = DB::table('man_date')->get();
                foreach($date as $k=>$v){
                    if($v['date_status']==0){
                        unset($date[$k]);
                    }
                }
                $data['table'] = $date;
//print_r($data['table']);die;
                $res = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
                $cla_pid = $res[0]['cla_id']; //班班级id
                $cla_name = $res[0]['cla_name']; //本班级名称
                $pk_name = $res[0]['cla_pk']; //pk班级名称
                $pk = DB::table('man_class')->where(["cla_name" => $pk_name])->get();
                if(empty($pk))
                {
                    $pk[0]['cla_id']=1;
                }

                $pk_id = $pk[0]['cla_id']; //pk班级id
                $data['pkid'] = $pk_id;
                $data['cla_id'] = $cla_pid;
                $data['cla_name'] = $cla_name;
                $data['pk_name'] = $pk_name;
                $data['cla_class'] = DB::table('man_student')->where(["cla_id" => $cla_pid])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get();
                $data['pk_class'] = DB::table('man_student')->where(["cla_id" => $pk_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get();
                $sum_cla = count($data['cla_class']);
                $sum_pk = count($data['pk_class']);

                //本班级分数
                for($i=0;$i<$sum_cla;$i++){
                    for($j=1;$j<=20;$j++){
                        $data['cla_class'][$i][$j] = explode(',',$data['cla_class'][$i][$j]);
                        foreach($data['cla_class'][$i][$j] as $k=>$v){
                            if($v<90)
                            {
                                #8b0000
                                $data['cla_class'][$i][$j][$k] = str_replace($data['cla_class'][$i][$j][$k],$data['cla_class'][$i][$j][$k],"<font color='gray'>".$data['cla_class'][$i][$j][$k]."</font>");
                            }
                            if($v=="")
                            {
                                $data['cla_class'][$i][$j][$k] = str_replace($data['cla_class'][$i][$j][$k],$data['cla_class'][$i][$j][$k],"");
                            }
                        }
                    }
                    $data['cla_class'][$i]['yuekao'] = explode(',',$data['cla_class'][$i]['yuekao']);
                    foreach($data['cla_class'][$i]['yuekao'] as $k=>$v){
                        if($v<90)
                        {
                            $data['cla_class'][$i]['yuekao'][$k] = str_replace($data['cla_class'][$i]['yuekao'][$k],$data['cla_class'][$i]['yuekao'][$k],"<font color='gray'>".$data['cla_class'][$i]['yuekao'][$k]."</font>");
                        }
                        if($v=="")
                        {
                            $data['cla_class'][$i]['yuekao'][$k] = str_replace($data['cla_class'][$i]['yuekao'][$k],$data['cla_class'][$i]['yuekao'][$k],"");
                        }
                    }
                }
                //pk班级分数
                for($i=0;$i<$sum_pk;$i++){
                    for($j=1;$j<=20;$j++){
                        $data['pk_class'][$i][$j] = explode(',',$data['pk_class'][$i][$j]);
                          //print_r($data);die;
                        foreach($data['pk_class'][$i][$j] as $k=>$v){
                           // print_r($v);
                            if($v<90)
                            {
                                $data['pk_class'][$i][$j][$k] = str_replace($data['pk_class'][$i][$j][$k],$data['pk_class'][$i][$j][$k],"<font color='gray'>".$data['pk_class'][$i][$j][$k]."</font>");
                            }
                            if($v=="")
                            {
                                $data['pk_class'][$i][$j][$k] = str_replace($data['pk_class'][$i][$j][$k],$data['pk_class'][$i][$j][$k],"");
                            }
                        }
                    }
                    $data['pk_class'][$i]['yuekao'] = explode(',',$data['pk_class'][$i]['yuekao']);
                }

                //本班查询默认第一天成绩成材率
                $data['arr1'] = $this->sel_status($cla_id);
                //pk班查询默认第一天成绩成材率
                $data['arr2'] = $this->sel_status($pk_id);


                $data['role_id'] = $role_id;
                return view('grade.jslook',$data);
                break;
            case 3 :
                //查询考试标题
                $date = DB::table('man_date')->get();
                foreach($date as $k=>$v){
                    if($v['date_status']==0){
                        unset($date[$k]);
                    }
                }
                $data['table'] = $date;
                $re = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
                $cla_name = $re[0]['cla_name']; //本班级名称
                $res = DB::table('man_student')->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
                $sum_cla = count($res);
                $data['data'] = $res;
                $data['cla_name'] = $cla_name;
                $data['role_id'] = $role_id;
                $data['cla_id'] = $cla_id;
                for($i=0;$i<$sum_cla;$i++){
                    for($j=1;$j<=20;$j++){
                        $data['data'][$i][$j] = explode(',',$data['data'][$i][$j]);
                        foreach($data['data'][$i][$j] as $k=>$v){
                            if($v<90)
                            {
                                #8b0000
                                $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"<font color='gray'>".$data['data'][$i][$j][$k]."</font>");
                            }
                            if($v=="")
                            {
                                $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"");
                            }
                        }
                    }
                    $data['data'][$i]['yuekao'] = explode(',',$data['data'][$i]['yuekao']);
                    foreach($data['data'][$i]['yuekao'] as $k=>$v){
                        if($v<90)
                        {
                            $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"<font color='gray'>".$data['data'][$i]['yuekao'][$k]."</font>");
                        }
                        if($v=="")
                        {
                            $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"");
                        }
                    }
                }
                //本班查询默认第一天成绩成材率
                $data['arr1'] = $this->sel_status($cla_id);
                return view('grade.zzlook',$data);
                break;
            case 5:
                //查询考试标题
                $date = DB::table('man_date')->get();
                foreach($date as $k=>$v){
                    if($v['date_status']==0){
                        unset($date[$k]);
                    }
                }
                $data['table'] = $date;
                $re = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
                $cla_name = $re[0]['cla_name']; //本班级名称
                $res = DB::table('man_student')->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
                $sum_cla = count($res);
                $data['data'] = $res;
                $data['cla_name'] = $cla_name;
                $data['role_id'] = $role_id;
                $data['cla_id'] = $cla_id;
                for($i=0;$i<$sum_cla;$i++){
                    for($j=1;$j<=20;$j++){
                        $data['data'][$i][$j] = explode(',',$data['data'][$i][$j]);
                        foreach($data['data'][$i][$j] as $k=>$v){
                            if($v<90)
                            {
                                #8b0000
                                $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"<font color='gray'>".$data['data'][$i][$j][$k]."</font>");
                            }
                            if($v=="")
                            {
                                $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"");
                            }
                        }
                    }
                    $data['data'][$i]['yuekao'] = explode(',',$data['data'][$i]['yuekao']);
                    foreach($data['data'][$i]['yuekao'] as $k=>$v){
                        if($v<90)
                        {
                            $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"<font color='gray'>".$data['data'][$i]['yuekao'][$k]."</font>");
                        }
                        if($v=="")
                        {
                            $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"");
                        }
                    }
                }
                //本班查询默认第一天成绩成材率
                $data['arr1'] = $this->sel_status($cla_id);
                return view('grade.zzlook',$data);
                break;
            case 7 :
                //系主任
                //查询考试标题
                $date = DB::table('man_date')->get();
                foreach($date as $k=>$v){
                    if($v['date_status']==0){
                        unset($date[$k]);
                    }
                }
                $data['table'] = $date;

                $re = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
                $cla_name = $re[0]['cla_name']; //系名称

                $res = DB::table('man_class')->where(["cla_pid" => $cla_id])->paginate(5);
                $data['cla_name'] = $cla_name;

                $data['data'] = $res;
                $data['cla_id'] = $cla_id ;
                return view('grade.xiclass',$data);
                break;
            case 8:
                //校长
                $res = DB::table('man_class')->where(["cla_pid" => 0])->get();
                $data['data'] = $res;
                return view('grade.xiaolook',$data);
                break;
            case 6:
                //教务 （学院）查询这是哪个学院的教务 根据学院查询  系
                $res = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
                $cla_pid = $res[0]['cla_id']; //学院ID
                $cla_name = $res[0]['cla_name']; //学院名称
                $data['cla_name'] = $cla_name;
                $data['data'] = DB::table('man_class')->where(["cla_pid" => $cla_pid])->paginate(5);
                $data['role_id'] = $role_id;
                $data['cla_id'] = $cla_id ;
                //print_r($data);die;
                return view('grade.jwlook',$data);
                break;
            default :
                return redirect('index/right');
                break;
        }
    }


    /**
     * 校长查看学院下的专业
     */
    public function sel_xi( Request $request )
    {
        $cla_pid = $request->input('id');
        $data['cla_id'] = $cla_pid;
        $data['cla_name'] = $cla_pid = $request->input('cla_name');
        $data['data'] = DB::table('man_class')->where(["cla_pid" => $data['cla_id']])->get();
        return view('grade.xilook',$data);
    }


    /**
     * 教务查看班级成绩
     */
    public function look_class( Request $request )
    {
        //查询考试标题
        $date = DB::table('man_date')->get();
        foreach($date as $k=>$v){
            if($v['date_status']==0){
                unset($date[$k]);
            }
        }
        $data['table'] = $date;
        $cla_id = $request->input('id');  //查看班级的ID
        $re = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
        $cla_name = $re[0]['cla_name']; //本班级名称
        $res = DB::table('man_student')->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
        $sum_cla = count($res);
        $data['data'] = $res;
        $data['cla_name'] = $cla_name;
        $data['cla_id'] = $cla_id;
        //查询默认第一天成绩
        $data['arr'] = $this->sel_status($cla_id);

        for($i=0;$i<$sum_cla;$i++){
            for($j=1;$j<=20;$j++){
                $data['data'][$i][$j] = explode(',',$data['data'][$i][$j]);
                foreach($data['data'][$i][$j] as $k=>$v){
                    if($v<90)
                    {
                        #8b0000
                        $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"<font color='gray'>".$data['data'][$i][$j][$k]."</font>");
                    }
                    if($v=="")
                    {
                        $data['data'][$i][$j][$k] = str_replace($data['data'][$i][$j][$k],$data['data'][$i][$j][$k],"");
                    }
                }
            }
            $data['data'][$i]['yuekao'] = explode(',',$data['data'][$i]['yuekao']);
            foreach($data['data'][$i]['yuekao'] as $k=>$v){
                if($v<90)
                {
                    $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"<font color='gray'>".$data['data'][$i]['yuekao'][$k]."</font>");
                }
                if($v=="")
                {
                    $data['data'][$i]['yuekao'][$k] = str_replace($data['data'][$i]['yuekao'][$k],$data['data'][$i]['yuekao'][$k],"");
                }
            }
        }
        //本班查询默认第一天成绩成材率
        $data['arr1'] = $this->sel_status($cla_id);
        return view('grade.classlook',$data);
    }


    /**
     *
     * 教务搜索本学院班级成绩
     *
     */
    public function sel_class( request $request )
    {
        //接受查询班级名称
        $cla_name = $request->input('key');
        //学院ID
        $cla_id = $request->input('cla_id');
        $re = DB::table('man_class')->where('cla_name','like','%'.$cla_name.'%')->where(['cla_pid'=>$cla_id])->get();
        echo json_encode($re);
    }
    public function sel_class1( request $request )
    {
//        echo 1;die;
        //接受查询班级名称
        $cla_name = $request->input('key');

        //学院ID
        $cla_id = $request->input('cla_id');
//echo $cla_id;die;
        $re = DB::table('man_class')->where(['cla_pid'=>$cla_id])->get();

        $pid = "";
        foreach($re as $k=>$v){
            $pid .= ','.$v['cla_id'];
        }

        $pid = trim($pid,',');
        $new_pid = explode(',',$pid);
        $res = DB::table('man_class')->where('cla_name','like','%'.$cla_name.'%')->wherein('cla_pid',$new_pid)->get();

        echo json_encode($res);
    }


    /**
     * 查看未审核成绩
     */
    public function look_check()
    {
        $re = DB::table('check_exam')->get();
        echo count($re);
    }


    /**
     * 讲师查看未审核成绩
     */
    public function check_exam()
    {

        $user = $_SESSION['user'];
        $cla_id = $user['cla_id'];
        $re = DB::table('check_exam')->where(['cla_id'=>$cla_id])->get();
        $res = DB::table('man_date')->get();
        $data['check'] = $re;
        $data['checks'] = $res;
//        $num=1;
//        foreach($data['checks'] as $k=>$v)
//        {
//           if($v['date_status']==2)
//           {
//               $data['checks'][$k]['num']=$num++;
//           }
//        }
      // print_r($data['checks']);die;
        foreach($data['checks'] as $k=>$v)
        {
            foreach($data['check'] as $kk=>$vv)
            {
                if($vv['exam_day']==$v['stu_zduan'])
                {
                    $data['check'][$kk]['date_status']=$v['date_status'];
                }
            }
        }
//        print_r($data['check']);
//        die;
        return view('grade.check',$data);
    }

    /**
     * 讲师成绩审核通过
     */
    public function exam_insert( Request $request )
    {
        $data = $request->input('grade');
        $day = $request->input('day');
        $che_id = $request->input('id');

        $grade = unserialize($data);
        foreach($grade as $kk=>$vv)
        {
            $gard=$vv['chengji'];
            $id=$vv['id'];
            $affected =DB::update("update man_student set `$day` ='$gard' where stu_id =$id");
        }
        if($affected){
            DB::table('check_exam')->where(['che_id'=>$che_id])->delete();
            echo 1;
        }
    }

    /**
     * 讲师审核不通过
     */
    public function exam_update( Request $request )
    {
        $id = $request->input('id');
        $affected =DB::update("update check_exam set status=1 where che_id =$id");
        if($affected){
            echo 1;
        }
    }


    /**
     * 教务成绩审核通过
     */
    public function check( Request $request )
    {

        $id = $request->input('ids');
        $ids = explode(',',$id);
        $res =DB::table('man_class')->wherein('cla_id',$ids)->update(array('cla_check'=>1));
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }

    /**
     * 教务审核不通过
     */
    public function no_check( Request $request )
    {
        $id = $request->input('ids');
        $ids = explode(',',$id);
        $res =DB::table('man_class')->wherein('cla_id',$ids)->update(array('cla_check'=>2));
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }

    /**
     * 讲师查看未审核的成绩
     */
    public function exam_info( Request $request )
    {
        $id = $request->input('id');
        $arr = DB::table('check_exam')->where(['che_id'=>$id])->get();
        $arr = unserialize($arr[0]['grade']);
        //print_r($arr);die;
        $num3=0;
        foreach($arr as $kk=>$vv)
        {
            $id=$vv['id'];
            $res=DB::select("select stu_name,stu_care from man_student where stu_id = $id");
            $arr[$kk]['stu_name']=$res[$num3]['stu_name'];
            $arr[$kk]['stu_care']=$res[$num3]['stu_care'];
            $arr[$kk]['chengji']=explode(',',$vv['chengji']);
        }
        echo json_encode($arr);
    }


    /**
     * 教务导出成绩
     */
    public function dc( Request $request )
    {
        error_reporting(0);
        $cla_id = $request->input('id');
        $re = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
        $cla_name = $re[0]['cla_name']; //本班级名称
        $res = DB::table('man_student')->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
        $sum_cla = count($res);
        for($i=0;$i<$sum_cla;$i++){
            for($j=1;$j<=20;$j++){
                if($res[$i][$j]){
                    $res[$i][$j] = explode(',',$res[$i][$j]);
                }else{
                    $res[$i][$j][]="";
                    $res[$i][$j][]="";
                }
            }
            $res[$i]['yuekao'] = explode(',',$res[$i]['yuekao']);
        }
// print_r($res);die;
        foreach($res as $k=>$v){
            foreach($v as $kk=>$vv){
                unset($res[$k]['stu_id']);
                unset($res[$k]['stu_group']);
                unset($res[$k]['stu_pid']);
                unset($res[$k]['cla_id']);
                unset($res[$k]['re_next']);
                if(is_array($vv)){
                    //print_r($vv);
                    $ll=$kk.'理论';
                    $js=$kk.'机试';
                    $res[$k][$ll]=$vv[0];
                    $res[$k][$js]=$vv[1];
                    unset($res[$k][$kk]);
                }
            }
        }
//        print_r($res);die;
//创建对象
        $excel=new PHPExcel();
//        print_r($excel);die;
//Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',);
//表头数组
        $tableheader = array('姓名','所学课程','学号','1理论','1机试','2理论','2机试','3理论','3机试','4理论','4机试','5理论',
            '5机试','6理论','6机试','7理论','7机试','8理论','8机试','9理论','9机试','10理论','10机试',
            '11机试','11机试','12理论','12机试','13理论','13机试','14理论','14机试','15理论','16机试','16理论','16机试',
            '17机试','17机试','18理论','18机试','19理论','19机试','20理论','20机试','月考理论','月考机试');
//填充表头信息
        for($i=0;$i<count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
//表格数组   索引数组
        $data=array(
            array('1','小王','男','20','100'),
            array('2','小李','男','20','101'),
            array('3','小张','女','20','102'),
            array('4','小赵','女','20','103')
        );
//填充表格信息
        for($i=2;$i<=count($res)+1;$i++) {
            $j=0;
            foreach($res[$i-2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
//创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        ob_end_clean();//清除缓冲区,避免乱码
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.date("Y-m-d")."-".$cla_name.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }


    /**
     * 学院查看专业下班级
     */
    public function sel_classs( Request $request )
    {
        //查询考试标题
        $date = DB::table('man_date')->get();
        foreach($date as $k=>$v){
            if($v['date_status']==0){
                unset($date[$k]);
            }
        }
        $data['table'] = $date;

        $cla_pid = $request->input('id');
        $data['cla_id'] = $cla_pid;
        $data['cla_name'] = $cla_pid = $request->input('cla_name');
        $data['data'] = DB::table('man_class')->where(["cla_pid" => $data['cla_id']])->get();

        return view('grade.selclass',$data);
    }

    /**
     * 查看某天班级开始各种状况
     */
    public function sel_status( $cla_id ,$day=1 )
    {
        error_reporting(0);
        $res = DB::table('man_student')->select($day)->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
        //print_r($res);die;
        $data = $res;
        $sum_cla = count($data);
        //echo $sum_cla;die;
        for($i=0;$i<$sum_cla;$i++)
        {
            for($j=1;$j<=20;$j++)
            {
                $data[$i][$j] = explode(',',$data[$i][$j]);
            }
            $data[$i]['yuekao'] = explode(',',$data[$i]['yuekao']);
        }
        $new_data = "";
        foreach($data as $k=>$v)
        {
            $new_data[] = $v[$day];
        }
        //print_r($new_data);

        $qingjia_ll = 0;
        $xiuxue_ll = 0;
        $bujige_ll = 0;
        $zuobi_ll = 0;
        $jige_ll = 0;

        $qingjia_js = 0;
        $xiuxue_js = 0;
        $bujige_js = 0;
        $zuobi_js = 0;
        $jige_js = 0;

        $ccl = 0;
        foreach($new_data as $kk=>$vv)
        {
            if(($vv[0] >= 90 || $vv[0] == "监考") && ($vv[1] >= 90 || $vv[1] == "监考") )
            {
                $ccl += 1;
            }
            //$ll[] = $vv[0]; //理论成绩
            if($vv[0] == "请假")
            {
                $qingjia_ll += 1;
            }
            if($vv[0] == "休学")
            {
                $xiuxue_ll += 1;
            }
            if($vv[0] == "作弊")
            {
                $zuobi_ll += 1;
            }
            if($vv[0] >= 90 || $vv[0] == "监考") //及格
            {
                $jige_ll += 1;
            }
            if($vv[0] < 90) //不及格
            {
                $bujige_ll += 1;
            }
            //$js[] = $vv[1]; //机试成绩
            if($vv[1] == "请假")
            {
                $qingjia_js += 1;
            }
            if($vv[1] == "休学")
            {
                $xiuxue_js += 1;
            }
            if($vv[1] == "作弊")
            {
                $zuobi_js += 1;
            }
            if($vv[1] >= 90 || $vv[1] == "监考") //及格
            {
                $jige_js += 1;
            }
            if($vv[1] < 90) //不及格
            {
                $bujige_js += 1;
            }
        }
        $arr['qingjia_ll'] = $qingjia_ll;
        $arr['xiuxue_ll'] = $xiuxue_ll;
        $arr['bujige_ll'] = $bujige_ll;
        $arr['zuobi_ll'] = $zuobi_ll;
        $arr['jige_ll'] = $jige_ll;

        $arr['qingjia_js'] = $qingjia_js;
        $arr['xiuxue_js'] = $xiuxue_js;
        $arr['bujige_js'] = $bujige_js;
        $arr['zuobi_js'] = $zuobi_js;
        $arr['jige_js'] = $jige_js;
        $arr['renshu'] = $sum_cla;
        $chuqin = $sum_cla - ($qingjia_ll+$xiuxue_ll);
        $arr['chuqin'] = round(( $chuqin / $sum_cla ) * 100,2)."%";
        $arr['chuqin'] = round(( $chuqin / $sum_cla ) * 100,2)."%";
        $new_ccl = round(( $ccl / $sum_cla ) * 100,2)."%";
        $arr['chengcaikv'] = $new_ccl;
        $arr['qingxiu'] = $qingjia_js+$xiuxue_js;
        return $arr;
    }
    /**
     * 查看某天班级开始各种状况
     */
    public function sel_info( Request $request )
    {
        $cla_id = $request->input('cla_id');
        $day = $request->input('day');

        error_reporting(0);
        $res = DB::table('man_student')->select("$day")->where(["cla_id" => $cla_id])->orderBy('stu_group', 'asc')->orderBy('stu_pid','desc')->get(); //本班级学生成绩
//        print_r($res);die;
        $data = $res;
        $sum_cla = count($data);
        //echo $sum_cla;die;
        for($i=0;$i<$sum_cla;$i++)
        {
            for($j=1;$j<=20;$j++)
            {
                $data[$i][$j] = explode(',',$data[$i][$j]);
            }
            $data[$i]['yuekao'] = explode(',',$data[$i]['yuekao']);
        }
        $new_data = "";
        foreach($data as $k=>$v)
        {
            $new_data[] = $v[$day];
        }
//        print_r($new_data);

        $qingjia_ll = 0;
        $xiuxue_ll = 0;
        $bujige_ll = 0;
        $zuobi_ll = 0;
        $jige_ll = 0;

        $qingjia_js = 0;
        $xiuxue_js = 0;
        $bujige_js = 0;
        $zuobi_js = 0;
        $jige_js = 0;

        $ccl = 0;
        foreach($new_data as $kk=>$vv)
        {
            if(($vv[0] >= 90 || $vv[0] == "监考") && ($vv[1] >= 90 || $vv[1] == "监考") )
            {
                $ccl += 1;
            }
            //$ll[] = $vv[0]; //理论成绩
            if($vv[0] == "请假")
            {
                $qingjia_ll += 1;
            }
            if($vv[0] == "休学")
            {
                $xiuxue_ll += 1;
            }
            if($vv[0] == "作弊")
            {
                $zuobi_ll += 1;
            }
            if($vv[0] >= 90 || $vv[0] == "监考") //及格
            {
                $jige_ll += 1;
            }
            if($vv[0] < 90) //不及格
            {
                $bujige_ll += 1;
            }
            //$js[] = $vv[1]; //机试成绩
            if($vv[1] == "请假")
            {
                $qingjia_js += 1;
            }
            if($vv[1] == "休学")
            {
                $xiuxue_js += 1;
            }
            if($vv[1] == "作弊")
            {
                $zuobi_js += 1;
            }
            if($vv[1] >= 90 || $vv[1] == "监考") //及格
            {
                $jige_js += 1;
            }
            if($vv[1] < 90) //不及格
            {
                $bujige_js += 1;
            }
        }

        $arr['renshu'] = $sum_cla;

        $arr['qingjia_js'] = $qingjia_js;
        $arr['xiuxue_js'] = $xiuxue_js;

        $arr['qingjia_ll'] = $qingjia_ll;
        $arr['xiuxue_ll'] = $xiuxue_ll;

        $arr['bujige_ll'] = $bujige_ll;
        $arr['bujige_js'] = $bujige_js;

        $arr['jige_ll'] = $jige_ll;
        $arr['jige_js'] = $jige_js;

        $arr['zuobi_ll'] = $zuobi_ll;
        $arr['zuobi_js'] = $zuobi_js;

        $chuqin = $sum_cla - ($qingjia_ll+$xiuxue_ll);
        $arr['chuqin'] = round(( $chuqin / $sum_cla ) * 100,2)."%";
        $new_ccl = round(( $ccl / $sum_cla ) * 100,2)."%";
        $arr['chengcaikv'] = $new_ccl;
        $arr['qingxiu'] = $qingjia_js+$xiuxue_js;
        $data['arr'] = $arr;
//        print_r($data['arr']);die;
        return view('grade.info',$data);
    }

    /**
     * 导出本系班级考试详情
     */
    public function dcxq( Request $request )
    {
        $day = $request->input('day');
        $cla_id = $request->input('cla_id');
        $xi = DB::table('man_class')->where(["cla_id" => $cla_id])->get();
        $xy = DB::table('man_class')->select('cla_name')->where(["cla_id" => $xi[0]['cla_pid']])->get();


        error_reporting(0);
        $data = DB::table('man_class')->select('cla_jd','cla_name','cla_mph','cla_intro','cla_tea','cla_id')->where(["cla_pid" => $cla_id])->get();
//        print_r($data);die;
        $ids = "";
        foreach($data as $k=>$v)
        {
            $ids[] = $v['cla_id'];
        }
        $arr = "";

        for($i=0;$i<count($ids);$i++)
        {
            $arr[] = $this->sel_status($ids[$i],$day);
        }
//        print_r($arr);die;
        foreach($arr as $k=>$v)
        {
            foreach($v as $kkk=>$vvv)
            {
                $data[$k][$kkk] = $vvv;
            }
        }
        foreach($data as $k=>$v)
        {
            array_unshift($data[$k],$xi[0]['cla_name']);
            array_unshift($data[$k],$xy[0]['cla_name']);
        }

        foreach($data as $k=>$v)
        {
            unset($data[$k]['cla_id']);
            unset($data[$k]['cla_pid']);
            unset($data[$k]['cla_check']);
            unset($data[$k]['cla_pk']);
            unset($data[$k]['jige_ll']);
            unset($data[$k]['qingjia_js']);
            unset($data[$k]['xiuxue_js']);
            unset($data[$k]['jige_js']);
            unset($data[$k]['qingxiu']);
            unset($data[$k]['zuobi_js']);
        }

        foreach($data as $k=>$v)
        {
            if($v['cla_jd']==0)
            {
                $data[$k]['cla_jd']="基础阶段";
            }
            else if($v['cla_jd']==1)
            {
                $data[$k]['cla_jd']="专业阶段";
            }
            if($v['cla_jd']==2)
            {
                $data[$k]['cla_jd']="高级阶段";
            }
        }

//        print_r($data);die;
        /////////*************开始导出***************////////////
        error_reporting(0);
//创建对象
        $excel=new PHPExcel();
//        print_r($excel);die;
//Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','F','G','H','I','J','K','L','M','N','O','P','Q');
//表头数组
        $tableheader = array('学院','系','阶段','班级','门牌号','课程','讲师','请假人数','休学人数','理论不及格人数','作弊人数','机试不及格人数','班级总人数','出勤率','成材率');
//填充表头信息
        for($i=0;$i<count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
//填充表格信息
        for($i=2;$i<=count($data)+1;$i++) {
            $j=0;
            foreach($data[$i-2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
//创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        ob_end_clean();//清除缓冲区,避免乱码
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.date("Y-m-d")."-".$xy[0]['cla_name']."-".$xi[0]['cla_name']."-".$day.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
}