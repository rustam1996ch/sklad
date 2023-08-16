<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_sidebar".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string|null $icon_name
 * @property string|null $link
 * @property int $c_order
 * @property int $status
 */
class MenuSidebar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_sidebar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_order', 'status'], 'default', 'value' => null],
            [['parent_id'], 'default', 'value' => 0],
            [['parent_id', 'c_order', 'status'], 'integer'],
            [['name', 'c_order'], 'required'],
            [['name', 'icon_name', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'icon_name' => 'Icon Name',
            'link' => 'Link',
            'c_order' => 'C Order',
            'status' => 'Status',
        ];
    }

    public static function all($not_id = NULL)
    {
        $query = self::find();
        if ($not_id) {
            $res = $query->where(['!=', 'id', $not_id]);
        }
        $res = $query->orderBy('parent_id, c_order, id')->asArray()->all();

        return \yii\helpers\ArrayHelper::map($res, 'id', 'name');
    }

    private $tmenus = [];
    private $byPMenus = [];

    public function getMenusAsTree($parent = 0)
    {
        $query = self::find();

        $this->tmenus = $query->orderBy('parent, c_order, id')->indexBy('id')->asArray()->all();

        $this->byPMenus = [];
        foreach($this->tmenus as $item){
            if(!isset($this->byPMenus[$item['parent']])){
                $this->byPMenus[$item['parent']] = [];
            }
            $this->byPMenus[$item['parent']][] = $item['id'];
        }

        $result = [];

//        prd($this->tmenus);

        foreach($this->tmenus as $item){
            if($item['parent'] == $parent){
                $result[$item['id']] = $item;
                $result[$item['id']]['items'] = $this->_menuTree($item['id']);
            } elseif($item['parent'] > $parent) {
                break;
            }
        }

        $this->byPMenus = [];
        return $result;
    }

    private function _menuTree($mId){

        if( isset( $this->byPMenus[$mId] ) ){
            $result = [];
            foreach($this->byPMenus[$mId] as $item){
                $result[$item] = $this->tmenus[$item];
                $result[$item]['items'] = $this->_menuTree($item);
            }
            return $result;
        }else{
            return [];
        }
    }

}
