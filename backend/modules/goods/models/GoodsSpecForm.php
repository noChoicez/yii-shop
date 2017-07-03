<?php
namespace backend\modules\goods\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use common\models\GoodsSpecModel;
use common\models\GoodsSpecItemModel;
use backend\modules\goods\models\GoodsSpecItemForm;

/**
 * GoodsCategory Form
 * @author Administrator
 *
 */
class GoodsSpecForm extends Model
{
    public $id;         //规格ID
    public $type_id;    //商品类型ID
    public $spec_name;  //规格名称
    public $spec_index; //是否检索
    public $spec_value; //规格项
    public $order;      //规格排序
    
    public $_lastError = "";

    /**
     * 定义场景
     * SCENARIOS_CREATE 创建
     * SCENARIOS_UPDATE 更新
     */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    /**
     * 定义事件
     */
    const EVENR_AFTER_SAVE = 'eventAfterSave';

    /**
     * 场景设置
     * @return [type] [description]
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIOS_CREATE => ['type_id','spec_name','spec_index','spec_value','order'],
            self::SCENARIOS_UPDATE => ['type_id','spec_name','spec_index','spec_value','order'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'spec_name'], 'required'],
            [['type_id', 'spec_index', 'order'], 'integer'],
            [['spec_name'], 'string', 'max' => 50],
            ['spec_value', 'string'],
            ['order','default','value'=>50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '商品类型',
            'spec_name' => '规格名称',
            'spec_index' => '是否检索',
            'spec_value' => '规格项',
            'order' => '规格排序',
        ];
    }
    
    /**
     * 添加商品规格
     * @return [type] [description]
     */
    public function create()
    {
        //事物
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->formatData();d($this->spec_value);
            $model = new GoodsSpecModel();
            $model->type_id = $this->type_id;
            $model->spec_name = $this->spec_name;
            $model->spec_index = $this->spec_index;
            $model->spec_value = $this->spec_value;
            $model->order = $this->order;
            $this->id = $model->save();

            $data = array_merge($this->getAttributes(), $model->getOldAttributes());
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
     * 更新商品规格
     * @return [type] [description]
     */
    public function update($id)
    {
        //事物
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->formatData();
            $model = GoodsSpecModel::findOne($id);
            $model->type_id = $this->type_id;
            $model->spec_name = $this->spec_name;
            $model->spec_index = $this->spec_index;
            $model->spec_value = $this->spec_value;
            $model->order = $this->order;
            $this->id = $model->save();

            $data = array_merge($this->getAttributes(), $model->getOldAttributes());
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
     * 商品规格保存后的事件
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function _eventAfterSave($data)
    {
        //添加事件
        $this->on(self::EVENR_AFTER_SAVE, [$this, '_eventUpdateSpecItems'], $data);
        //触发事件
        $this->trigger(self::EVENR_AFTER_SAVE);
    }

    /**
     * 更新产品规格项
     * @return [type] [description]
     */
    public function _eventUpdateSpecItems($event)
    {   
    	//删除关联关系
    	GoodsSpecItemModel::deleteAll(['spec_id' => $event->data['id']]);

    	//批量添加规格项
    	$specValue = explode(PHP_EOL, $event->data['spec_value']);
    	//去除数组中的空值
    	array_filter($specValue);
    	foreach($specValue as $k => $v){
    		if(!empty($v)){
    			$row[$k]['spec_id'] = $event->data['id'];
    			$row[$k]['item'] = $v;	
    		}
    	}
    	$res = (new Query())->createCommand()
    		->batchInsert(GoodsSpecItemModel::tableName(), ['spec_id', 'item'], $row)
    		->execute();
    	if(!$res)
    		throw new \Exception('商品规格项保存失败，请重新添加！');
    }

    /**
     * 格式化数据
     * @return [type] [description]
     */
    private function formatData()
    {
    	return true;
    }

    
    public static function findOne($id)
    {
        $model = GoodsSpecModel::findOne($id);
        $form = new GoodsSpecForm();
		$form->setAttributes($model->getAttributes());

        return $form;
    }

}
