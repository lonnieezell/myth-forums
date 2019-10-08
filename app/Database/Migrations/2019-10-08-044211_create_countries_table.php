<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountriesTable extends Migration
{
	public function up()
	{
		$this->forge->addField('id');
		$this->forge->addField([
		    'name' => ['type' => 'varchar', 'constraint' => 255],
            'code' => ['type' => 'char', 'constraint' => 2]
        ]);
		$this->forge->addUniqueKey('code');
		$this->forge->createTable('countries');

        $seeder = \Config\Database::seeder();
        $seeder->call('CountrySeeder');
	}

	//--------------------------------------------------------------------

	public function down()
	{
	    $this->db->disableForeignKeyChecks();

		$this->forge->dropTable('countries', true);

		$this->db->enableForeignKeyChecks();
	}
}
