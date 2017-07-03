<?php 
namespace backend\modules\plugin\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use common\models\PluginModel;

class PluginForm extends Model
{
	 public $id;
	 public $type; 			//插件类型:0支付插件1物流插件
	 public $name; 			//插件名称
	 public $code; 			//插件标识
	 public $author; 		//插件作者
	 public $version; 		//插件版本
	 public $desc; 			//插件描述
	 public $cover_image; 	//插件封面图
	 public $back_image; 	//物流插件打印背景图
	 public $config; 		//插件配置项
	 public $config_value; 	//插件配置值
	 public $create_time; 	//创建时间
	 public $install_time;  //安装时间
	 public $status;		//状态0已卸载1已安装

	 public $_lastError;

	 /**
	  * 定义场景
	  * SCENARIOS_CREATE 添加场景
	  * SCENARIOS_UPDATE 更新场景
	  * SCENARIOS_UPDATE_VALUE 更新配置值
	  */
	 const SCENARIOS_CREATE = 'create';
	 const SCENARIOS_UPDATE = 'update';
	 const SCENARIOS_CONFIG = 'config';
	 const SCENARIOS_INSTALL = 'install';

	 /**
	  * 定义事件
	  * EVENT_AFTER_SAVE 保存后的事件
	  */
	 const EVENT_AFTER_SAVE = 'eventAfterSave';

	 public function scenarios()
	 {
	 	$scenarios = [
	 		self::SCENARIOS_CREATE => ['type', 'name', 'code', 'author', 'version', 'desc', 'cover_image', 'back_image', 'config', 'create_time', 'install_time','status'],
	 		self::SCENARIOS_UPDATE => ['type', 'name', 'code', 'desc', 'cover_image', 'back_image', 'config', 'install_time','status'],
	 		self::SCENARIOS_CONFIG => ['config_value'],
	 		self::SCENARIOS_INSTALL=> ['install_time','status'],
	 	];
	 	return array_merge(parent::scenarios(), $scenarios);
	 }

	 /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['status','install_time', 'create_time'], 'integer'],
            [['type','name', 'code'], 'required'],
            [['config', 'config_value'],'safe'],
            [['name', 'code', 'author', 'version', 'cover_image', 'back_image'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 255],
        	['author', 'default', 'value' => 'CH'],
        	['version', 'default', 'value' =>'1.0'],
        	[['create_time','install_time'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '插件类型',
            'name' => '插件名称',
            'code' => '插件标识',
            'author' => '插件作者',
            'version' => '插件版本',
            'desc' => '插件描述',
            'cover_image' => '封面图',
            'back_image' => '物流模板',
            'config' => '配置项',
            'config_value' => '配置值',
        	'create_time' => '创建时间',
        	'install_time' => '安装时间',
        ];
    }

    /**
     * 添加插件
     * @return [type] [description]
     */
    public function create()
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$this->beforeSave();
    		$model = new PluginModel();
    		$model->setAttributes($this->getAttributes());
			
    		if(!$model->save())
    			throw new \Exception("插件添加失败！");
    		$this->id = $model->id;

    		$transaction->commit();
    		return true;
    	} catch (\Exception $e) {
    		$transaction->rollBack();
    		$this->_lastError = $e->getMessage();
    		return false;
    	}
    }

    /**
     * 更新插件
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update($id)
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$this->beforeSave();
    		$model = PluginModel::findOne($id);
    		$model->setAttributes(array_merge($model->getAttributes(),array_filter($this->getAttributes())));
    		
    		if(!$model->save())
    			throw new \Exception("插件更新失败！");
    		$this->id = $model->id;

    		$transaction->commit();
    		return true;
    	} catch (\Exception $e) {
    		$transaction->rollBack();
    		$this->_lastError = $e->getMessage();
    		return false;
    	}
    }
	
    /**
     * 配置项赋值
     * @param unknown $id
     */
    public function config($id)
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$model = PluginModel::findOne($id);
    		$model->config_value = json_encode($this->config_value);
    		if(!$model->save())
    			throw new \Exception("配置项赋值失败");
    		$this->id = $model->id;
    		$transaction->commit();
    		return true;
    	} catch (\Exception $e) {
    		$transaction->rollBack();
    		$this->_lastError = $e->getMessage();
    		return false;
    	} finally {
    		unset($transaction);
    	}
    }
    
    /**
     * 插件安装、卸载
     * @param unknown $id
     * @return string
     */
    public function install($id)
    {
    	$model = PluginModel::findOne($id);
    	$model->status = $model->status?0:1;
    	$model->install_time = $model->status?$this->install_time:$model->install_time;
    	return $model->save()
    		?json_encode(['status'=>1,'msg'=>($model->status?'安装':'卸载').'成功'])
    		:json_encode(['status'=>0,'msg'=>($model->status?'卸载':'安装').'失败']);
    }
    
    /**
     * 保存之前执行的操作
     */
    public function beforeSave()
    {
    	$configs = $this->config;
    	$config = [];
		if($configs){
			for($i = 0 ;$i < count($configs['type']); $i++){
				$config[$i]['type'] = $configs['type'][$i];
				$config[$i]['label'] = $configs['label'][$i];
				$config[$i]['code'] = $configs['code'][$i];
				$config[$i]['value'] = $configs['value'][$i];
			}	
		}
    	$this->config = serialize($config);
    }
    
    /**
     * 保存后触发事件
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function _eventAfterSave($data)
    {
    	$this->on(self::EVENT_AFTER_SAVE, [$this, ''], $data);

    	$this->off(self::EVENT_AFTER_SAVE);
    }

    public static function findOne($id)
    {	
    	$model = PluginModel::findOne($id);
    	$form = new PluginForm();
		$form->setAttributes($model->getAttributes());
		$form->config = unserialize($form->config);
		$form->config_value = json_decode($form->config_value,true);
		
    	return $form;
    }

}