<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsersMigration_100
 */
class UsersMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('users', [
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
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'email',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'email'
                        ]
                    ),
                    new Column(
                        'remember_token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 100,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "0000-00-00 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'remember_token'
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
                        'photo',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'size' => 255,
                            'after' => 'updated_at'
                        ]
                    ),
                    new Column(
                        'desc',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'photo'
                        ]
                    ),
                    new Column(
                        'type',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 60,
                            'after' => 'desc'
                        ]
                    ),
                    new Column(
                        'source',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 45,
                            'after' => 'type'
                        ]
                    ),
                    new Column(
                        'uid',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 45,
                            'after' => 'source'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('users_email_unique', ['email'], 'UNIQUE')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '10',
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
