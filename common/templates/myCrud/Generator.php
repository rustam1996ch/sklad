<?php
/**
 * Created by PhpStorm.
 * User: Bunyod
 * Date: 9/24/18
 * Time: 5:42 PM
 */

namespace app\templates\myCrud;


use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class Generator extends \yii\gii\generators\crud\Generator
{


    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            }

            return "\$form->field(\$model, '$attribute')";
        }
        $column = $tableSchema->columns[$attribute];

        if(strpos($column->name,"_") && $column->phpType === 'integer'){
            $columnExplode = explode('_',$column->name);
            $ModelName = ucfirst($columnExplode[0]);
            if($columnExplode[count($columnExplode) - 1] == 'id'){
                return "\$form->field(\$model, '$attribute')->widget(\kartik\select2\Select2::classname(),[
                    /*'value' => 1,*/
                    'data' => \yii\helpers\ArrayHelper::map($ModelName::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Выберите', 'multiple' => false],
                    'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                    'size' => 'xs',
                ]);";
            }
        }

        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        }

        if ($column->type === 'text') {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6, 'class'=>'form-control input-transparent'])";
        }

        if ($column->type === 'tinyint' && $column->name === 'status') {
            return "\$form->field(\$model, '$attribute')->dropDownList(['NULL'=>'','1' => 'Активный','0' => 'Не активный'])";
        }

        if ($column->type === 'tinyint') {
            return "\$form->field(\$model, '$attribute')->dropDownList(['key1'=>'Value1','key2'=>'Value2'])";
        }

        if ($column->type === 'timestamp' || $column->type === 'date') {
            return "\$form->field(\$model, '$attribute')->widget(\kartik\date\DatePicker::classname(),[
                'options' => ['placeholder' => 'Placeholder'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);";
        }

        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
            $input = 'passwordInput';
        } else {
            $input = 'textInput';
        }

        if (is_array($column->enumValues) && count($column->enumValues) > 0) {
            $dropDownOptions = [];
            foreach ($column->enumValues as $enumValue) {
                $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
            }
            return "\$form->field(\$model, '$attribute')->dropDownList("
                . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)) . ", ['prompt' => '', 'class'=>'form-control input-transparent'])";
        }

        if ($column->phpType !== 'string' || $column->size === null) {
            return "\$form->field(\$model, '$attribute')->$input(['class'=>'form-control input-transparent'])";
        }

        return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true, 'class'=>'form-control input-transparent'])";
    }
}