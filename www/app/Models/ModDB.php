<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Api;



class ModDB extends Model{
    function __construct(){
        $this->db = \Config\Database::connect();
    }
    // 設定開始和結束區間條件
    function setWhereStartEnd($oldWhere,$column="createDatetime",$start="",$end=""){
        if($start == ""){
            if(isset($_REQUEST['start'])){
                $start = $_REQUEST['start'];
            }
        }
        if($end == ""){
            if(isset($_REQUEST['end'])){
                $end = $_REQUEST['end'];
            }
        }
        if($start == "" || $end == ""){
            return $oldWhere;
        }
        $where = array(
            "$column >="    => $start,
            "$column <="    => $end
        );
        return array_merge($oldWhere,$where);
    }

    // 如果資料不存在就新增
    function insertOrUpdate($table="",$where=array(),$data=array()){
        if($this->chkOnce($where,$table)){
            $this->db->table($table)->where($where)->set($data)->update();
        }else{
            foreach($where as $k=>$v){
                $data[$k] = $v;
            }
            $this->db->table($table)->set($data)->insert();
        }
    }

    // 確認單一資料存在
    function chkOnce($where,$table){
        $b = $this->db->table($table);
        $b->where($where);
        if($b->countAllResults() == 0){
            return false;
        }else{
            return true;
        }
    }

    function findColExplode($table,$column,$value,$where=""){
        $db = $this->db->table($table);
        if($where != ""){
            $db->where($where);
        }
        $datas = $db->like($column,$value)->get()->getResultArray();
        $new_datas = [];
        foreach ($datas as $k => $v) {
            # code...
            if(in_array($value,explode(',',$v[$column]))){
                $new_datas[] = $v;
            }
        }
        return $new_datas;
    }
    /******
     * 
     * 快速 api 驗證
     * 
     */
    
    function chkDataApi($table,$where,$er_msg='',$exist=true){
        $this->api = new Api();
        
        $data = $this->db->table($table)->where($where)->get()->getRowArray();
        
        if($exist == true){ // 如果是驗證存在
            if($data == ""){
                $this->api->show('404',$er_msg); // 回傳不存在
            }else{
                return $data;
            }
        }else{
            if($data != ""){
                $this->api->show('500',$er_msg); //回傳重複
            }
        }
        return true;
    }
    
}