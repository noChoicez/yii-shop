<?php
namespace frontend\controllers\base;

use Yii;
use yii\web\Controller;
use common\models\GoodsCategoryModel;

class BaseController extends Controller
{
	public function init()
	{
		//语言初始化
		if(isset($_GET['lang'])){
			Yii::$app->getSession()->set('lang', $_GET['lang']);
			Yii::$app->language = Yii::$app->getSession()->get('lang');
		}else{
			if(Yii::$app->getSession()->get('lang') !== null){
				Yii::$app->language = Yii::$app->getSession()->get('lang');
			}
		}
		//注册变量
		Yii::$app->params['goodsCategory'] = GoodsCategoryModel::getGoodsCategory(true);
	}
	
	
}