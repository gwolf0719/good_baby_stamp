<?php 
namespace App\Controllers;

class Api extends BaseController{
    /**
     * 新增寶寶
     */
    function babyAdd(){
        $cols = array('userId','babyDisplayName','babyAvatar','closeStamp');
        $required = array('userId','babyDisplayName');
        $data = $this->input->chkGetPost($cols, $required);
        
        if($data['babyAvatar'] == ''){$data['babyAvatar'] = 'https://i.pinimg.com/originals/1c/62/92/1c6292b7d8e5fe3808d0e36a62359b16.png';}
        if($data['closeStamp'] == ''){$data['closeStamp'] = 0;}
        $data['updateDatetime'] = date("Y-m-d H:i:s");
        $userId = $data['userId'];
        unset($data['userId']);
        $user = $this->moddb->chkDataApi('users',array('userId'=>$userId),'使用者不存在');
        if($this->babys->addOnce($data)){
            $babyId = $this->db->insertID();
            $this->babys->mapping($babyId,$userId,0);
            $this->api->show('200');
        }else{
            $this->api->show('500');
        }
    }
    // 寶寶資料更新
    function babyUpdate(){
        $cols = array('babyId','babyDisplayName','babyAvatar','closeStamp','level');
        $required = array('babyId','babyDisplayName');
        $data = $this->input->chkGetPost($cols, $required);
        $baby = $this->moddb->chkDataApi('babys',array('babyId'=>$data['babyId']),'寶寶不存在');
        foreach($data as $k=>$v){
            if($v != ""){
                $baby[$k] = $v;
            }
        }
        $baby['updateDatetime'] = date("Y-m-d H:i:s");
        $this->babys->updateOnce(array('babyId'=>$baby['babyId']),$baby);
        
        $this->api->show('200','',$this->db->getLastQuery());
    }

    // 設定寶寶配對
    function babySetMapping($userId,$babyId){
        $this->moddb->chkDataApi('babys',array('babyId'=>$babyId),'寶寶不存在');
        $this->moddb->chkDataApi('users',array('userId'=>$userId),'使用者不存在');
        $map = $this->babys->chkMapping($babyId,$userId) ;
        if($map == false){
            $this->babys->mapping($babyId,$userId,1);
            $this->api->show('200','配對完成');
        }else{
            if($map['level'] == 0){
                $this->api->show('500','擁有者不能解除配對');
            }else{
                $this->babys->unMapping($babyId,$userId);
                $this->api->show('200','解除配對完成');
            }
        }

    }
    function babyList($userId){
        $user = $this->moddb->chkDataApi('users',array('userId'=>$userId),'使用者不存在');
        $userBabys = $this->users->babyList($userId);
        $this->api->show('200','',$userBabys);
    }


    /******
     * 
     * 集點卡
     */
    function cardInfo($cardId){

    }
    function cardList($babyId){

    }
    function cardAdd(){
        $cols = array('babyId','subject','col','row');
        $required = array('babyId');
        $default = [
            'col'=>3,
            'row'=>3,
            'subject'=>'寶寶集點卡',
            'updateDatetime'=>date("Y-m-d H:i:s"),
            'checkData' => '{}'
        ];
        $data = $this->input->chkGetPost($cols, $required,'api',$default);
        $this->moddb->chkDataApi('babys',array('babyId'=>$data['babyId']),'寶寶不存在');
        $data['checkData'] = $this->card->cardCheckDataGrid($data['row'],$data['col']);
        if($this->card->addOnce($data)){
            $this->api->show('200');
        }else{
            $this->api->show('500');
        }
    }
    function cardUpdate(){

    }
    /**
     * 蓋章
     */
    function stampAdd(){
        $cols = array('userId','cardId','notice','cardNum');
        $required = array('userId','cardId','cardNum');
        $data = $this->input->chkGetPost($cols, $required);
        $user = $this->moddb->chkDataApi('users',array('userId'=>$data['userId']),'使用者不存在');
        $card = $this->moddb->chkDataApi('card',array('cardId'=>$data['cardId']),'卡片不存在');
        $baby = $this->moddb->chkDataApi('babys',array('babyId'=>$card['cardId']),'寶寶不存在');

        $cardData = json_decode($card['checkData'],true);
        if($cardData[$data['cardNum']]['status'] == 0){
            // 設定集點卡
            $cardData[$data['cardNum']]['status'] = 1;
            $setData['checkData'] = json_encode($cardData);
            $setData['updateDatetime'] = date("Y-m-d H:i:s");
            $this->card->updateOnce($data['cardId'],$setData);

            // 點數紀錄
            $data['babyId']= $card['babyId'];
            $data['initStamp'] = $baby['closeStamp'];
            $data['offsetStamp'] = 1;
            $data['closeStamp'] = $data['initStamp'] + $data['offsetStamp'];
            if($data['notice'] == ''){
                $data['notice'] = $user['displayName'].'給乖寶寶一個章';
            }
            unset($data['cardNum']);
            $this->card->setStampLog($data);
            // 回填總數
            $this->babys->updateOnce(array('babyId'=>$data['babyId']),array('closeStamp'=>$data['closeStamp'],'updateDatetime'=>date("Y-m-d H:i:s")));

            $this->api->show('200');
        }else{
            $this->api->show('500');
        }
        
        
    }
    function stampUse(){
        $cols = array('userId','cardId','notice');
        $required = array('userId','cardId');
        $data = $this->input->chkGetPost($cols, $required);
    }
}