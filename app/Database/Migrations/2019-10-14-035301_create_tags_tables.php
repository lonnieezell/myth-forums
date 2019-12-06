<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagsTables extends Migration
{
	public function up()
	{
	    // Tags
		$this->forge->addField('id');
		$this->forge->addField([
		    'title'         => ['type' => 'varchar', 'constraint' => 255],
            'slug'          => ['type' => 'varchar', 'constraint' => 255],
            'description'   => ['type' => 'text', 'null' => true],
            'parent_id'     => ['type' => 'int', 'constraint' => 9, 'null' => true],
            'order'         => ['type' => 'int', 'constraint' => 3, 'default' => 0],
            'is_structural' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'color'         => ['type' => 'varchar', 'constraint' => 7, 'null' => true],
            'icon'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'public'        => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ]);
		$this->forge->addKey('parent_id');
		$this->forge->createTable('tags');

		// Tags/Topics
        $this->forge->addField('id');
        $this->forge->addField([
            'topic_id' => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'tag_id' => ['type' => 'int', 'constraint' => 9, 'null' => false],
        ]);
        $this->forge->addUniqueKey(['topic_id', 'tag_id']);
        $this->forge->createTable('tags_topics');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('tags', true);
		$this->forge->dropTable('tags_topics', true);

		$this->db->enableForeignKeyChecks();
	}
}
