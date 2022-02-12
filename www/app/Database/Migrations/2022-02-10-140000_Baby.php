<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class Baby021014 extends Migration{
    function up(){
        $fields = [
            'babyAvatar'=>[
                'type'=>'TEXT'
            ]
            ];
        $this->forge->modifyColumn('babys',$fields);
    }
    function down(){

    }
}