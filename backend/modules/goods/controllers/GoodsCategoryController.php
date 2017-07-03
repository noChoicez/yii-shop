<?php

namespace backend\modules\goods\controllers;

use Yii;
use common\models\GoodsCategoryModel;
use backend\modules\goods\models\GoodsCategoryForm;
use common\models\search\GoodsCategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\base\BaseController;
/**
 * GoodsCategoryController implements the CRUD actions for GoodsCategoryModel model.
 */
class GoodsCategoryController extends BaseController
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
     * Lists all GoodsCategoryModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GoodsCategoryModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsCategoryForm();
        //定义场景
        $model->setScenario(GoodsCategoryForm::SCENARIOS_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(!$model->create()){
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                return $this->redirect(['index']);   
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GoodsCategoryModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        //定义场景
        $model->setScenario(GoodsCategoryForm::SCENARIOS_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(!$model->update($id)){
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                return $this->redirect(['index']);   
            }
        }
        return $this->render('update', [
        		'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GoodsCategoryModel model.
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
     * Finds the GoodsCategoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsCategoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsCategoryModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the GoodsCategoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsCategoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findForm($id)
    {
        if (($model = GoodsCategoryForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
