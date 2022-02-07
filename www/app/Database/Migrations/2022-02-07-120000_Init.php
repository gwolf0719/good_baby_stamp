<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Init20200207 extends Migration
{
    public function up()
    {
        // user  ======================================
        $addFields = [
            'userId' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'displayName' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'pictureUrl' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ]
        ];
        $pk = 'userId';
        $this->forge->addField($addFields);
        $this->forge->addPrimaryKey($pk);
        $this->forge->createTable('users', true);

        // baby  ======================================
        $addFields = [
            'babyId' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'babyDisplayName' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'babyAvatar' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'closeStamp' => [
                'type' => 'INT',
                'constraint' => 10
            ],
            'updateDatetime' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ]
        ];
        $pk = 'babyId';
        $this->forge->addField($addFields);
        $this->forge->addPrimaryKey($pk);
        $this->forge->createTable('babys', true);

        // userBabyMap  ======================================
        $addFields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'babyId'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'userId' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ];
        $pk = 'id';
        $this->forge->addField($addFields);
        $this->forge->addPrimaryKey($pk);
        $this->forge->createTable('userBabyMap', true);

        // stampLog ======================================
        $addFields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'babyId'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'userId' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'notice'=>[
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'initStamp'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'offsetStamp'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'closeStamp'=>[
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'updateDatetime' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ]
        ];
        $pk = 'id';
        $this->forge->addField($addFields);
        $this->forge->addPrimaryKey($pk);
        $this->forge->createTable('stampLog', true);

    }
    public function down()
    {
    }
}
