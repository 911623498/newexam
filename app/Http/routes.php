<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** 登录页面 */
Route::get('/','LoginController@login');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    /** 首页 */
    Route::any('index/index','IndexController@index');
    Route::any('index/left',function(){
        return view('public/left');
    });
    Route::any('index/top',function(){
        return view('public/top',array('time'=>time()));
    });
    Route::any('index/right',function(){
        return view('public/right');
    });


    /** 权限管理 */
    Route::any('privilege/user','PrivilegeController@user'); //用户
    Route::any('privilege/userInfo','PrivilegeController@userInfo'); //用户增加
    Route::any('privilege/userDel','PrivilegeController@userDel'); //用户删除
    Route::any('privilege/userIni','PrivilegeController@userIni'); //用户密码初始化


    Route::any('privilege/role','PrivilegeController@role'); //角色
    Route::any('privilege/role_add','PrivilegeController@role_add'); //角色添加
    Route::any('privilege/role_update_name','PrivilegeController@role_update_name'); //角色名称修改
    Route::any('privilege/role_update_intro','PrivilegeController@role_update_intro'); //角色描述修改
    Route::any('privilege/role_update_status','PrivilegeController@role_update_status'); //角色状态修改
    Route::any('privilege/role_delete','PrivilegeController@role_delete'); //角色删除
    Route::any('privilege/role_empower','PrivilegeController@role_empower'); //角色赋权
    Route::any('privilege/role_empower_add','PrivilegeController@role_empower_add'); //角色赋权添加

    Route::any('privilege/node','PrivilegeController@node'); //权限节点
    Route::any('privilege/node_add','PrivilegeController@node_add'); //权限节点的添加
    Route::any('privilege/node_update','PrivilegeController@node_update'); //权限节点的修改
    Route::any('privilege/node_update_name','PrivilegeController@node_update_name'); //权限节点名称的修改
    Route::any('privilege/node_update_controller','PrivilegeController@node_update_controller'); //权限节点控制器的修改
    Route::any('privilege/node_update_action','PrivilegeController@node_update_action'); //权限节点方法名的修改
    Route::any('privilege/node_update_intro','PrivilegeController@node_update_intro'); //权限节点描述的修改
    Route::any('privilege/node_delete','PrivilegeController@node_delete'); //权限节点删除

    /** 登录 **/
    Route::any('login/login','LoginController@login'); //登录页面
    Route::any('login/loginInfo','LoginController@loginInfo'); //登录处理
    Route::any('login/error','LoginController@error'); //登录处理
    Route::any('login/loginOut','LoginController@loginOut'); //退出
    Route::any('login/resetPwd','LoginController@resetPwd'); //修改密码
    Route::any('login/repwdAjax','LoginController@repwdAjax'); //检测密码
    Route::any('login/repwdInfo','LoginController@repwdInfo'); //密码修改


    /** 考试周期管理 */
    Route::any('exam/exam_list','ExamController@exam_list'); //考试周期列表
    Route::any('exam/record','ExamController@record'); //考试周期录入
    Route::any('exam/save','ExamController@save'); //考试周期添加
    Route::any('exam/type_list','ExamController@type_list'); //考试类型选择
    Route::any('exam/exam_status','ExamController@exam_status'); //考试类型选择



    /** 学院管理 */
    Route::any('college/college','CollegeController@college'); //学院列表
    Route::any('college/classes','CollegeController@classes'); //考试周期列表
    Route::any('college/claadd','CollegeController@claadd'); //添加学院
    Route::any('college/cladel','CollegeController@cladel'); //删除学院
    Route::any('college/claweiyi','CollegeController@claweiyi'); //学院班级唯一
    Route::any('college/classadd','CollegeController@classadd'); //添加学院
    Route::any('college/pkclass','CollegeController@pkclass'); //pk班级

    Route::any('college/jdes','CollegeController@jdes'); //阶段列表
    Route::any('college/jdadd','CollegeController@jdadd'); //添加阶段

    /** 组建管理 */
    Route::any('group/ad_stu_massage','GroupController@ad_stu_massage'); //添加学生信息页面
    Route::any('group/addin_data','GroupController@addin_data'); //添加学生信息
    Route::any('group/chose_grouper','GroupController@allot'); //学生信息PK列表
    Route::any('group/group_list','GroupController@group_list'); //学生信息列表
    Route::any('group/group_pk','GroupController@group_pk'); //学生信息列表
    Route::any('group/sczh','GroupController@sczh'); //学生信息生成账号
    Route::any('group/stu_del','GroupController@stu_del'); //学生信息删除
    Route::any('group/daoru','GroupController@daoru'); //学生信息导入
    Route::any('group/fp_group','GroupController@fp_group'); //分配小组
    Route::any('group/fenpei','GroupController@fenpei'); //学院小组




    /** 成绩管理 */
    Route::any('grade/look','GradeController@look'); //查看成绩
    Route::any('grade/record','GradeController@record'); //录入成绩
    Route::any('grade/upgrade','GradeController@upgrade'); //修改成绩
    Route::any('grade/check','GradeController@check'); //成绩审核(通过)
    Route::any('grade/no_check','GradeController@no_check'); //成绩审核(不通过)
    Route::any('grade/look_class','GradeController@look_class'); //教务查看班级成绩
    Route::any('grade/sel_class','GradeController@sel_class'); //教务搜索班级成绩
    Route::any('grade/sel_class1','GradeController@sel_class1'); //教务搜索班级成绩
    Route::any('grade/addgrad','GradeController@addgrad'); //录入成绩
    Route::any('grade/test','GradeController@test'); //小组列表
    Route::any('grade/sel_classs','GradeController@sel_classs'); //学院查看专业下班级
    Route::any('grade/sel_xi','GradeController@sel_xi'); //校长查看学院下系

    Route::any('grade/look_check','GradeController@look_check'); //查看未审核列表
    Route::any('grade/check_exam','GradeController@check_exam'); //查看未审核列表
    Route::any('grade/exam_insert','GradeController@exam_insert'); //查看未审核列表
    Route::any('grade/exam_update','GradeController@exam_update'); //查看未审核列表
    Route::any('grade/exam_info','GradeController@exam_info'); //查看未审核列表
    Route::any('grade/dc','GradeController@dc'); //导出
    Route::any('grade/sel_classs','GradeController@sel_classs'); //导出


    /** 成才率统计 */
    Route::any('yield/index','YieldController@index'); //成才率
    Route::any('yield/yields','YieldController@yields'); //每日成才率
    Route::any('yield/zk','YieldController@zk'); //周考成才率
    Route::any('yield/img','YieldController@img'); //每周成才率
    Route::any('index/right','IndexController@right');

    /*消息*/
    Route::any('index/news','IndexController@news'); //消息



});
