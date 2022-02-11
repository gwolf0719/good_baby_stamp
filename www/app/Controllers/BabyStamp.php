<?php 
namespace App\Controllers;
class BabyStamp extends BaseController{

    //會員登入
    function login(){
        
        // 產生登入連結
        $redirect_uri = "https://9ddc-114-33-44-37.ngrok.io/BabyStamp/login";
        $client_id = '1656875330';
        $login_link = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&state=12345abcde&scope=profile%20openid&nonce=09876xyz';
        $data = array(
            'login_link'=>$login_link
        );

        // 從code 取得 id_token
        if(!empty($_GET['code'])){
            $postData['grant_type'] = 'authorization_code';
            $postData['code'] = $_GET['code'];
            $postData['redirect_uri'] = $redirect_uri;
            $postData['client_id'] = $client_id;
            $postData['client_secret'] = '2aff51df180dae1776c938bc8e8dd1f4';
            $curl_link = 'https://api.line.me/oauth2/v2.1/token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded'
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); 
            curl_setopt($ch,CURLOPT_URL,$curl_link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result,true);
            
            if(!empty($result['id_token'])){
                $id_token = $result['id_token'];
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('id_token'=>$id_token,'client_id'=>$client_id))); 
                curl_setopt($ch,CURLOPT_URL,'https://api.line.me/oauth2/v2.1/verify');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
                $result = curl_exec($ch);
                $result = json_decode($result,true);
                
                curl_close($ch);
                if(!empty($result['sub'])){
                    
                    $user['userId'] = $result['sub'];
                    $user['displayName'] = $result['name'];
                    $user['pictureUrl'] = $result['picture'];
                    $this->users->setUser($user);
                    $this->users->setLoginStatus($user);
                    
                    return redirect()->to('https://'.$_SERVER['HTTP_HOST'].'/BabyStamp/BabyList/'.$this->users->chkLoginStatus());
                }else{
                    echo 'get user error';
                }
                
            }else{
                echo 'get id_token error';
            }
        }
        return view('BabyStamp/login',$data);
    }
    // 寶寶列表
    function BabyList($userId){
        $user = $this->users->chkOnce($userId);
        if($user == false){return view('errors/html/error_404');}

        $userBabys = $this->users->babyList($userId);
        
        $viewData = array(
            'user'=>$user,
            'userBabys'=>$userBabys
        );
        return view('BabyStamp/BabyList',$viewData);
    }
    function BabyCards($babyId){
        echo $babyId;
    }
}