<?php

namespace backend\modules\goods\controllers;

use Yii;
use common\models\GoodsModel;
use common\models\search\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\goods\models\GoodsForm;
use common\models\GoodsImageModel;
use common\models\GoodsSpecModel;
use yii\helpers\Url;
use common\models\GoodsAttributeModel;
/**
 * GoodsController implements the CRUD actions for GoodsModel model.
 */
class GoodsController extends Controller
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

    public function actions(){
        return [
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],
            'upload' => [
                'class' => 'common\widgets\file_input\UploadAction',
            ],
        	'uploadOne'=>[ //单文件上传
        		'class' => 'common\widgets\file_upload\UploadAction',//扩展地址
        		'config' => [
        			'serverUrl' => Url::to(['uploadOne','action'=>'uploadimage']),	
        		],
        	]
        ];
    }

    /**
     * Lists all GoodsModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GoodsModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsForm();
        //定义场景
        $model->setScenario(GoodsForm::SCENARIOS_CREATE);
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
     * Updates an existing GoodsModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);

    	//定义场景
        $model->setScenario(GoodsForm::SCENARIOS_UPDATE);
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
     * Deletes an existing GoodsModel model.
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
     * 删除商品图册
     */
    public function actionDeleteAlbum()
    {
    	$model = new GoodsImageModel();
    	if(!$model->deleteImage(Yii::$app->request->post()))
    		Yii::$app->session->setFlash('warning', $model->_lastError);
    	return true;
    }
    
    /**
     * 异步操作
     */
    public function actionAjax()
    {
    	$post = Yii::$app->request->post();
    	switch ($post['action']){
    		//获取商品规格
    		case 'getSpecItems':
    			$model = new GoodsSpecModel();
    			$result = $model->getGoodsSpecByTypeId($post['type_id'],$post['goods_id']??0);
    			break;
    		case 'getSpecInput':
    			$model = new GoodsSpecModel();
    			$result = (isset($post['spec_arr']))?$model->getGoodsSpecInput($post['spec_arr'],$post['goods_id']??0):'';
    			break;
    		case 'getAttribute':
    			$model = new GoodsAttributeModel();
    			$result = $model->getGoodsAttributeByTypeId($post['type_id']??0,$post['goods_id']??0);
    			break;
    		default:
    			$result = '';
    			break;
    	}
    	
    	echo $result;
    }
    
    /**
     * Finds the GoodsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the GoodsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GoodsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findForm($id)
    {
    	if (($model = GoodsForm::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
