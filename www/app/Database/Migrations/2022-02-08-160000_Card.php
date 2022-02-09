<?php 
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class Card020816 extends Migration{
    function up(){
        $cols = [
            'cardId'=>[
                'type'=>"INT",
                'contraint'=>5
            ]
        ];
        $this->forge->addColumn('stampLog',$cols);

        $cols = [
            'cardId' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'subject'=>[
                'type'=>'VARCHAR',
                'constraint' => 100
            ],
            'col'=>[
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'row'=>[
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'checkData'=>[
                'type' => 'TEXT'
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('cardId');
        $this->forge->createTable('card',true);
    }
    function down(){
        
    }
}