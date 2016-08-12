<?php

namespace App\Http\Controllers;
use DB,Input,Redirect,url,Validator,Request;
class ExamController extends CommonController
{
    /**
     * 考试周期列表
     */
    public function exam_list()
    {
        //查出考试周期
        $arr=DB::select("select * from man_date where date_status!=0");
        return view('exam/exam_list',['arr'=>$arr]);
    }
    /**
     * 考试周期录入
     */
    public function record()
    {
        $arr=DB::select("select * from man_date");
        return view('exam/record',['arr'=>$arr]);
    }
    /**
     * 考试周期添加
    */
    public function save()
    {
        //接值
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        //查询上一考试周期是否结束
        $yuekao = DB::select("select * from man_student where stu_id=1&&1!=''&&yuekao='' || stu_id=10&&1!=''&&yuekao='' || stu_id=50&&1!=''&&yuekao='' || stu_id=100&&1!=''&&yuekao='' || stu_id=150&&1!=''&&yuekao='' || stu_id=200&&1!=''&&yuekao='' || stu_id=250&&1!=''&&yuekao='' || stu_id=300&&1!=''&&yuekao='' || stu_id=400&&1!=''&&yuekao='' || stu_id=500&&1!=''&&yuekao=''");
        //var_dump($yuekao);exit;
        if(!empty($yuekao)){
            echo 3;
        }else
        {
            $sql="insert into man_date(date_time,date_xingqi,stu_zduan,date_status)values";
            $arr=array();
            //计算天数
            $days=abs(strtotime($end_date)-strtotime($start_date))/86400;
            //  echo $days;die;
            if($days>=26)
            {
                //echo $days;die;
                for($i=0;$i<$days;$i++)
                {
                    $arr[]=date('Y-m-d',strtotime($start_date)+$i*24*60*60);
                }
                $arr[].=$end_date;
                //var_dump($arr);exit;
                $counts=count($arr);
                $xingqi=array();
                for($i=0;$i<$counts;$i++)
                {
                    //将传来的时间使用“-”分割成数组
                    $datearr = explode("-",$arr[$i]);
                    //var_dump($datearr);die;
                    //获取年份
                    $year = $datearr[0];
                    //获取月份
                    $month = sprintf('%02d',$datearr[1]);
                    //获取日期
                    $day = sprintf('%02d',$datearr[2]);
                    //默认时分秒均为0
                    $hour = $minute = $second = 0;
                    //将时间转换成时间戳
                    $dayofweek = mktime($hour,$minute,$second,$month,$day,$year);
                    //获取星期值
                    $shuchu = date("w",$dayofweek);
                    //echo $shuchu;die;
                    $weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
                    $xingqi[]=$weekarray[$shuchu];
                }
                //var_dump($xingqi);die;
                $count=count($arr);
                for($i=0;$i<$count;$i++)
                {
                    $sql.="('$arr[$i]','$xingqi[$i]',$i+1,1),";
                }
                //去除右边逗号
                $sql=trim($sql,',');
                //删除考试周期表
                $sq="TRUNCATE man_date";
                $re=DB::statement("$sq");
                //删除学生成绩表
                $sql1="TRUNCATE man_student";
                $re1=DB::statement("$sql1");

                //删除学生成绩表
                $sq12="TRUNCATE man_pk_group";
                $re1=DB::statement("$sq12");

                //查询小组长和学生的用户
                $ar=DB::select("select * from man_user_role where role_id=3 || role_id=5");
                //echo $ar[0]['use_id'];exit;
                //var_dump($ar);exit;
                $user_id="";
                for($i=0;$i<count($ar);$i++)
                {
                    $user_id.=$ar[$i]['use_id'].',';
                }
                $user_id=rtrim($user_id,',');
                $new_id=explode(',',$user_id);


                //删除用户表的小组长和学生
                $ars =DB::table('man_user')->wherein('use_id',$new_id)->delete();

                // $ars=DB::table("delete from man_user where use_id in($user_id)");
                //删除用户和角色表中的小组长和学生
                //echo "delete from man_user where id in($user_id)";die;
                $ars1 =DB::table('man_user_role')->where('role_id',3)->orWhere('role_id',5)->delete();
                //  $ars1=DB::table("delete from man_user_role where role_id=3role_id=5");
                $res=DB::statement("$sql");
                if($res)
                {
                    echo 1;
                }

            }else{
                echo 2;
            }
        }
    }
    /**
    *展示考试类型
    */
    public function type_list()
    {
        $arr=DB::select("select * from man_date");
        //var_dump($arr);die;
        return view("exam/type_list",['arr'=>$arr]);
    }
    /*
     *考试类型录入
     **/
    public function exam_status()
    {
        //接值
        $zt=$_POST['zt'];
        $date_status=$_POST['date_status'];
        //var_dump($date_status);
        //var_dump($zt);die;
        //计算数组长度
        $count=count($zt);
        $num=1;
        //定义考试总数
        $sum=0;
        //定义周考次数
        $zhou=0;
        for($i=0;$i<$count;$i++)
        {
            //计算考试天数
            if($date_status[$i+1]!=0)
            {
                $sum++;
            }
            //计算周考次数
            if($date_status[$i+1]==2)
            {
                $zhou++;
            }
        }
        //判断考试天数
        if($sum==21)
        {
            //判断周考次数
            if($zhou==3)
            {
                for($i=0;$i<$count;$i++)
                {
                    if($date_status[$i+1]==0)
                    {
                        $stu_zduan=0;
                    }elseif($date_status[$i+1]==1 || $date_status[$i+1]==2)
                    {
                        $stu_zduan=$num++;
                    }else
                    {
                        $stu_zduan="yuekao";
                    }
                    //echo $stu_zduan;die;
                    $date=$date_status[$i+1];
                    $sql="update man_date set date_status=$date,stu_zduan='$stu_zduan' where date_id=$zt[$i]";
                    //echo $sql;die;
                    $res=DB::update("$sql");
                }
                echo "<script>alert('录入成功');location.href='exam_list'</script>";
            }else
            {
                echo "<script>alert('周考次数必须等于3');location.href='type_list'</script>";
            }
        }else
        {
            echo "<script>alert('考试日期必须等于21天');location.href='type_list'</script>";
        }
    }
}
