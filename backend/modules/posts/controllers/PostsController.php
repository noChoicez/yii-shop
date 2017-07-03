<?php

namespace backend\modules\posts\controllers;

use Yii;
use common\models\PostsModel;
use common\models\search\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\posts\models\PostsForm;

/**
 * PostsController implements the CRUD actions for PostsModel model.
 */
class PostsController extends Controller
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
     * Lists all PostsModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PostsModel model.
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
     * Creates a new PostsModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostsForm();
		$model->setScenario(PostsForm::SCENARIOS_CREATE);
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
     * Updates an existing PostsModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $model->setScenario(PostsForm::SCENARIOS_UPDATE);
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
     * Deletes an existing PostsModel model.
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
     * Finds the PostsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PostsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostsModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the PostsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PostsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findForm($id)
    {
    	if (($model = PostsForm::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    
}
