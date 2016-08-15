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
     * 学生信息列表
     */
     public function allot()
    {
      $cla_id = $_SESSION['user']['cla_id'];

        //PK 小组
        $pk="select * from man_pk_group INNER JOIN man_student on man_pk_group.stu_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id'";
        $pk=DB::select($pk);
        $pk1=DB::select("select * from man_pk_group INNER JOIN man_student on man_pk_group.pk_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id'");
        //未PK组
        //print_r($pk1);die;
        $person=DB::select("select * from man_pk_group INNER JOIN man_student on man_pk_group.stu_group=man_student.stu_id where man_pk_group.cla_id = '$cla_id' and pk_group=''");
         $su=count($person);
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
        return view('group/ad_stu_man');
    }
    /**
     * 接受学生信息，入库
     */
    public function addin_data()
    {
        //班级
        $cla_id = $_SESSION['user']['cla_id'];
        //小组
        $zu = $_POST['zu'];
        /**
         * 验证
         * 小组验证
         */
        $k_zu = DB::select("select stu_group from man_student where  cla_id='$cla_id'");
//        print_r($k_zu);die;
        if (empty($k_zu)) {
            //验证姓名的唯一
            $name = DB::select("select stu_name from man_student where  cla_id='$cla_id'");
            //小组成员
            $stu_name = $_POST['stu_name'];
            $a = strpos($stu_name, ',');
            //组长
            $zu_name = substr($stu_name, 0, $a);
            //本组成员
            $zu_y_name = substr($stu_name, $a + 1);
            $new_name = explode(',', $zu_y_name);
            //学号
            $stu_care = $_POST['stu_care'];
            $a = strpos($stu_care, ',');
            //组长学号
            $zu_care = substr($stu_care, 0, $a);
            //本组成员学号
            $zu_y_care = substr($stu_care, $a + 1);
            $new_care = explode(',', $zu_y_care);

            if(empty($name)) {
                $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                $bb = DB::statement($sql);
                if ($bb) {
                    $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                    $as = DB::select($sql1);
                    $stu_ids = $as[0]['stu_id'];
                    $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                    $ass = DB::statement($sql2);
                    if ($ass) {
                        $a = "";
                        for ($i = 0; $i < count($new_name); $i++) {
                            $a[$i]['name'] = $new_name[$i];
                            //$a[$i]['name']=$new_name[$i];
                            $a[$i]['care'] = $new_care[$i];
                        }
                        //print_r($a);die;
                        $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                        for ($i = 0; $i < count($a); $i++) {
                            //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                            $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                        }
                        $sql = substr($sql, 0, -1);
                        //echo $sql;die;
                        $aa = DB::statement($sql);
                        if ($aa) {
                            echo 1;
                        } else {
                            echo 0;
                        }
                    }
                }
            }else{
                //组长名字的唯一
                $rea_name = "";
                foreach ($name as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $rea_name[$k] = $vv;
                    }
                }
                if (in_array($zu_name, $rea_name)) {
                    echo 3;
                    die;
                }
                //组员名字的唯一
                $asa = false;
                foreach ($new_name as $v) {
                    if (in_array($v, $rea_name)) {
                        $asa = true;
                        break;
                    }
                }
                if ($asa) {
                    echo 4;
                    die;
                } else {
                    $have_care = DB::select("select stu_care from man_student where  cla_id='$cla_id'");
                    if(empty($have_care)){
                        $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                        $bb = DB::statement($sql);
                        if ($bb) {
                            $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                            $as = DB::select($sql1);
                            $stu_ids = $as[0]['stu_id'];
                            $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                            $ass = DB::statement($sql2);
                            if ($ass) {
                                $a = "";
                                for ($i = 0; $i < count($new_name); $i++) {
                                    $a[$i]['name'] = $new_name[$i];
                                    //$a[$i]['name']=$new_name[$i];
                                    $a[$i]['care'] = $new_care[$i];
                                }
                                //print_r($a);die;
                                $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                                for ($i = 0; $i < count($a); $i++) {
                                    //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                                    $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                                }
                                $sql = substr($sql, 0, -1);
                                //echo $sql;die;
                                $aa = DB::statement($sql);
                                if ($aa) {
                                    echo 1;
                                } else {
                                    echo 0;
                                }
                            }
                        }
                    }else{
                        //组长Id的唯一
                        $cares="";
                        foreach ($have_care as $k => $v) {
                            foreach ($v as $kk => $vv) {
                                $cares[$k] = $vv;
                            }
                        }
                        if (in_array($zu_care, $cares)) {
                            echo 5;
                            die;
                        }
                        //组员id的唯一
                        $ert = false;
                        foreach ($new_care as $v) {
                            if (in_array($v, $cares)) {
                                $ert = true;
                                break;
                            }
                        }
                        if($ert){
                            echo 6;
                            die;
                        }else{
                            $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                            $bb = DB::statement($sql);
                            if ($bb) {
                                $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                                $as = DB::select($sql1);
                                $stu_ids = $as[0]['stu_id'];
                                $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                                $ass = DB::statement($sql2);
                                if ($ass) {
                                    $a = "";
                                    for ($i = 0; $i < count($new_name); $i++) {
                                        $a[$i]['name'] = $new_name[$i];
                                        //$a[$i]['name']=$new_name[$i];
                                        $a[$i]['care'] = $new_care[$i];
                                    }
                                    //print_r($a);die;
                                    $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                                    for ($i = 0; $i < count($a); $i++) {
                                        //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                                        $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                                    }
                                    $sql = substr($sql, 0, -1);
                                    //echo $sql;die;
                                    $aa = DB::statement($sql);
                                    if ($aa) {
                                        echo 1;
                                    } else {
                                        echo 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {

            /***************************  如果没有这个小组    ****************************************/
            $s_zu="";
            foreach($k_zu as $k=>$v){
                foreach($v as $kk=>$vv){
                    $s_zu[$k]=$vv;
                }
            }
            if (in_array($zu, $s_zu)) {
                echo 7;
                die;
            }else{
                //验证姓名的唯一
                $name = DB::select("select stu_name from man_student where  cla_id='$cla_id'");
                //小组成员
                $stu_name = $_POST['stu_name'];
                $a = strpos($stu_name, ',');
                //组长
                $zu_name = substr($stu_name, 0, $a);
                //本组成员
                $zu_y_name = substr($stu_name, $a + 1);
                $new_name = explode(',', $zu_y_name);

                //学号
                $stu_care = $_POST['stu_care'];
                $a = strpos($stu_care, ',');
                //组长学号
                $zu_care = substr($stu_care, 0, $a);
                //本组成员学号
                $zu_y_care = substr($stu_care, $a + 1);
                $new_care = explode(',', $zu_y_care);

                if(empty($name)) {
                    $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                    $bb = DB::statement($sql);
                    if ($bb) {
                        $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                        $as = DB::select($sql1);
                        $stu_ids = $as[0]['stu_id'];
                        $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                        $ass = DB::statement($sql2);
                        if ($ass) {
                            $a = "";
                            for ($i = 0; $i < count($new_name); $i++) {
                                $a[$i]['name'] = $new_name[$i];
                                //$a[$i]['name']=$new_name[$i];
                                $a[$i]['care'] = $new_care[$i];
                            }
                            //print_r($a);die;
                            $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                            for ($i = 0; $i < count($a); $i++) {
                                //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                                $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                            }
                            $sql = substr($sql, 0, -1);
                            //echo $sql;die;
                            $aa = DB::statement($sql);
                            if ($aa) {
                                echo 1;
                            } else {
                                echo 0;
                            }
                        }
                    }
                }else{
                    //组长名字的唯一
                    $rea_name = "";
                    foreach ($name as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $rea_name[$k] = $vv;
                        }
                    }
                    if (in_array($zu_name, $rea_name)) {
                        echo 3;
                        die;
                    }
                    //组员名字的唯一
                    $asa = false;
                    foreach ($new_name as $v) {
                        if (in_array($v, $rea_name)) {
                            $asa = true;
                            break;
                        }
                    }
                    if ($asa) {
                        echo 4;
                        die;
                    } else {
                        $have_care = DB::select("select stu_care from man_student where  cla_id='$cla_id'");
                        if(empty($have_care)){
                            $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                            $bb = DB::statement($sql);
                            if ($bb) {
                                $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                                $as = DB::select($sql1);
                                $stu_ids = $as[0]['stu_id'];
                                $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                                $ass = DB::statement($sql2);
                                if ($ass) {
                                    $a = "";
                                    for ($i = 0; $i < count($new_name); $i++) {
                                        $a[$i]['name'] = $new_name[$i];
                                        //$a[$i]['name']=$new_name[$i];
                                        $a[$i]['care'] = $new_care[$i];
                                    }
                                    //print_r($a);die;
                                    $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                                    for ($i = 0; $i < count($a); $i++) {
                                        //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                                        $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                                    }
                                    $sql = substr($sql, 0, -1);
                                    //echo $sql;die;
                                    $aa = DB::statement($sql);
                                    if ($aa) {
                                        echo 1;
                                    } else {
                                        echo 0;
                                    }
                                }
                            }
                        }else{
                            //组长Id的唯一
                            $cares="";
                            foreach ($have_care as $k => $v) {
                                foreach ($v as $kk => $vv) {
                                    $cares[$k] = $vv;
                                }
                            }
                            if (in_array($zu_care, $cares)) {
                                echo 5;
                                die;
                            }
                            //组员id的唯一
                            $ert = false;
                            foreach ($new_care as $v) {
                                if (in_array($v, $cares)) {
                                    $ert = true;
                                    break;
                                }
                            }
                            if($ert){
                                echo 6;
                                die;
                            }else{
                                $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ('$zu_name','1','$cla_id','$zu_care','$zu')";
                                $bb = DB::statement($sql);
                                if ($bb) {
                                    $sql1 = "select stu_id from man_student where stu_name = '$zu_name'";
                                    $as = DB::select($sql1);
                                    $stu_ids = $as[0]['stu_id'];
                                    $sql2 = "insert into man_pk_group (stu_group,cla_id) VALUES ('$stu_ids','$cla_id')";
                                    $ass = DB::statement($sql2);
                                    if ($ass) {
                                        $a = "";
                                        for ($i = 0; $i < count($new_name); $i++) {
                                            $a[$i]['name'] = $new_name[$i];
                                            //$a[$i]['name']=$new_name[$i];
                                            $a[$i]['care'] = $new_care[$i];
                                        }
                                        //print_r($a);die;
                                        $sql = "insert into man_student (stu_name,stu_pid,cla_id,stu_care,stu_group) VALUES ";
                                        for ($i = 0; $i < count($a); $i++) {
                                            //$sql.= "('".$a[$i]['name']."','".'".$cla_id."'.$a[$i]['care']."'),";
                                            $sql .= "('" . $a[$i]['name'] . "','0','$cla_id','" . $a[$i]['care'] . "','$zu'),";
                                        }
                                        $sql = substr($sql, 0, -1);
                                        //echo $sql;die;
                                        $aa = DB::statement($sql);
                                        if ($aa) {
                                            echo 1;
                                        } else {
                                            echo 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
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



        $user_list = DB::table('man_student')->where('cla_id',$cla_id)->orderBy('stu_id','desc')->paginate(5);
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

        $ss=strpos($id,',');

        $zu_id=substr($id,0,$ss);
        
        $sql1="select stu_group from man_student ORDER BY stu_group DESC limit 1";
        $res1=DB::select($sql1);
//        print_r($res1);die;
        $zu=$res1[0]['stu_group'];
        $new_stu_group=$zu+1;
        // 1.首先修改小组
        if($res1){
            $sql2="update man_student set stu_group = $new_stu_group where stu_id in ($id)";
            $res2=DB::update($sql2);
            if($res2){
                $sql3="update man_student set stu_pid = 1 where stu_id = $zu_id";

                $res3=DB::update($sql3);
                if($res3){
                    $sql4="select stu_care from man_student where stu_id = $zu_id";
                    $res4=DB::select($sql4);
                    foreach($res4 as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $stu_care = $vv;
                        }
                    }
                    $sql5="select use_id from man_user where use_name = $stu_care";
                    $res5=DB::select($sql5);
                    foreach($res5 as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $use_id = $vv;
                        }
                    }
                    $sql5="update man_user_role set role_id = 3 where use_id = $use_id";
                    $res5=DB::update($sql5);
                    if($res5){
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
}
