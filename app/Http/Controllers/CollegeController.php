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
        //print_r($_SESSION);die;
        $se=$_SESSION['user'];
        if($se['cla_id']==0)
        {
            return redirect('index/right');die;
        }
        if($se['cla_id']==0){
            $users = DB::table('man_class')->where('cla_pid', '!=',0)->paginate(5);
            $list = DB::table('man_class')->where('cla_pid', '!=',0)->get();
            $xy=DB::table('man_class')->where('cla_pid','0')->get();
			//print_r($xy);die;
				//$arr=array();
				//print_r($arr);die;
			foreach($xy as $k=>$v){
				$arr=DB::table('man_class')->where('cla_pid',$v['cla_id'])->get();
				if(!empty($arr)){
					$jd[]=$arr;
				}
			}
			foreach($jd as $k=>$v){
				foreach($jd[$k] as $kk=>$vv){
					foreach($users as $kkk=>$vvv){
						//print_r($jd[$k][$kk]['cla_name']);
						if($jd[$k][$kk]['cla_name']==$users[$kkk]['cla_name']){
							unset($users[$kkk]);//删除$a数组同值元素
						}
							//print_r($users[$kkk]['cla_name']);
					}
				}
			}
			//print_r($jd);die;
			//print_r($users);die;
        }else{
//            print_r($se);die;
			$users=DB::table('man_class')->where('cla_pid', '=',$se['cla_id'])->paginate(5);
			//$str="";
            $us=DB::table('man_class')->where('cla_id', '=',$se['cla_id'])->first();
            $xy=DB::table('man_class')->where('cla_id', '=',$us['cla_pid'])->first();
            $xi=DB::table('man_class')->where('cla_pid', '=',$xy['cla_id'])->get();
            $xy=$xy['cla_name'];
            $jd=$us['cla_name'];
//            print_r($xy);
//            print_r($users);
//            print_r($us);die;
//			$ids = "";
//			foreach($list as $k=>$v){
//				//$str.="orwhere('cla_id','=',".$v['cla_id'].")->";
//				$ids .= ','.$v['cla_id'];
//			}
			//$pid = trim($ids,',');

//			$pid = trim($ids,',');
//			$new_pid = explode(',',$pid);
//			foreach($new_pid as $k=>$v){
//				$res[] = DB::table('man_class')->where(['cla_pid'=>$v])->paginate(5);
//			}
////print_r($res);die;
//			$users = "";
//			for($i=0;$i<count($res);$i++){
//				for($j=0;$j<count($res[$i]);$j++){
//					$users[] = $res[$i][$j];
//				}
		//	}
			//print_r($users);die;
			//echo $str;die;
			//print_r($list);die;
			//$strs=rtrim($str,'->');
			//echo $strs;die;
			//$user=DB::table("man_class")->select("select * from man_class where cla_id=2")->paginate(5);
			//print_r($user);die;
            //$users = DB::table('man_class')->where('cla_pid', '=',$se['cla_id'])-> $strs->paginate(5);
			//print_r($users);die;
//			$data=DB::table('man_class')->where('cla_pid', '=',2)->lists('cla_id');
//			//print_r($data);die;
//			$users=DB::table('man_class')
//            ->whereIn('cla_pid',$data)
//            ->paginate(5);
//			//print_r($page);die;
//
//
//			//$data=DB::select("SELECT * FROM `man_class` WHERE cla_pid in (SELECT cla_id FROM `man_class` WHERE cla_pid=2)")->paginate(5);
//			//print_r($data);die;
//            $list = DB::table('man_class')->where('cla_pid', '=',$se['cla_id'])->get();
//            $xy=DB::table('man_class')->where('cla_id',$se['cla_id'])->get();
//			foreach($xy as $k=>$v){
//				$arr=DB::table('man_class')->where('cla_pid',$v['cla_id'])->get();
//				if(!empty($arr)){
//					$jd[]=$arr;
//				}
//			}
////			print_r($arr);die;
//			//print_r($jd);die;
//			foreach($jd as $k=>$v){
//				foreach($jd[$k] as $kk=>$vv){
//					foreach($users as $kkk=>$vvv){
//						//print_r($jd[$k][$kk]['cla_name']);
//						if($jd[$k][$kk]['cla_name']==$users[$kkk]['cla_name']){
//							unset($users[$kkk]);//删除$a数组同值元素
//						}
//							//print_r($users[$kkk]['cla_name']);
//					}
//				}
//			}
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
       
//        for($i=0;$i<$count;$i++){
//            $users[$i]['url'] = 'aaaa';
//            //$users[$i].=array_push($users,'xy');
//        }
//        foreach($users as $k=>$v){
////            print_r($users[$k]);
//            $users['xy']=DB::table('man_class')->where('cla_id',$v['cla_pid'])->get();
//        }
//        print_r($users);die;
        return view('college.classlist',['users'=>$users,'xy'=>$xy,'jd'=>$jd,'xi'=>$xi]);
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
                    echo "<script>alert('修改成功');location.href='college';</script>";
                }else{
                    echo "<script>alert('修改失败');location.href='college';</script>";

                }
            }else{
                $id = DB::table('man_class')->insertGetId(
                    ['cla_name' =>"$name", 'cla_intro' => "$info"]
                );
                if($id){
					$userId = $this->generate_username(6);
                    $id = DB::table('man_user')->insertGetId(
                        array('use_name' => "$userId", 'use_pwd' => 123, 'use_names'=>"$name",'cla_id'=>"$id")
                    );
                    $users = DB::table('man_role')->where('role_name', "院长")->first();
                    if($users){
                         DB::table('man_user_role')->insertGetId(
                            array('use_id' => "$id", 'role_id' => $users['role_id'])
                        );
                            echo "<script>alert('账号为：".$userId.",密码为：123');location.href='college'</script>";
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
            echo "<script>alert('此信息下面有分类，不能删除！');location.href='college'</script>";die;
        }
        $user = DB::table('man_class')->where('cla_id', "$id")->first();
        $re=DB::table('man_class')->where('cla_id',"$id")->delete();
        if($re){
            $users = DB::table('man_user')->where('cla_id', $user['cla_id'])->first();
            $re=DB::table('man_user')->where('cla_id',$user['cla_id'])->delete();
            if($re){
                DB::table('man_user_role')->where('use_id', $users['use_id'])->first();
                $re=DB::table('man_user_role')->where('use_id',$users['use_id'])->delete();
                if($re){
                    echo "<script>alert('删除成功！');location.href='college'</script>";die;
                }else{
                    echo "<script>alert('删除失败！');location.href='college'</script>";die;
                }
            }else{
                echo "<script>alert('删除账号失败！');location.href='college'</script>";die;
            }


        }else{
            echo "<script>alert('删除学院失败');location.href='college'</script>";
        }
    }
    public  function classadd(){
        $id=$_POST['id'];
        $name=$_POST['cla_name'];
        $xy=$_POST['cla_pid'];
        $info=$_POST['cla_intro'];
		$cla_tea=$_POST['cla_tea'];
        $cla_mph=$_POST['cla_mph'];
		//print_r($_POST);die;
        $user = DB::table('man_class')->where('cla_name', "$name")->first();
        if($id){
            $re=DB::table('man_class')
                ->where('cla_id', "$id")
                ->update( ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_tea'=>"$cla_tea",'cla_mph'=>"$cla_mph",'cla_pid'=>"$xy"]);
            if($re){
                echo "<script>alert('修改成功');location.href='classes';</script>";
            }else{
                echo "<script>alert('修改失败');location.href='classes';</script>";

            }
        }else{
            $id = DB::table('man_class')->insertGetId(
                ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_tea'=>"$cla_tea",'cla_mph'=>"$cla_mph",'cla_pid'=>"$xy"]
            );
            if($id){
				$userId = $this->generate_username(6);
                $id = DB::table('man_user')->insertGetId(
                    array('use_name' => "$userId", 'use_pwd' => 123, 'use_names'=>"$name",'cla_id'=>"$id")
                );
                $users = DB::table('man_role')->where('role_name', "讲师")->first();
                if($users){
                    DB::table('man_user_role')->insertGetId(
                        array('use_id' => "$id", 'role_id' => $users['role_id'])
                    );
                    echo "<script>alert('账号为：".$userId.",密码为：123');location.href='classes';</script>";
                }else{
                    echo "<script>alert('没有相关角色，请先添加角色！');location.href='classes';</script>";die;
                }
            }else{
                echo "<script>alert('添加失败');location.href='classes';</script>";

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
public function jdes(){
	$se=$_SESSION['user'];
	//print_r($se);die;
        if($se['cla_id']==0){
			return redirect('index/right');die;
		}else{
			 $user = DB::table('man_class')->where('cla_pid', $se['cla_id'])->paginate(5);
			$xy=$se['use_names'];
		}
		 return view('college.jdlist',['users'=>$user,'xy'=>$xy]);
}
public function jdadd(){
	$se=$_SESSION['user'];
	$pid=$se['cla_id'];
	 $id=$_POST['id'];
        $name=$_POST['cla_name'];
        $info=$_POST['cla_intro'];
        $user = DB::table('man_class')->where('cla_name', "$name")->first();
        if($id){
                $re=DB::table('man_class')
                    ->where('cla_id', "$id")
                    ->update( ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_pid'=>"$pid"]);
                if($re){
                    echo "<script>alert('修改成功');location.href='jdes';</script>";
                }else{
                    echo "<script>alert('修改失败');location.href='jdes';</script>";

                }
            }else{
                $id = DB::table('man_class')->insertGetId(
                    ['cla_name' =>"$name", 'cla_intro' => "$info",'cla_pid'=>"$pid"]
                );
                if($id){
					$userId = $this->generate_username(6);
                    $id = DB::table('man_user')->insertGetId(
                        array('use_name' => "$userId", 'use_pwd' => 123, 'use_names'=>"$name",'cla_id'=>"$id")
                    );
                    $users = DB::table('man_role')->where('role_name', "系主任")->first();
                    if($users){
                         DB::table('man_user_role')->insertGetId(
                            array('use_id' => "$id", 'role_id' => $users['role_id'])
                        );
                            echo "<script>alert('账号为：".$userId.",密码为：123');location.href='jdes'</script>";
                    }else{
                        echo "<script>alert('没有相关角色，请先添加角色！');location.href='jdes'</script>";die;
                    }
                }else{
                    echo "<script>alert('添加失败');location.href='jdes'</script>";die;

                }
         }
}





 function create_password($pw_length = 4){
            $randpwd = '';
            for ($i = 0; $i < $pw_length; $i++){
                $randpwd .= chr(mt_rand(33, 126));
            }
            return $randpwd;
        }
    public    function generate_username( $length = 6 ) {
            // 密码字符集，可任意添加你需要的字符
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = '';
            for ( $i = 0; $i < $length; $i++ )
            {
                // 这里提供两种字符获取方式
                // 第一种是使用substr 截取$chars中的任意一位字符；
                // 第二种是取字符数组$chars 的任意元素
                // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
                $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
            }
            return $password;
        }
}
