<?php namespace App\Libraries;

class Api{
    function show($sys_code,$sys_msg='',$data=''){
        if($sys_msg == '' ){
            switch ($sys_code) {
                case '000':
                    # code...
                    $sys_msg = 'Data input error';
                    break;
                case '200':
                    # code...
                    $sys_msg = '成功！';
                    break;
                case '500':
                    $sys_msg = '喔喔！出現問題了！';
                    break;
                case '501':
                    $sys_msg = 'Duplicate Data';
                    break;
                case '404':
                    $sys_msg = 'Data Not Found';
                    break;
                default:
                    # code...
                    $sys_msg = "Other Msg";
                    break;
            }
        }
        $json_arr['sys_msg'] = $sys_msg;
        if($data != ""){
            $json_arr['data'] = $data;
        }
        $json_arr['sys_code'] = $sys_code;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($json_arr);
        exit();
    }
}