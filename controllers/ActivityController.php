<?php
namespace app\controllers;

use someet\common\models\Activity;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\data\Pagination;

class ActivityController extends Controller
{
   public $modelClass='someet\common\models\Activity';

   public function actions()
   {
      $actions = parent::actions();

      unset($actions['delete'], $actions['create']);

      return $actions;
   }

   /**
    * 活动列表
    * @return ActiveDataProvider
    */
   public function actionIndex()
   {
      $data = Activity::find()->where(['status' => Activity::STATUS_RELEASE]);
      $pages = new Pagination(['totalCount' => $data->count()]);
      return new ActiveDataProvider([
          'query' => $data->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC]),
      ]);
   }

   /**
    * 活动详情
    * @param $id 活动ID
    * @return null|static
    */
   public function actionView($id)
   {
      return Activity::findOne($id);
   }

   public function actionCreate()
   {

   }
}