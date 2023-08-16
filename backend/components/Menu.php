<?php

namespace backend\components;

use yii\base\Widget;

class Menu extends Widget{

    private $menus = [];

    public function init(){
        parent::init();
        $this->menus = (new \mdm\admin\models\Menu)->menusAsTree;
    }

    public function run(){

        return $this->render('menu', [
            'menus' => $this->menus
        ]);
    }

}