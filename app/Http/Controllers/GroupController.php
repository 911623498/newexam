<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
require_once (__DIR__."/../../../vendor/PHPExcel.php");
use Illuminate\Support\Facades\Input;

class GroupController extends CommonController
{

    /**
     * 小组PK列表
     *
     */
     public function allot()
    {
      $cla_id = $_SESSION['user']['cla_id'];
       // $cla_id = 9;
        //PK 小组
        $pk="select * from man_pk_group INNER JOIN man_student on man_pk_group.stu_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id'";
        $pk=DB::select($pk);
        $pk1=DB::select("select * from man_pk_group INNER JOIN man_student on man_pk_group.pk_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id'");
        //未PK组
        //print_r($pk1);die;
        $person=DB::select("select * from man_pk_group INNER JOIN man_student on man_pk_group.stu_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id' and pk_group=''");
      //   print_r($person);die;

        $su=count($person);
        //echo $su;die;
        if($su%2==0){
            //print_r($person);die;
            return view('group/chose_grouper',['person'=>$person,'pk'=>$pk,'pk1'=>$pk1]);
        }else{
            echo "当前为奇数组，不能分配小组PK";
        }
    }

    /**
     * 显示添加学生的页面
     */
    public function ad_stu_massage()
    {
       $cla_id = $_SESSION['user']['cla_id'];
          //  $cla_id = 9 ;
        $sql="select stu_group from man_student  where cla_id = $cla_id group BY stu_group";
        $res=DB::select($sql);
//        print_r($res);die;
        return view('group/ad_stu_man',['list'=>$res]);
    }
    /**
     * 接受学生信息，入库
     */
    public function addin_data()
    {
        //班级
       $cla_id = $_SESSION['user']['cla_id'];
       // $cla_id = 9;
        //小组
        $zu = $_POST['zu'];
        if($zu==""){
            $zu=0;
        }
//        print_r($zu);die;
        //课程
        $j_course=$_POST['course'];
        $course=explode(',', $j_course);

        if(in_array("",$course)){
            echo 1;die;//课程不为空
        }
        //重修次数
        $j_re_next=$_POST['re_next'];
        $re_next=explode(',', $j_re_next);
        if(in_array("",$re_next)){
            echo 2;die;//重修次数不为空
        }
        $time=date("Y-m-d H:i:s",time());
        $ip=$_SERVER['REMOTE_ADDR'];
        $stu_name = $_POST['stu_name'];
        $now_name = explode(',', $stu_name);
        if($zu==0){
            //验证姓名唯一
            $name = DB::select("select stu_name from man_student where  cla_id='$cla_id'");
            $rea_name="";
            foreach ($name as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $rea_name[$k] = $vv;
                }
            }
            $a = false;
            foreach ($now_name as $v) {
                if (in_array($v, $rea_name)) {
                    $a = true;
                    break;
                }
            }
            if ($a) {
                echo 3;
                die;//姓名唯一
            }
            if(in_array("",$now_name)){
                echo 4;die;//姓名不能为空
            }

            //验证学生号唯一
            $care = DB::select("select stu_care from man_student where  cla_id='$cla_id'");
            $stu_care = $_POST['stu_care'];
            $now_care = explode(',', $stu_care);

            $rea_care="";
            foreach ($care as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $rea_care[$k] = $vv;
                }
            }
            $b = false;
            foreach ($now_care as $v) {
                if (in_array($v, $rea_care)) {
                    $b = true;
                    break;
                }
            }
            if ($b) {
                echo 5;
                die;//学号唯一
            }
            if(in_array("",$now_care)){
                echo 6;die;//学号不能为空
            }

