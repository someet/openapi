<?php
namespace app\controllers;

use yii\rest\ActiveController;

class ActivityController extends ActiveController
{
   public $modelClass='someet\common\models\Activity';

   public function actions()
   {
      $actions = parent::actions();

      unset($actions['delete'], $actions['create']);

      return $actions;
   }
}