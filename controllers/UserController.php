<?php
namespace app\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'someet\common\models\User';

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create']);

        return $actions;
    }

}
