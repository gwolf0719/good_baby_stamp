<?php 
namespace App\Models;
use CodeIgniter\Model;
class CardModel extends Model{
    function __construct()
    { 
        $this->db = \Config\Database::connect();
    }
    // 建立空白集點卡矩陣
    function cardCheckDataGrid($row,$col){
        $res = [];
        $n = 0;
        for($i=1;$i<=$col;$i++){
            for($k=1;$k<=$row;$k++){
                $res[] = array(
                    'cardNum'=>$n,
                    'row'=>$k,
                    'col'=>$i,
                    'status'=>0
                );
                $n = $n + 1;
            }
        }
        return json_encode($res);

    }

    function addOnce($data){
        $this->db->table('card')->set($data)->insert();
        return $this->db->affectedRows();
    }
    function updateOnce($cardId,$data){
        $this->db->table('card')->set($data)->where('cardId',$cardId)->update();
        return $this->db->affectedRows();
    }
    function getOnce($cardId){
        $data = $this->db->table('card')->where('cardId',$cardId)->get()->getRowArray();
        return $data;
    }
    function chkOnce($cardId){
        $res = $this->db->table('card')->where('cardId',$cardId)->get()->getRowArray();
        if($res  == ''){
            return false;
        }else{
            return $res;
        }
    }
    function getList($babyId){
        $data = $this->db->table('card')->where('babyId',$babyId)->orderBy('updateDatetime','Desc')->get()->getResultArray();
        return $data;
    }
    
    /**
     * 
     * 
     * Stamp
     * 
     * 
     */

    function setStampLog($data){
        $data['updateDatetime'] = date("Y-m-d H:i:s");
        $this->db->table('stampLog')->set($data)->insert();
        return $this->db->affectedRows();
    }
    function getStampLog($cardId){
        $data = $this->db->table('stampLog')->where('cardId',$cardId)
                ->join('users','stampLog.userId=users.userId')
                ->orderBy('stampLog.updateDatetime','Desc')->get()->getResultArray();
        return $data;
    }
    
}