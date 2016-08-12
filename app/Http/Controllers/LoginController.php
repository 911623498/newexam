<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LoginController extends Controller
{
    /**
     * 登录
     */
    public function login()
    {
        return view('login');
    }

    /**
     * 登录处理
     */
    public function loginInfo(Request $request)
    {
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');
        if (empty($user_name)) {
            echo json_encode(['status' => 0, 'error' => '用户名不能为空']);
            die;
        }
        if (empty($user_pwd)) {
            echo json_encode(['status' => 0, 'error' => '密码不能为空']);
            die;
        }
        $user = DB::table('man_user')->select('use_id', 'use_names', 'cla_id','use_time')->where(['use_name' => $user_name, 'use_pwd' => $user_pwd])->first();
        if (!$user) {
            echo json_encode(['status' => 0, 'error' => '用户名密码不正确']);
            die;
        } else {

            session_start();
            //session 存储信息
            $_SESSION['user'] = $user;
            //查看是否是admin
            if($user['use_id'] != 1){
                //查询权限
                $role =  DB::table('man_user_role')->select('role_id')->where([ 'use_id' => $user['use_id']])->first();
                if($role){
                    $power = $this->power($role);
                    //角色id
                    $_SESSION['user']['role_id'] =  $role['role_id'];
                    //权限
                    $_SESSION['user']['power'] = $power;
                    $left = $this->leftshow();
                    foreach ($power as $key => $value) {
                        $access[$key]['bs']=$value['pow_name'];
                        $access[$key]['type']=$left[$value['pow_name']];
                        foreach ($value['son'] as $k => $val) {
                            if(isset($left[$val['pow_name']])){
                                $access[$key]['son'][$k]['bs']=$val['pow_name'];
                                $access[$key]['son'][$k]['url']=$left[$val['pow_name']];
                            }
                        }
                    }
                    //获取右侧导航栏
                    $_SESSION['user']['left'] = $access;
                }
            }
            //修改登录时间和登录ip
            DB::table('man_user')->where([ 'use_id' => $user['use_id']])->update(['use_time'=>date('Y-m-d H:i:s',time()),'use_ip'=>$_SERVER['REMOTE_ADDR']]);
            echo json_encode(['status' => 1, 'msg' => '登录成功']);
        }
    }

    public function leftshow(){
        return [
            '权限管理'=>1,
            '考试周期管理'=>2,
            '学院管理'=>3,
            '组建管理'=>4,
            '成绩管理'=>5,
            '成才率统计'=>6,
            '用户管理'=>'privilege/user',
            '角色管理'=>'privilege/role',
            '权限管理'=>'privilege/node',
            '考试周期列表'=>'exam/exam_list',
            '考试周期录入'=>'exam/record',
            '学院列表'=>'college/college',
            '班级列表'=>'college/classes',
            '添加学生信息'=>'group/ad_stu_massage',
            '学生信息PK列表'=>'group/chose_grouper',
            '学生信息列表'=>'group/group_list',
            '分配小组' => 'group/fp_group',
            '查看成绩'=>'grade/look',
            '录入成绩'=>'grade/record',
            '每日成才率'=>'yield/index',
            '周考成才率'=>'yield/zk'

        ];

    }

    /**
     * 获取权限
     */
    public function power($role,$pid = 0){
        $arr = DB::table('man_role_power')
            ->join('man_power', 'man_role_power.pow_id', '=', 'man_power.pow_id')
            ->where(['man_role_power.role_id' => $role['role_id'],'pow_pid'=>$pid])
            ->get();
        //print_r($arr);die;
        foreach($arr as $key => $val) {
            $arr[$key]['son'] = $this->power($role, $pid = $val['pow_id']);
        }
        return $arr;
    }
    /**
     * 调用错误页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error(Request $request){
        $errorstatus = $request->status;
        switch($errorstatus){
            case 1:
                $error_msg = '非法请求,请登录!';
                break;
            case 2:
                $error_msg = '此账号已登录,请重新登录';
                break;
            case 3:
                $error_msg = '无此权限';
                break;
        }

        return view('error',['error'=>$error_msg]);
    }



    /**
     * 退出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginOut(){
        session_start();
        unset($_SESSION['user']);
        return redirect('/');
    }

    /**
     * 修改密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPwd(){
       return view('reset');
    }

    /*
     * 修改密码验证
     */
    public function repwdAjax(Request $request){
        session_start();
        $use_id = $_SESSION['user']['use_id'];
        $oldpwd = $request->oldpwd;
        $arr = DB::table('man_user')->select( 'use_pwd')->where(['use_id' => $use_id,])->first();
       if($oldpwd == $arr['use_pwd']){
           return  1;
       }else{
           return 0;
       }
    }

    public function repwdInfo(Request $request){
        session_start();
        $use_id = $_SESSION['user']['use_id'];
        $oldpwd = $request->oldpwd;
        $newpwd = $request->newpwd;
        $arr = DB::table('man_user')->select( 'use_pwd')->where(['use_id' => $use_id,])->first();
        if($oldpwd =! $arr['use_pwd']){
            return 0;
        }else{
            $re = DB::table('man_user')->select('use_pwd')->where(['use_id' => $use_id,])->update(['use_pwd'=>$newpwd]);
            if($re){
                return 1;
            }else{
                return 0;
            }
        }
    }
}
