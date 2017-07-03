<?php
namespace backend\modules\promo\models;

use Yii;
use yii\base\Model;
use common\models\PromoCouponModel;

class PromoCouponForm extends Model
{
	public $id;
	public $type;
	public $name;
	public $desc;
	public $range;
	public $create_num;
	public $send_num;
	public $use_num;
	public $send_type;
	public $send_start_time;
	public $send_end_time;
	public $use_start_time;
	public $use_end_time;
	public $create_time;
	
	public $_lastError;
	
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';
	
	public function scenarios()
	{
		$scenarios = [
			self::SCENARIOS_CREATE => ['type', 'name', 'desc', 'range', 'create_num', 'send_num', 'use_num', 'send_type', 'send_start_time', 'send_end_time', 'use_start_time', 'use_end_time', 'create_time'],
			self::SCENARIOS_UPDATE => ['type', 'name', 'desc', 'range', 'create_num', 'send_num', 'use_num', 'send_type', 'send_start_time', 'send_end_time', 'use_start_time', 'use_end_time'],
		];
		return array_merge(parent::scenarios(), $scenarios);
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name', 'type', 'range', 'send_type', 'create_num', 'send_start_time', 'send_end_time', 'use_start_time', 'use_end_time'],'required'],
			[['type', 'range', 'create_num', 'send_num', 'use_num', 'send_type', 'create_time'], 'integer'],
			[['desc'], 'string'],
			[['name'], 'string', 'max' => 50],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'type' => '优惠类型',
			'name' => '优惠券名称',
			'desc' => '描述',
			'range' => '作用范围',
			'create_num' => '发放总数量',
			'send_num' => '已发放数量',
			'use_num' => '已使用数量',
			'send_type' => '发放类型',
			'send_start_time' => '发放开始时间',
			'send_end_time' => '发放结束时间',
			'use_start_time' => '使用开始时间',
			'use_end_time' => '使用结束时间',
			'create_time' => '创建时间',
		];
	}
	
	/**
	 * 添加优惠券
	 * @throws \Exception
	 * @return boolean
	 */
	public function create()
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->beforeSave();
			$model = new PromoCouponModel();
			$model->type = $this->type;
			$model->name = $this->name;
			$model->desc = $this->desc;
			$model->range = $this->range;
			$model->create_num = $this->create_num;
			$model->send_type = $this->send_type;
			$model->send_start_time = $this->send_start_time;
			$model->send_end_time = $this->send_end_time;
			$model->use_start_time = $this->use_start_time;
			$model->use_end_time = $this->use_end_time;
			$model->create_time = $this->create_time;
			if(!$model->save())
				throw new \Exception("优惠券保存失败！");
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
	 * 更新优惠券
	 * @param unknown $id
	 * @throws \Exception
	 * @return boolean
	 */
	public function update($id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->beforeSave();
			$model = PromoCouponModel::findOne($id);
			$model->type = $this->type;
			$model->name = $this->name;
			$model->desc = $this->desc;
			$model->range = $this->range;
			$model->create_num = $this->create_num;
			$model->send_type = $this->send_type;
			$model->send_start_time = $this->send_start_time;
			$model->send_end_time = $this->send_end_time;
			$model->use_start_time = $this->use_start_time;
			$model->use_end_time = $this->use_end_time; 
			if(!$model->save())
				throw new \Exception("优惠券保存失败！");
			$this->id = $model->id;
					
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			$this->_lastError = $e->getMessage();
			return false;
		}
	}
	
	public function beforeSave()
	{
		$this->send_start_time = strtotime($this->send_start_time);
		$this->send_end_time = strtotime($this->send_end_time);
		$this->use_start_time = strtotime($this->use_start_time);
		$this->use_end_time = strtotime($this->use_end_time);
		$this->create_time = time();
	}
	
	public static function findOne($id)
	{
		$model = PromoCouponModel::findOne($id);
		$form = new PromoCouponForm();
		$form->setAttributes($model->getAttributes());
		$form->send_start_time = date('Y-m-d', $form->send_start_time);
		$form->send_end_time = date('Y-m-d', $form->send_end_time);
		$form->use_start_time = date('Y-m-d', $form->use_start_time);
		$form->use_end_time = date('Y-m-d', $form->use_end_time);
		
		return $form;
	}
	
}