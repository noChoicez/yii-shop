<?php

namespace backend\modules\goods\controllers;

use Yii;
use common\models\GoodsBrandModel;
use common\models\search\GoodsBrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\goods\models\GoodsBrandForm;
use backend\controllers\base\BaseController;
use common\models\GoodsCategoryModel;

/**
 * GoodsBrandController implements the CRUD actions for GoodsBrandModel model.
 */
class GoodsBrandController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_input\UploadAction', //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }

    /**
     * Lists all GoodsBrandModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsBrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GoodsBrandModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsBrandForm();
        //定义场景
        $model->setScenario(GoodsBrandForm::SCENARIOS_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(!$model->create()){
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                return $this->redirect(['index']);  
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing GoodsBrandModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        //定义场景
        $model->setScenario(GoodsBrandForm::SCENARIOS_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(!$model->update($id)){
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                return $this->redirect(['index']);    
            }
        }
        $goodsCategoryModel = new GoodsCategoryModel();
        $cats = $goodsCategoryModel->getGoodsCategory();
        return $this->render('update', [
        		'model' => $model,
        		'cats'=>$cats
        ]);
    }

    /**
     * Deletes an existing GoodsBrandModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsBrandModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsBrandModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsBrandModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findForm($id)
    {
        if (($form = GoodsBrandForm::findOne($id)) !== null) {
            return $form;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
