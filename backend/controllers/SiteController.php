<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\controllers\base\BaseController;
use common\models\ConfigModel;
use backend\models\ConfigForm;


/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','config','upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'upload'=>[
                'class' => 'common\widgets\file_input\UploadAction', //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$datebase = Yii::$app->db->createCommand("show tables")->queryAll();
    	$admin = Yii::$app->db->getTableSchema('ch_admin');
        //d($datebase);die;
    	
    	return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 更新网站配置
     * @return [type] [description]
     */
    public function actionConfig()
    {
        
        $model = new ConfigForm();
        $value = ConfigModel::getConfigs();
        if($model->load(Yii::$app->request->post())){
            if(!$model->updateConfig()){
                Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                $this->redirect(['config']);    
            }  
        }
        return $this->render('config', [
            'model' => $model,
            'value' => $value, 
        ]);
    }

}
