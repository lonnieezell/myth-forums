<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTopicTable extends Migration
{
	public function up()
	{
	    // Topics
		$this->forge->addField([
		    'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'author_id' => ['type' => 'integer', 'unsigned' => true, 'constraint' => 9],
            'title' => ['type' => 'varchar', 'constraint' => 255],
            'slug' => ['type' => 'varchar', 'constraint' => 255],
            'body' => ['type' => 'text', 'null' => true],
            'html' => ['type' => 'text', 'null' => true],
            'parser' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'views' => ['type' => 'integer', 'unsigned' => true, 'null' => true, 'default' => 0],
            'created_at' => ['type' => 'datetime', 'null' => false],
            'updated_at' => ['type' => 'datetime', 'null' => false],
            'deleted_at' => ['type' => 'datetime', 'null' => false],
        ]);
		$this->forge->addPrimaryKey('id');
		$this->forge->addKey('author_id');

		$this->forge->addForeignKey('author_id', 'users', 'id', '', 'cascade');
		$this->forge->createTable('topics');

		// Posts
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'author_id' => ['type' => 'integer', 'unsigned' => true, 'constraint' => 9],
            'topic_id' => ['type' => 'integer', 'unsigned' => true, 'constraint' => 9],
            'title' => ['type' => 'varchar', 'constraint' => 255],
            'slug' => ['type' => 'varchar', 'constraint' => 255],
            'body' => ['type' => 'text', 'null' => true],
            'html' => ['type' => 'text', 'null' => true],
            'parser' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'views' => ['type' => 'integer', 'unsigned' => true, 'null' => true, 'default' => 0],
            'created_at' => ['type' => 'datetime', 'null' => false],
            'updated_at' => ['type' => 'datetime', 'null' => false],
            'deleted_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('author_id');

        $this->forge->addForeignKey('author_id', 'users', 'id', '', 'cascade');
        $this->forge->addForeignKey('topic_id', 'topics', 'id', '', 'cascade');
        $this->forge->createTable('posts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
	    $this->db->disableForeignKeyChecks();

		$this->forge->dropTable('topics', true);

		$this->db->enableForeignKeyChecks();
	}
}
