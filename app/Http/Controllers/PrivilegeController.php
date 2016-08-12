<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PrivilegeController extends CommonController
{
    /**
     * 用户列表
     */
    public function user()
    {
        $class = DB::table('man_class')->select('cla_id','cla_name')->where(['cla_pid' => 0])->get();
        $data=$users = DB::table('man_user')->leftjoin('man_class', 'man_user.cla_id', '=', 'man_class.cla_id')->paginate(10);
        return view('privilege/user',['class'=>$class,'data'=>$data]);
    }

    /**
     * 新增用户
     */
    public function userInfo(Request $request)
    {
        $user_name = $request->input('use_name');
        $user_pwd = $request->input('use_pwd');
        $user_names = $request->input('use_names');

        $preg = "/^\w{6,15}$/";
        if(!preg_match($preg,$user_name)){
            echo '用户名必须是6-15个字符';die;
        };
        $preg1 = "/^\w{6,15}$/";
        if(!preg_match($preg1,$user_pwd)){
            echo '密码必须是6-15个字符';die;
        };
//        $preg2 = "/^*{2,6}$/u";
//        if(!preg_match($preg2,$user_names)){
//            echo '名字必须为2-6个字符';die;
//        };

        $users = DB::table('man_user')->where(['use_name'=>$user_name])->get();
        if(!empty($users)){
            echo '用户名已存在';die;
        }
        $data['use_name'] =$user_name;
        $data['use_pwd'] =$user_pwd;
        $data['use_names'] =$user_names;

        $user_id = DB::table('man_user')->insertGetId($data);
        if($user_id){
            $re = DB::table('man_user_role')->insert(['use_id'=>$user_id,'role_id'=>8]);
            if($re){
               return redirect('privilege/user');
            }
        }
    }


    /**
     * 删除用户
     */
    public function userDel(Request $request)
    {
        $use_id = $request->input('use_id');
        $last_id = $request->input('last_id');
        if($use_id){
           $re = DB::table('man_user')->where(['use_id'=>$use_id])->delete();
           if($re){
               $res = DB::table('man_user_role')->where(['use_id'=>$use_id])->delete();
               if($res){
                   $data=$users = DB::table('man_user')->join('man_class', 'man_user.cla_id', '=', 'man_class.cla_id')->where('man_user.use_id','>',$last_id)->limit(1)->get();
                   if(empty($data)){
                       echo json_encode(['status'=>2]);
                   }else{
                       echo json_encode(['status'=>1,'msg'=>$data]);
                   }
               }else{
                   echo json_encode(['status'=>0,'error'=>'删除失败']);
               }
           }else{
               echo json_encode(['status'=>0,'error'=>'删除失败']);
           }
        }

    }
    /**
     * 初始化密码
     */
    public function userIni(Request $request)
    {
        $use_id = $request->input('use_id');
        if(isset($use_id)){
            $re = DB::table('man_user')->where(['use_id'=>$use_id])->update(['use_pwd'=>'111111']);
            if($re){
                echo json_encode(['status'=>1,'msg'=>'初始化成功']);
            }else{
                echo json_encode(['status'=>0,'error'=>'初始化失败']);
            }
        }
    }

    /**
     * 角色列表
     */
    public function role()
    {
        $data=$users = DB::table('man_role')->paginate(3);
        return view('privilege.role', ['data'=>$data]);
    }
    /**
     * 角色列表添加
     * */
    public function role_add(Request $request)
    {
        $data=$request->input();
        //print_r($data);
        $re = DB::table('man_role')->insert($data);
        if($re){
            return redirect('privilege/role');
            //echo "<script>alert('添加成功');location.href='{{URL()}}'</script>";
        }
    }
    /**
     * 角色名称的修改
     */
    public function role_update_name(){
        $role_id=$_POST['role_id'];
        $role_name=$_POST['role_name'];
        $re=DB::table('man_role')
            ->where('role_id', $role_id)
            ->update(['role_name' => "$role_name"]);
        echo $re;
    }
    /**
     * 角色描述的修改
     */
    public function role_update_intro(){
        $role_id=$_POST['role_id'];
        $role_intro=$_POST['role_intro'];
        $re=DB::table('man_role')
            ->where('role_id', $role_id)
            ->update(['role_intro' => "$role_intro"]);
        echo $re;
    }
    /**
     * 角色状态的修改
     */
    public function role_update_status(){
        $role_id=$_POST['role_id'];
        $role_status=$_POST['role_status'];
        $re=DB::table('man_role')
            ->where('role_id', $role_id)
            ->update(['role_status' => "$role_status"]);
        if($re){
            if($role_status==0){
                echo "<a  href='javascript:void (0)'  onclick='role_status($role_id,1)'>是</a>";
            }else{
                echo "<a  href='javascript:void (0)' style='color: red'  onclick='role_status($role_id,0)'>否</a>";
            }
        }else{
            echo 0;
        }
    }
    public function role_empower(){
        $role_id = $_GET['role_id'];
        $arr= DB::table('man_role')->where('role_id',"$role_id")->first();
        $role_name=$arr['role_name'];
        $data=DB::table('man_role_power')->select('pow_id')->where('role_id',"$role_id")->get();
        $pow_id=array();
        foreach($data as $k=>$v){
            $pow_id[]=$v['pow_id'];
        }
        //查询父类
        $list= DB::table('man_power')->get();
        $power=getTreeRole($list);
        foreach($power as $k=>$v){
            if(in_array($v['pow_id'],$pow_id)){
                $power[$k]['call']=1;
            }else{
                $power[$k]['call']=0;
            }
            foreach($v['son'] as $kk=>$vv){
                if(in_array($vv['pow_id'],$pow_id)){
                    $power[$k]['son'][$kk]['call']=1;
                }else{
                    $power[$k]['son'][$kk]['call']=0;
                }
            }
        }
        //print_r($power);
        return view('privilege.empower', ['role_name' => $role_name,'role_id' => $role_id,'power'=>$power]);
    }
    public function role_empower_add(Request $request){
        $arr=$request->input('pow_id');
        $role_id=$request->input('role_id');
        $role_power=DB::table('man_role_power')->where("role_id","$role_id")->delete();
        $pow=array();
        for($i=0;$i<count($arr);$i++){
            $pow[$i]['role_id']="$role_id";
            $pow[$i]['pow_id']="$arr[$i]";
        }
        $re=DB::table('man_role_power')->insert($pow);

        if($re){
            echo "<script>alert('授权成功')</script>";
            return redirect('privilege/role');
        }else{
            echo "<script>alert('授权失败')</script>";
            return redirect('privilege/role');
        }
    }
    /**
     * 删除角色
     */
    public function role_delete(){
        $role_id=$_POST['role_id'];
        $re=DB::table('man_role')
            ->where('role_id', $role_id)
            ->delete();
        echo $re;
    }
    /**
     * 权限列表
     */
    public function node()
    {
        //查询父类
        $list= DB::table('man_power')->get();
        $power=getTreeRole($list);
        //列表分页
        $data=$users = DB::table('man_power')->paginate(3);
        return view('privilege.node', ['power' => $power,'data'=>$data]);
    }
    /**
     * 权限的添加
     */
    public function node_add(Request $request)
    {
        $data=$request->input();
        //print_r($data);
        $re = DB::table('man_power')->insert($data);
        if($re){
            return redirect('privilege/node');
            //echo "<script>alert('添加成功');location.href='{{URL()}}'</script>";
        }
    }

    /**
     * 修改节点名称
     */
    public function node_update_name(){
        $pow_id=$_POST['pow_id'];
        $pow_name=$_POST['inputext'];
        $re=DB::table('man_power')
            ->where('pow_id', $pow_id)
            ->update(['pow_name' => "$pow_name"]);
        echo $re;
    }
    /**
     * 修改节点控制器名称
     */
    public function node_update_controller(){
        $pow_id=$_POST['pow_id'];
        $controller=$_POST['controller'];
        $re=DB::table('man_power')
            ->where('pow_id', $pow_id)
            ->update(['controller' => "$controller"]);
        echo $re;
    }
    /**
     * 修改节点方法名
     */
    public function node_update_action(){
        $pow_id=$_POST['pow_id'];
        $action=$_POST['action'];
        $re=DB::table('man_power')
            ->where('pow_id', $pow_id)
            ->update(['action' => "$action"]);
        echo $re;
    }
    /**
     * 修改节点描述
     */
    public function node_update_intro(){
        $pow_id=$_POST['pow_id'];
        $pow_intro=$_POST['pow_intro'];
        $re=DB::table('man_power')
            ->where('pow_id', $pow_id)
            ->update(['pow_intro' => "$pow_intro"]);
        echo $re;
    }
    /**
     * 删除节点
     */
    public function node_delete(){
        $pow_id=$_POST['pow_id'];
        $re=DB::table('man_power')
            ->where('pow_id', $pow_id)
            ->delete();
        echo $re;
    }
}

/**
 * 遍历出父类
 * @param $list
 * @param int $pow_pid
 * @return array
 */
function getTreeRole($list,$pow_pid=0){
    $arr=array();
    foreach($list as $k=>$v){
        if($v['pow_pid']==$pow_pid){
            $arr[$k]=$v;
            $arr[$k]['son']=getTreerole($list,$v['pow_id']);
        }
    }
    return $arr;
}