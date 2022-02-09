<?php 
namespace App\Controllers;
class BabyStamp extends BaseController{

    //會員登入
    function login(){
        return view('BabyStamp/login');
    }
    // 寶寶列表
    function BabyList($userId){
        $user = $this->users->chkOnce($userId);
        if($user == false){return view('errors/html/error_404');}
        $userBabys = $this->users->babyList($userId);
        
        print_r($userBabys);
    }
    // 蒐集本設定
    function PaperSetting(){

    }
    // 蒐集紙清單
    function PaperList(){

    }
    // 蒐集紙
    function PaperInfo(){

    }
}