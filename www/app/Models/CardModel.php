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
                $n = $n + 1;
                $res[$n]['cradNum'] =  $n;
                $res[$n]['row'] =  $k;
                $res[$n]['col'] =  $i;
                $res[$n]['status'] =  0;
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
    
    

    function setStampLog($data){
        $data['updateDatetime'] = date("Y-m-d H:i:s");
        $this->db->table('stampLog')->set($data)->insert();
        return $this->db->affectedRows();

    }
}