<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@sklad', dirname(dirname(__DIR__)) . '/sklad');

require(__DIR__ . '/../globals.php');
require(__DIR__ . '/../project-globals.php');
