<?php namespace App\Libraries;
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\Api;
/****************************************************************
 * 
 * 檢查 Input 格式正確性 
 * CI4_Lib_Input_2021_0204
 * 
 */


class Input{
    function chkGetPost($data,$requred = array(),$type="api",$default=""){
        $request = service('request');
        $res = [];
        foreach ($data as $key => $value) {
			# code...
            if (in_array($value, $requred)) {
                if ($request->getGetPost($value) == "") {
                    if($type == 'api'){
                        $this->api  = new Api();
                        $this->api->show('000');
                    }else{
                        return false;
                    }
                    
                } else {
                    $res[$value] = $request->getGetPost($value);
                }
            } else {
                $res[$value] = $request->getGetPost($value);
            }
        }
        if($default == ''){
            return $res;
        }else{
            return $this->setDefault($res,$default);
        }
        
    }
    // 檢查必填資料，沒有被填寫到的資料就會被丟回陣列回傳
    function reportRequred($data)
    {
        $request = service('request');
        $res = array();
        foreach ($data as $key => $value) {
            if ($request->getGetPost($value) == "") {
                $res[] = $value;
            }
        }
        return $res;
    }
    function setDefault($originData,$default){
        foreach($default as $k=>$v){
            if(empty($originData[$k])){
                $originData[$k] = $v;
            }else{
                if($originData[$k] == ''){
                    $originData[$k] = $v;
                }
            }
            
        }
        return $originData;
    }
}