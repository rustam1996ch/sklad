<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_admin}}`.
 */
class m200206_195847_create_add_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);

        $this->insert('user', [
            'role_id' => 2,
            'username' => 'bugalter',
            'email' => 'bugalter@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);

        $this->insert('user', [
            'role_id' => 3,
            'username' => 'sklad',
            'email' => 'sklad@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);

        $this->insert('user', [
            'role_id' => 4,
            'username' => 'bufer',
            'email' => 'bufer@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);

        $this->insert('user', [
            'role_id' => 5,
            'username' => 'rahbar',
            'email' => 'rahbar@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);
        $this->insert('user', [
            'role_id' => 6,
            'username' => 'oxrana',
            'email' => 'oxrana@mail.uz',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => 0
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'admin']);
        $this->delete('user', ['username' => 'bugalter']);
        $this->delete('user', ['username' => 'sklad']);
        $this->delete('user', ['username' => 'bufer']);
        $this->delete('user', ['username' => 'rahbar']);
    }
}
