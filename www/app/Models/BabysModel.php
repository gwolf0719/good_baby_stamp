<?php 
namespace App\Models;
use CodeIgniter\Model;
class BabysModel extends Model{
    function __construct()
    {   
        $this->db = \Config\Database::connect();
    }
    
    function addOnce($data){
        $this->db->table('babys')->insert($data);
        return $this->db->affectedRows();
    }
    function chkOnce($babyId){
        $res = $this->db->table('babys')->where('babyId',$babyId)->get()->getRowArray();
        if($res  == ''){
            return false;
        }else{
            return $res;
        }
    }
    function updateOnce($where,$set){
        $this->db->table('babys')->where($where)->set($set)->update();
        return $this->db->affectedRows();
    }
    function mapping($babyId,$userId,$level=0){
        $data = array(
            'babyId'=>$babyId,
            'userId'=>$userId,
            'level'=>$level
        );
        $this->db->table('userBabyMap')->insert($data);
        return $this->db->affectedRows();
    }
    function unMapping($babyId,$userId){
        $where = array(
            'babyId'=>$babyId,
            'userId'=>$userId
        );
        $this->db->table('userBabyMap')->where($where)->delete();
        return true;
    }
    function chkMapping($babyId,$userId){
        $where = array(
            'babyId'=>$babyId,
            'userId'=>$userId
        );
        $map = $this->db->table('userBabyMap')->where($where)->get()->getRowArray();
        if($map == ""){
            return false;
        }else{
            return $map;
        }
    }
}