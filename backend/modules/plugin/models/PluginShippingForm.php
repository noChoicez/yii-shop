<?php 
namespace backend\modules\plugin\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use common\models\PluginShippingModel;
use common\models\PluginShippingAreaModel;

class PluginShippingForm extends Model
{
	 public $id;
	 public $plugin_id; 	//插件id
	 public $name; 			//名称
	 public $first_weight; 	//首重（单位：克）
	 public $first_money; 	//首重费用
	 public $add_weight; 	//续重（单位：克）
	 public $add_money; 	//续重费用
	 public $update_time; 	//更新时间
	 public $area;			//地区
	 
	 public $_lastError;

	 /**
	  * 定义场景
	  * SCENARIOS_CREATE 添加场景
	  * SCENARIOS_UPDATE 更新场景
	  */
	 const SCENARIOS_CREATE = 'create';
	 const SCENARIOS_UPDATE = 'update';

	 /**
	  * 定义事件
	  * EVENT_AFTER_SAVE 保存后的事件
	  */
	 const EVENT_AFTER_SAVE = 'eventAfterSave';

	 public function scenarios()
	 {
	 	$scenarios = [
	 		self::SCENARIOS_CREATE => ['plugin_id','name','first_weight','first_money','add_weight','add_money','update_time','area'],
	 		self::SCENARIOS_UPDATE => ['plugin_id','name','first_weight','first_money','add_weight','add_money','update_time','area'],
	 	];
	 	return array_merge(parent::scenarios(), $scenarios);
	 }

	 /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plugin_id', 'name'], 'required'],
            [['id', 'first_weight', 'add_weight', 'update_time', 'plugin_id'], 'integer'],
            [['first_money', 'add_money'], 'number'],
            [['name'], 'string', 'max' => 50],
        	['update_time','default','value'=>time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plugin_id' => '插件id',
            'name' => '地区名称',
            'first_weight' => '首重',
            'first_money' => '首重费用',
            'add_weight' => '续重',
            'add_money' => '续重费用',
            'update_time' => '更新时间',
        ];
    }  

    /**
     * 添加插件地区
     * @return [type] [description]
     */
    public function create($id = "")
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$this->beforeSave();
    		$model = $id?(PluginShippingModel::findOne($id)):(new PluginShippingModel());
    		$model->setAttributes(array_merge($model->getAttributes(),array_filter($this->getAttributes())));
    		if(!$model->save())
    			throw new \Exception("地区添加失败！");
    		$this->id = $model->id;
			
    		//触发事件
    		$data = array_merge($this->getAttributes(), $model->getAttributes());
    		$this->_eventAfterSave($data);
    		
    		$transaction->commit();
    		return true;
    	} catch (\Exception $e) {
    		$transaction->rollBack();
    		$this->_lastError = $e->getMessage();
    		return false;
    	}
    }
    
    /**
     * 保存之前执行的操作
     */
    public function beforeSave()
    {
 
    }
    
    /**
     * 保存后触发事件
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function _eventAfterSave($data)
    {
    	$this->on(self::EVENT_AFTER_SAVE, [$this, '_eventUpdateArea'], $data);
    	$this->trigger(self::EVENT_AFTER_SAVE);
    }
    
    /**
     * 更新地区
     * @param unknown $data
     */
    public function _eventUpdateArea($event)
    {
    	//删除关联关系
    	PluginShippingAreaModel::deleteAll(['plugin_shipping_id' => $event->data['id']]);
    	
    	$areas = $event->data['area'];
    	$area  = [];
    	foreach($areas as $k => $v){
    		$area[$k]['plugin_shipping_id'] = $event->data['id'];
    		$area[$k]['plugin_area_id'] = $v;
    	}
    	if($area){
    		$result = (new \yii\db\Query())->createCommand()
    			->batchInsert(PluginShippingAreaModel::tableName(), ['plugin_shipping_id','plugin_area_id'], $area)
    			->execute();
    		if(!$result)
    			throw new \Exception("地区添加失败");
    	}
    }

    public static function findOne($id)
    {	
    	$model = PluginShippingModel::findOne($id);
    	$form = new PluginShippingForm();
		$form->setAttributes($model->getAttributes());
		$form->area = PluginShippingAreaModel::getShippingAreaById($id);

    	return $form;
    }

}