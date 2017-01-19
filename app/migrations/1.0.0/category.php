<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class CategoryMigration_100
 */
class CategoryMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('category', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'cate_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'as_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'cate_name'
                        ]
                    ),
                    new Column(
                        'parent_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'as_name'
                        ]
                    ),
                    new Column(
                        'seo_title',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'parent_id'
                        ]
                    ),
                    new Column(
                        'seo_key',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'seo_title'
                        ]
                    ),
                    new Column(
                        'seo_desc',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'seo_key'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "0000-00-00 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'seo_desc'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "0000-00-00 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    ),
                    new Column(
                        'class_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 45,
                            'after' => 'updated_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('category_cate_name_unique', ['cate_name'], 'UNIQUE'),
                    new Index('category_as_name_unique', ['as_name'], 'UNIQUE')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '5',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_unicode_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