            $stu_sql="insert into man_student (stu_name,stu_pid,cla_id,stu_group,course,stu_care,re_next) VALUES";
            $a="";
            for ($i = 0; $i < count($now_name); $i++) {
                $a[$i]['rea_name'] = $now_name[$i];
                $a[$i]['course'] = $course[$i];
                $a[$i]['rea_care'] = $now_care[$i];
                $a[$i]['re_next'] = $re_next[$i];
            }
//            print_r($a);die;
            for ($i = 0; $i < count($a); $i++) {
                //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                $stu_sql .= "('" . $a[$i]['rea_name'] . "','0','$cla_id','0','" . $a[$i]['course'] . "','" . $a[$i]['rea_care'] . "','" . $a[$i]['re_next'] . "'),";
            }
            $stu_sql = substr($stu_sql, 0, -1);
            $aa = DB::statement($stu_sql);
            if($aa){
                $user_sql="insert into man_user (use_name,use_pwd,use_time,use_ip,use_names,cla_id) VALUES";
                for ($j = 0; $j < count($a); $j++) {
                    //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                    $user_sql .= "('" . $a[$j]['rea_care'] . "','123','$time','$ip','" . $a[$j]['rea_name'] . "','$cla_id'),";
                }
                $user_sql = substr($user_sql, 0, -1);
//                echo $sql;die;
                $bb = DB::statement($user_sql);
                if($bb){
                    $su=count($a);
                    $sql="select use_id from man_user where cla_id=$cla_id ORDER BY use_id desc  limit $su";
                    $aid = DB::select($sql);
                    $use_id="";
                    foreach ($aid as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $use_id[$k] = $vv;
                        }
                    }
                    $a="";
                    for ($i = 0; $i < count($use_id); $i++) {
                        $a[$i]['use_id'] = $use_id[$i];
                        $a[$i]['role_id'] = 5;
                    }
                    $role_sql="insert into man_user_role (use_id,role_id)VALUES ";
                    for ($i = 0; $i < count($a); $i++){
                        //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                        $role_sql .= "('" . $a[$i]['use_id'] . "','" . $a[$i]['role_id'] . "'),";
                    }
                    $role_sql = substr($role_sql, 0, -1);
//                echo $sql;die;
                    $cc = DB::statement($role_sql);
                    if($cc){
                        echo 7;die;
                    }
                }
            }else{
                echo 0;die;
            }
        }else{
            //1.判断所选组的成员的个数，以及加上现在的个数是否大于6
            $sql="select stu_id from man_student where cla_id = $cla_id and stu_group = $zu";
            $zu_shu=count(DB::select($sql));
            $j_count=count($now_name);
            $count=$zu_shu+$j_count;
            if($count>6){
                echo 8;die;//添加的人超过所选小组人数
            }else{
                //验证姓名唯一
                $name = DB::select("select stu_name from man_student where  cla_id='$cla_id'");
                $rea_name="";
                foreach ($name as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $rea_name[$k] = $vv;
                    }
                }
                $a = false;
                foreach ($now_name as $v) {
                    if (in_array($v, $rea_name)) {
                        $a = true;
                        break;
                    }
                }
                if ($a) {
                    echo 3;
                    die;//姓名唯一
                }
                if(in_array("",$now_name)){
                    echo 4;die;//姓名不能为空
                }

                //验证学生号唯一
                $care = DB::select("select stu_care from man_student where  cla_id='$cla_id'");
                $stu_care = $_POST['stu_care'];
                $now_care = explode(',', $stu_care);

                $rea_care="";
                foreach ($care as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $rea_care[$k] = $vv;
                    }
                }
                $b = false;
                foreach ($now_care as $v) {
                    if (in_array($v, $rea_care)) {
                        $b = true;
                        break;
                    }
                }
                if ($b) {
                    echo 5;
                    die;//学号唯一
                }
                if(in_array("",$now_care)){
                    echo 6;die;//学号不能为空
                }

                $stu_sql="insert into man_student (stu_name,stu_pid,cla_id,stu_group,course,stu_care,re_next) VALUES";
                $a="";
                for ($i = 0; $i < count($now_name); $i++) {
                    $a[$i]['rea_name'] = $now_name[$i];
                    $a[$i]['course'] = $course[$i];
                    $a[$i]['rea_care'] = $now_care[$i];
                    $a[$i]['re_next'] = $re_next[$i];
                }
                for ($i = 0; $i < count($a); $i++) {
                    //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                    $stu_sql .= "('" . $a[$i]['rea_name'] . "','0','$cla_id','$zu','" . $a[$i]['course'] . "','" . $a[$i]['rea_care'] . "','" . $a[$i]['re_next'] . "'),";
                }
                $sql = substr($stu_sql, 0, -1);
                $aa = DB::statement($sql);
                if($aa){
                    $user_sql="insert into man_user (use_name,use_pwd,use_time,use_ip,use_names,cla_id) VALUES";
                    for ($i = 0; $i < count($a); $i++) {
                        //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                        $user_sql .= "('" . $a[$i]['rea_care'] . "','123','$time','$ip','" . $a[$i]['rea_name'] . "','$cla_id'),";
                    }
                    $sql = substr($user_sql, 0, -1);
//                echo $sql;die;
                    $bb = DB::statement($sql);
                    if($bb){
                        $su=count($a);
                        $sql="select use_id from man_user where cla_id=$cla_id ORDER BY use_id desc  limit $su";
                        $aid = DB::select($sql);
                        $use_id="";
                        foreach ($aid as $k => $v) {
                            foreach ($v as $kk => $vv) {
                                $use_id[$k] = $vv;
                            }
                        }
                        $a="";
                        for ($i = 0; $i < count($use_id); $i++) {
                            $a[$i]['use_id'] = $use_id[$i];
                            $a[$i]['role_id'] = 5;
                        }
                        $role_sql="insert into man_user_role (use_id,role_id)VALUES ";
                        for ($i = 0; $i < count($a); $i++){
                            //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                            $role_sql .= "('" . $a[$i]['use_id'] . "','" . $a[$i]['role_id'] . "'),";
                        }
                        $sql = substr($user_sql, 0, -1);
//                echo $sql;die;
                        $cc = DB::statement($sql);
                        if($cc){
                            echo 7;die;
                        }
                    }
                }else{
                    echo 0;die;
                }
            }
        }
    }
    /**
     * 列表
     */
    public function group_list()
    {


       $cla_id=$_SESSION['user']['cla_id'];

       // $cla_id = 9;

        $user_list = DB::table('man_student')->where('cla_id',$cla_id)->paginate(10);
//        print_r($user_list);

            return view('group/group_list',['user_list'=>$user_list]);


    }
    /**
     * 小组PK
     */
    public function group_pk(){
        $id=$_POST['id'];
        $di=strpos($id,',');
        $id1=substr($id,0,$di);
        $id2=substr($id,$di+1);
        $sql1="select pk_id from man_pk_group where stu_group = '$id1'";
        $aa=DB::select($sql1);
        $pk_id=$aa[0]['pk_id'];
        $sql1="update man_pk_group set pk_group = '$id2' where pk_id = '$pk_id'";
        $aa=DB::statement($sql1);
        if($aa){
            $sql2="select pk_id from man_pk_group where stu_group = '$id2'";
            $aa2=DB::select($sql2);
            $pk_id2=$aa2[0]['pk_id'];
            $sql2="update man_pk_group set pk_group = '$id1' where pk_id = '$pk_id2'";
            $aa2=DB::statement($sql2);
            if($aa2){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    /**
     * 生成账号
     */
    public function sczh()
    {

     $cla_id = $_SESSION['user']['cla_id'];
     //   $cla_id = 9;
        //print_r($cla_id);die;
        $sql = "select stu_name,stu_pid,stu_care from man_student where cla_id = '$cla_id'";
        $res = DB::select($sql);
        $qq=DB::select("select stu_care from man_student");
        for($i=0;$i<count($qq);$i++){
            $qqs[]=$qq[$i]['stu_care'];
        }

        $pp=DB::select("select use_name from man_user");
        for($i=0;$i<count($pp);$i++){
            $pps[]=$pp[$i]['use_name'];
        }
        //验证唯一
        $flag=true;
        foreach($qqs as $v){

            if(!in_array($v,$pps)){
                $flag=false;
                break;
            }
        }
        if($flag){
            echo 2333;die;
        }

        //print_r($res);die;
        $time=date("Y-m-d H:i:s",time());
        $iipp=$_SERVER["REMOTE_ADDR"];
        //print_r($iipp);die;
        $sql="insert into man_user (use_name,use_pwd,use_time,use_ip,use_names,cla_id) VALUES ";
        for ($i = 0; $i < count($res); $i++) {

            $stu_name=$res[$i]['stu_name'];
            $stu_care=$res[$i]['stu_care'];
            //print_r($a['stu_care']);die;

            $sql.="('$stu_care','123','$time','$iipp','$stu_name','$cla_id')".",";

        }
        $sql=substr($sql,0,-1);
        $c_sql="select * from man_user";
        //入库前有多少数据
        $ss=DB::select($c_sql);
        $z_count=count($ss);


        //入库多少数据
        $stu_sql="select stu_id from man_student where cla_id = $cla_id";
        $ass=DB::select($stu_sql);

        $r_count=count($ass);
        //echo $r_count;die;
        $aa=DB::statement($sql);
        if($aa){
            $sql1="select use_id from man_user limit $z_count,$r_count";
            $ace = DB::select($sql1);
            //print_r($ace);die;
            $sql2="select use_id from man_user_role";
            $ace2 = DB::select($sql2);
            $flag=false;
            foreach($ace as $v){
                if(!in_array($v,$ace2)){
                    $flag=true;
                    break;
                }
            }
            if($flag){
               $stu_sql5="select stu_pid from man_student where cla_id = $cla_id";
                $ace5= DB::select($stu_sql5);
                $sql3="select use_id,cla_id from man_user limit $z_count,$r_count";
                $ace3 = DB::select($sql3);
                $sqls="insert into man_user_role (use_id,role_id) VALUES";
                for ($i = 0; $i < count($ace3); $i++) {

                        $stu_pid= $ace5[$i]['stu_pid'];
                        $use_id1=$ace3[$i]['use_id'];

                        if($stu_pid == 1){
                            $asas=3;
                        }else if($stu_pid == 0){
                            $asas=5;
                        }
                        $sqls.="('$use_id1','$asas')".",";
                }
                $sqlss=substr($sqls,0,-1);
                $wwe=DB::statement($sqlss);
                if($wwe){
                    echo 11;
                }else{
                    echo 22;
                }
            }else{
                echo 22;
            }
        }
    }

    /**
     * 学生信息的删除
     */
    public function stu_del(){


        $stu_id=$_POST['stu_id'];
        $last_id=$_POST['last_id'];
        $sql="delete from man_student where stu_id= $stu_id";
        $re=DB::statement($sql);
        if($re){
            $sql="select * from man_student where stu_id = (select stu_id from man_student where stu_id > $last_id order by stu_id asc limit 1)";
            $re=DB::select($sql);
            echo json_encode($re);
        }else{
            echo 0;
        }

    }


    /**
     * 导入
     */
    public function daoru(Request $request){
     $cla_id = $_SESSION['user']['cla_id'];
      //  $cla_id = 9;

        $PHPExcel = new \PHPExcel();
        //这里是导入excel2007 的xlsx格式，如果是2003格式可以把“excel2007”换成“Excel5"
        //怎么样区分用户上传的格式是2003还是2007呢？可以获取后缀  例如：xls的都是2003格式的
        //xlsx 的是2007格式的  一般情况下是这样的
        if(!empty($_FILES['student_list']['name'])){
            $file_types = explode(".",$_FILES['student_list']['name']);
            $file_type = $file_types[count($file_types)-1];
        }
        if( $file_type =='xlsx' )
        {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        }
        else
        {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }
        //导入的excel路径
        $excelpath=$_FILES['student_list']['tmp_name'];
        if(empty($excelpath)){
            echo "<script>alert('请选择上传的文件！');location.href='group_list'</script>";
        }
        @$objPHPExcel=$objReader->load($excelpath);
        if($objPHPExcel){
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            //导入的excel路径
            $excelpath=$_FILES['student_list']['tmp_name'];
            $objPHPExcel=$objReader->load($excelpath);
        }
        $sheet=$objPHPExcel->getSheet(0);
        //取得总行数
        $highestRow=$sheet->getHighestRow();
        //取得总列数
        $highestColumn=$sheet->getHighestColumn();
        //从第二行开始读取数据  因为第一行是表格的表头信息
        $sql = "";
        for($j=2;$j<=$highestRow;$j++) {
            $str = "";
            //从A列读取数据
            for ($k='B'; $k <= $highestColumn; $k++) {
                $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue() . '|*|';//读取单元格
            }
            $str = mb_convert_encoding($str, 'utf8', 'auto');//根据自己编码修改
            $strs = explode("|*|", $str);
            //拼写sql语句
            $sql[] = [
                'stu_name' => "{$strs[0]}",
                'cla_id' =>  $cla_id,
                'stu_care' => "{$strs[1]}",
                'course' => "{$strs[3]}",
                're_next' => "{$strs[2]}"

            ];
        }
//       print_r($sql);die;
            for($i=0;$i<count($sql);$i++){
                $re=DB::table('man_student')->insert(array(
                    array('stu_name' => $sql[$i]['stu_name'],'cla_id' =>$sql[$i]['cla_id'],'stu_care' =>$sql[$i]['stu_care'],'course' =>$sql[$i]['course'],'re_next' =>$sql[$i]['re_next']),
                ));
            }
        if($re){
            $time=date("Y-m-d H:i:s",time());
            $iipp=$_SERVER["REMOTE_ADDR"];
            for($i=0;$i<count($sql);$i++){
                $res=DB::table('man_user')->insert(array(
                    array('use_name' => $sql[$i]['stu_care'],'use_pwd' =>123,'use_time' =>$time,'use_ip' =>$iipp,'use_names' =>$sql[$i]['stu_name'],'cla_id' => $sql[$i]['cla_id']),
                ));
            }
            if($res){
                $count=count($sql);
                $sql="select use_id from man_user ORDER BY use_id DESC limit $count";
                $use_id=DB::select($sql);
                foreach($use_id as $k => $v){
                    foreach($v as $kk=>$vv){
                        $a[]=$vv;
                    }
                }
//                print_r($a);die;
                for($i=0;$i<count($a);$i++){
                    $ress=DB::table('man_user_role')->insert(array(
                        array('use_id' =>$a[$i],'role_id' =>5),
                    ));
                }
                if($ress){
                    echo "<script>alert('导入成功');location.href='group_list'</script>";
                }else{
                    echo "<script>alert('导入失败');location.href='group_list'</script>";
                }
            }
        }



    }


    /**
     * 分配小组显示页面
     */
    public function fp_group(){
       $cla_id = $_SESSION['user']['cla_id'];
      //  $cla_id = 9;
        $sql="select stu_id,stu_name from man_student where stu_group = 0 and cla_id=$cla_id ";
        $list=DB::select($sql);
//        print_r($list);die;
        return view('group/fp_group',['list'=>$list]);
    }

    /**
     * 分配
     */
    public function fenpei(){
        $id=$_POST['ss'];
        $cla_id=$_SESSION['user']['cla_id'];

        $ss=strpos($id,',');

        $zu_id=substr($id,0,$ss);

        $sql1="select stu_group from man_student where cla_id=$cla_id ORDER BY stu_group DESC limit 1";
        $res1=DB::select($sql1);
//        print_r($res1);die;
        $zu=$res1[0]['stu_group'];
        $new_stu_group=$zu+1;
        // 1.首先修改小组
        if($res1){
            $sql2="update man_student set stu_group = $new_stu_group where stu_id in ($id)";
            $res2=DB::update($sql2);
            if($res2){
                $sql3="update man_student set stu_pid = 1 where stu_id = $zu_id and cla_id=$cla_id";
                $res3=DB::update($sql3);
                if($res3){
                    $sql4="select stu_care from man_student where stu_id = $zu_id";
                    $res4=DB::select($sql4);
                    foreach($res4 as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $stu_care = $vv;
                        }
                    }
                    $sql5="select use_id from man_user where use_name ='$stu_care'";
                    $res5=DB::select($sql5);
                    foreach($res5 as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $use_id = $vv;
                        }
                    }
                    $sql5="update man_user_role set role_id = 3 where use_id = $use_id";
                    $res5=DB::update($sql5);
                    if($res5){
                        $sql6="insert into man_pk_group (stu_group,cla_id) VALUE ('$zu_id','$cla_id')";
                       DB::update($sql6);
                        echo 1;
                    }else{
                        echo 5;
                    }
                }else{
                    echo 4;
                }
            }else{
                echo 3;
            }
        }else{
            echo 2;
        }



    }

    /**
     * 移出本组
     */
    public function yichu(){
        $cla_id=$_SESSION['user']['cla_id'];

      //  $cla_id = 9;
         error_reporting(0);
        $stu_id=$_POST['ids']?$_POST['ids']:"";
        if($stu_id == ""){
            $user_list = DB::table('man_student')->where('cla_id',$cla_id)->paginate(10);
            return view('group/yichu_group',['user_list'=>$user_list]);
        }else{

        $res= DB::table('man_student')->where('stu_id', $stu_id)->first();

        $stu_group = $res['stu_group'];

        if($res['stu_pid']==1){
            $sql2="update man_student set stu_pid=0 where stu_id = $stu_id";
            $res=DB::update($sql2);
            if($res){
                $sql3="update man_student set stu_group=0 where stu_group = $stu_group";
                $res1=DB::update($sql3);
                if($res1){
                    $user_list = DB::table('man_student')->where('cla_id',$cla_id)->paginate(10);
                    return view('group/yichu_group',['user_list'=>$user_list]);
                }
            }

        }else{
            $sql4="update man_student set stu_group=0 where stu_id = $stu_id";
            $re=DB::update($sql4);
            if($re){
                $user_list = DB::table('man_student')->where('cla_id',$cla_id)->paginate(10);
                return view('group/yichu_group',['user_list'=>$user_list]);
            }
        }
    }

    }
}
