<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	
	function create_password($pw_length = 4){
            $randpwd = '';
            for ($i = 0; $i < $pw_length; $i++){
                $randpwd .= chr(mt_rand(33, 126));
            }
            return $randpwd;
        }
        function generate_username( $length = 6 ) {
            // 密码字符集，可任意添加你需要的字符
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
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

