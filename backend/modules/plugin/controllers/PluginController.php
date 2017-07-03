<?php

namespace backend\modules\plugin\controllers;

use Yii;
use common\models\PluginModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\plugin\models\PluginForm;
use common\models\PluginAreaModel;
use common\models\PluginShippingModel;
use backend\modules\plugin\models\PluginShippingForm;

/**
 * PluginController implements the CRUD actions for PluginModel model.
 */
class PluginController extends Controller
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
     * Lists all PluginModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PluginModel::find(),
        ]);
		$group = PluginModel::pluginGroupByType();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        	'group' => $group,
        ]);
    }

    /**
     * Displays a single PluginModel model.
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
     * Creates a new PluginModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PluginForm();
		$model->setScenario(PluginForm::SCENARIOS_CREATE);
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
     * Updates an existing PluginModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $model->setScenario(PluginForm::SCENARIOS_UPDATE);
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
     * Deletes an existing PluginModel model.
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
     * 插件配置项赋值
     * @param unknown $id
     * @return \yii\web\Response|string
     */
    public function actionConfig($id)
    {
    	$model = $this->findForm($id);
    	$model->setScenario(PluginForm::SCENARIOS_CONFIG);
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		if(!$model->config($id)){
    			Yii::$app->session->setFlash('warning', $model->_lastError);
    		}else{
    			return $this->redirect(['index']);
    		}
    	}
    	return $this->render('config',['model' => $model]);
    }
    
    public function actionShipping($id)
    {
    	$dataProvider = new ActiveDataProvider([
    		'query' => PluginShippingModel::find()->with(['plugin','shippingArea.area']),
    	]);
    	$plugin = PluginForm::findOne($id);
    	return $this->render('shipping',['dataProvider' => $dataProvider]);
    }
    
    public function actionShippingCreate($id = "")
    {
    	$model = $id?(PluginShippingForm::findOne($id)):(new PluginShippingForm());
    	$model->setScenario(PluginShippingForm::SCENARIOS_CREATE);
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		if(!$model->create($id)){
    			Yii::$app->session->setFlash('warning', $model->_lastError);
    		}else{
    			return $this->redirect(['shipping','id'=>$model->plugin_id]);
    		}
    	}
    	$area = new PluginAreaModel();
    	$province = $area->province();
    	if((Yii::$app->request->post("province"))){
    		return $area->city(Yii::$app->request->post("province"));
    	}
    	if(Yii::$app->request->post("city")){
    		return $area->district(Yii::$app->request->post("city"));
    	}
    	
    	return $this->render('shipping-create',[
    			'model' => $model,
    			'province' => $province,
    	]);
    }
     
    public function actionShippingDelete($id)
    {
    	$plugin = PluginShippingModel::find()->where(['id'=>$id])->one(); 
    	PluginShippingModel::findOne($id)->delete();
    
    	return $this->redirect(['shipping','id'=>$plugin['plugin_id']]);
    }
    
    public function actionAjax()
    {
    	$action = Yii::$app->request->post("action");
    	switch (trim($action)){
    		case 'install':
    			$model = new PluginForm();
    			$model->setScenario(PluginForm::SCENARIOS_INSTALL);
    			$result = $model->install(Yii::$app->request->post("id"));
    			break;
    	}
    	
    	return $result;
    }
    
    /**
     * Finds the PluginModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PluginModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PluginModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the PluginModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PluginModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findForm($id)
    {
    	if (($model = PluginForm::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
