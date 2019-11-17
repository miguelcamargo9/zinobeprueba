<?php

use Phinx\Migration\AbstractMigration;

class CreateDirectoryTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('directory');
        $table->addColumn('position', 'string', ['limit' => 150])
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('name', 'string', ['limit' => 150])
            ->addColumn('lastname', 'string', ['limit' => 150])
            ->addColumn('document', 'string', ['limit' => 150])
            ->addColumn('phone', 'string', ['limit' => 150])
            ->addColumn('country', 'string', ['limit' => 150])
            ->addColumn('city', 'string', ['limit' => 150])
            ->addColumn('department', 'string', ['limit' => 150])
            ->addColumn('birthdate', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex(['email'], ['unique' => true, 'name' => 'idx_directory_email'])
            ->create();
    }
}
