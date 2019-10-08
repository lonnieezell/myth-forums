<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSettingsTable extends Migration
{
	public function up()
	{
		$this->forge->addField('id');
		$this->forge->addField([
		    'user_id' => ['type' => 'integer', 'constraint' => 11, 'unsigned' => true],
            'parser' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'dob' => ['type' => 'date', 'null' => true],
            'dob_privacy' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true, 'default' => 3],
            'website' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'location' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'country' => ['type' => 'char', 'constraint' => 3, 'null' => true],
            'lotitude' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'longitude' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'bio' => ['type' => 'text', 'null' => true],
            'signature' => ['type' => 'text', 'null' => true],
            'auto_subscribe' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true, 'default' => 1],
            'show_online' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true, 'default' => 1],
            'allow_pm' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true, 'default' => 1],
        ]);
        $this->forge->addUniqueKey('user_id');
		$this->forge->addForeignKey('user_id', 'users', 'id', '', 'cascade');
		$this->forge->createTable('user_settings');
	}

	//--------------------------------------------------------------------

	public function down()
	{
	    $this->db->disableForeignKeyChecks();

		$this->forge->dropTable('user_settings');

		$this->db->enableForeignKeyChecks();
	}
}
