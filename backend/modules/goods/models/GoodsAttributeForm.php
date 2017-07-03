<?php
namespace backend\modules\goods\models;

use Yii;
use yii\base\Model;
use common\models\GoodsAttributeModel;

class GoodsAttributeForm extends Model
{
	public $id;
	public $type_id;
	public $attr_name;
	public $attr_index;
	public $attr_input_type;
	public $attr_values;
	public $order;
	
	public $_lastError;
	
	/**
	 * 定义场景
	 */
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';
	
	public function scenarios()
	{
		$scenarios = [
			self::SCENARIOS_CREATE => ['type_id', 'attr_name', 'attr_index', 'attr_input_type', 'attr_values', 'order'],
			self::SCENARIOS_UPDATE => ['type_id', 'attr_name', 'attr_index', 'attr_input_type', 'attr_values', 'order'],
		];	
		return array_merge(parent::scenarios(), $scenarios);
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['type_id', 'attr_name'],'required'],
			[['type_id', 'attr_index', 'attr_input_type', 'order'], 'integer'],
			[['attr_values'], 'string'],
			[['attr_name'], 'string', 'max' => 50],
			['order', 'default', 'value' => 50]
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
			'attr_name' => '属性名称',
			'attr_index' => '是否检索',
			'attr_input_type' => '输入类型',
			'attr_values' => '属性值',
			'order' => '排序',
		];
	}
	
	/**
	 * 添加商品属性
	 * @throws \Exception
	 * @return boolean
	 */
	public function create()
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->beforeSave();
			$model = new GoodsAttributeModel();
			$model->type_id = $this->type_id;
			$model->attr_name = $this->attr_name;
			$model->attr_index = $this->attr_index;
			$model->attr_input_type = $this->attr_input_type;
			$model->attr_values = $this->attr_values;
			$model->order = $this->order;
			if(!$model->save())
				throw new \Exception("商品属性添加失败！");
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
	 * 更新商品属性
	 * @param unknown $id
	 * @throws \Exception
	 * @return boolean
	 */
	public function update($id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->beforeSave();
			$model = GoodsAttributeModel::findOne($id);
			$model->type_id = $this->type_id;
			$model->attr_name = $this->attr_name;
			$model->attr_index = $this->attr_index;
			$model->attr_input_type = $this->attr_input_type;
			$model->attr_values = $this->attr_values;
			$model->order = $this->order;
			if(!$model->save())
				throw new \Exception("商品属性添加失败！");
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
	 * 保存前的操作
	 * @return boolean
	 */
	private function beforeSave()
	{
		return true;
	}
	
	public static function findOne($id)
	{
		$model = GoodsAttributeModel::findOne($id);
		$form = new GoodsAttributeForm();
		$form->setAttributes($model->getAttributes());

		return $form;
	}
	
	
}