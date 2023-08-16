<?php


namespace sklad\models;

use Yii;


class UploadExcel extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'extensions'=>'xlsx, xls'],
            [['file'], 'file', 'maxSize'=>'5048580'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл Excel',
        ];
    }
}