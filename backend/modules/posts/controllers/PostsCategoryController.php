<?php

namespace backend\modules\posts\controllers;

use Yii;
use common\models\PostsCategoryModel;
use common\models\search\PostsCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\posts\models\PostsCategoryForm;

/**
 * PostsCategoryController implements the CRUD actions for PostsCategoryModel model.
 */
class PostsCategoryController extends Controller
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

    /**
     * Lists all PostsCategoryModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PostsCategoryModel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PostsCategoryModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostsCategoryForm();
		$model->setScenario(PostsCategoryForm::SCENARIOS_CREATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	if(!$model->create()){
        		Yii::$app->session->setFlash('warning',$model->_lastError);	
        	}else{
        		return $this->redirect(['index']);
        	}
        }
        return $this->render('create', [
        		'model' => $model,
        ]);
    }

    /**
     * Updates an existing PostsCategoryModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
		$model->setScenario(PostsCategoryForm::SCENARIOS_UPDATE);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	if(!$model->update($id)){
        		Yii::$app->session->setFlash('warning',$model->_lastError);	
        	}else{
        		return $this->redirect(['index']);
        	}
        }
        return $this->render('create', [
        		'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PostsCategoryModel model.
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
     * Finds the PostsCategoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PostsCategoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostsCategoryModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the PostsCategoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PostsCategoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findForm($id)
    {
    	if (($model = PostsCategoryForm::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
