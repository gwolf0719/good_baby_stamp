<?php 
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class Addcol0208120000 extends Migration{
    function up(){
        $cols = [
            'level'=>[
                'type'=>'INT',
                'constraint'=>1,
                'default'=>0
            ]
            ];
        $this->forge->addColumn('userBabyMap',$cols);
    }
    function down(){

    }
}