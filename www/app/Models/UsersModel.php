<?php 
namespace App\Models;
use CodeIgniter\Model;
class UsersModel extends Model{
    
    function __construct()
    {   
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }    


    function setUser($data){
        $user = $this->chkOnce($data['userId']);
        if($user == false){
            $this->db->table('users')->set($data)->insert();
        }else{
            $this->db->table('users')->where('userId',$data['userId'])->set($data)->update();
        }
    }
    function setLoginStatus($user){
        $this->session->set($user);
    }
    function chkLoginStatus(){
        if(!$this->session->has('userId')){
            return false;
        }else{
            return $this->session->userId;
        }
    }
    


    function chkOnce($userId){
        $data = $this->db->table('users')->where(array('userId'=>$userId))->get()->getRowArray();
        if($data == ""){
            return false;
        }else{
            return $data;
        }
    }
    function babyList($userId){
        if($this->chkOnce($userId)){
            $datalist = $this->db->table('userBabyMap')
                                    ->where(array('userId'=>$userId))
                                    ->join('babys','userBabyMap.babyId=babys.babyId')
                                    ->orderBy('babys.updateDatetime','DESC')
                                    ->get()->getResultArray();
            return $datalist;
        }else{
            return false;
        }
    }
}