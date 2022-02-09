<?php 
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class Card020909 extends Migration{
    function up(){
        $cols = [
            'babyId'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'updateDatetime'=>[
                'type' => 'VARCHAR',
                'constraint' => 20
            ]
        ];
        $this->forge->addColumn('card',$cols);
    }
    function down(){

    }
}