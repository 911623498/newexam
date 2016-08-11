<?php

namespace App\Http\Controllers;
use DB;
use Redirect;
use Session;
class CollegeController extends CommonController
{
    /**
     * 学院列表
     */
    public function college()
    {
			$users = DB::table('man_class')->where('cla_pid','0')->paginate(5);
            $arr = DB::table('man_class')->where('cla_pid','0')->get();
            //var_dump($arr);die;
            $count=count($arr);
        return view('college.collegelist',['users'=>$users,'count'=>$count]);
    }

    /**
     * 班级列表
     */
    public function classes()
    {
//        session_start();
        $se=$_SESSION['user'];
        if($se['cla_id']==0){
            $users = DB::table('man_class')->where('cla_pid', '!=',0)->paginate(5);
            $list = DB::table('man_class')->where('cla_pid', '!=',0)->get();
            $xy=DB::table('man_class')->where('cla_pid','0')->get();
        }else{
            $users = DB::table('man_class')->where('cla_pid', '=',$se['cla_id'])->paginate(5);
            $list = DB::table('man_class')->where('cla_pid', '=',$se['cla_id'])->get();
            $xy=DB::table('man_class')->where('cla_id',$se['cla_id'])->get();
        }
        ///var_dump($users);die;
        //var_dump($users->items->items);die;
//        foreach($users as $k=>$v){
//            foreach($xy as $kk=>$vv){
//                if($v['cla_pid']==$vv['cla_id']){
//                    echo $xy[$kk]['xy']=$vv['cla_name'];
//                }
//            }
//        }
//        print_r($users);die;
       //print_r($users);die;
//        $arr=$users['items'];
//        var_dump($arr);die;
        $count=count($list);
//        for($i=0;$i<$count;$i++){
//            $users[$i]['url'] = 'aaaa';
//            //$users[$i].=array_push($users,'xy');
//        }
//        foreach($users as $k=>$v){
////            print_r($users[$k]);
//            $users['xy']=DB::table('man_class')->where('cla_id',$v['cla_pid'])->get();
//        }
//        print_r($users);die;
        return view('college.classlist',['users'=>$users,'count'=>$count,'xy'=>$xy]);
    }
    /*
     * 添加学院
     * */
    public function claadd()
    {
        $id=$_POST['id'];
        $name=$_POST['cla_name'];
        $info=$_POST['cla_intro'];
        $user = DB::table('man_class')->where('cla_name', "$name")->first();
        if($id){
                $re=DB::table('man_class')
                    ->where('cla_id', "$id")
                    ->update( ['cla_name' =>"$name", 'cla_intro' => "$info"]);
                if($re){
                    echo "<script>alert('修改成功');location.href='college'</script>";
                }else{
                    echo "<script>alert('修改失败');</script>";

                }
            }else{
                $id = DB::table('man_class')->insertGetId(
                    ['cla_name' =>"$name", 'cla_intro' => "$info"]
                );
                if($id){
                    $id = DB::table('man_user')->insertGetId(
                        array('use_name' => "$name", 'use_pwd' => 123, 'use_names'=>"$name",'cla_id'=>"$id")
                    );
                    $users = DB::table('man_role')->where('role_name', "教务")->first();
                    if($users){
                         DB::table('man_user_role')->insertGetId(
                            array('use_id' => "$id", 'role_id' => $users['role_id'])
                        );
                            echo "<script>alert('添加成功！');location.href='college'</script>";
                    }else{
                        echo "<script>alert('没有相关角色，请先添加角色！');location.href='college'</script>";die;
                    }
                }else{
                    echo "<script>alert('添加失败');location.href='college'</script>";die;

                }
         }

    }
    /*
     * 验证学院唯一
     **/
    public function claweiyi()
    {
        $id=$_POST['id'];
        $name=$_POST['cla_name'];
        $user = DB::table('man_class')->where('cla_name', "$name")->first();
        if(!empty($user)){
            echo 1;
        }
    }
    /*
     * 删除学院
     * */

    public function cladel()
    {
        $id=$_GET['id'];
        $user = DB::table('man_class')->where('cla_pid', "$id")->first();
        if($user){
            echo "<script>alert('此信息下面有分类，不能删除！');location.href='classes'</script>";die;
        }
        $user = DB::table('man_class')->where('cla_id', "$id")->first();
        $re=DB::table('man_class')->where('cla_id',"$id")->delete();
        if($re){
            $users = DB::table('man_user')->where('use_name', $user['cla_name'])->first();
            $re=DB::table('man_user')->where('use_name',$user['cla_name'])->delete();
            if($re){
                DB::table('man_user_role')->where('use_id', $users['use_id'])->first();
                $re=DB::table('man_user_role')->where('use_id',$users['use_id'])->delete();
                if($re){
                    echo "<script>alert('删除成功！');location.href='classes'</script>";die;
                }else{
                    echo "<script>alert('删除失败！');location.href='classes'</script>";die;
                }
            }else{
                echo "<script>alert('删除账号失败！');location.href='classes'</script>";die;
            }


        }else{
            echo "<script>alert('删除学院失败');location.href='classes'</script>";
        }
    }
    public  function classadd(){
        $id=$_POST['id'];
        $name=$_POST['cla_name'];
        $xy=$_POST['cla_pid'];
        $info=$_POST['cla_intro'];
        $user = DB::table('man_class')->where('cla_name', "$name")->first();
        if($id){
            $re=DB::table('man_class')
                ->where('cla_id', "$id")
                ->update( ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_pid'=>"$xy"]);
            if($re){
                echo "<script>alert('修改成功');location.href='classes'</script>";
            }else{
                echo "<script>alert('修改失败');</script>";

            }
        }else{
            $id = DB::table('man_class')->insertGetId(
                ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_pid'=>"$xy"]
            );
            if($id){

                $id = DB::table('man_user')->insertGetId(
                    array('use_name' => "$name", 'use_pwd' => 123, 'use_names'=>"$name",'cla_id'=>"$id")
                );
                $users = DB::table('man_role')->where('role_name', "讲师")->first();
                if($users){
                    DB::table('man_user_role')->insertGetId(
                        array('use_id' => "$id", 'role_id' => $users['role_id'])
                    );
                    echo "<script>alert('添加成功！');location.href='classes'</script>";
                }else{
                    echo "<script>alert('没有相关角色，请先添加角色！');location.href='classes'</script>";die;
                }
            }else{
                echo "<script>alert('添加失败');</script>";

            }
        }

    }
public function pkclass(){
    $id=$_POST['id'];
    $name=$_POST['cla_name'];
    $user = DB::table('man_class')->where('cla_name', "$name")->first();
    if($user){
//        print_r($user);
        $pk = DB::table('man_class')->where('cla_id', "$id")->first();
        if($user['cla_pid']==$pk['cla_pid']){
            $re=DB::table('man_class')
                ->where('cla_id', "$id")
                ->update( ['cla_pk'=>$user['cla_name']]);
            $re=DB::table('man_class')
                ->where('cla_id', $user['cla_id'])
                ->update( ['cla_pk'=>$pk['cla_name']]);
            echo "1";
        }else{
            echo "2";
        }
    }else{
        echo "0";
    }
}
}
