<?php
namespace backend\models\base;

interface BaseFormInterface 
{
	/**
	 * 定义场景
	 * SCENARIOS_CREATE 添加场景
	 * SCENARIOS_UPDATE 更新场景
	 * @var string
	 */
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';
	
	/**
	 * 定义时间
	 * EVENT_AFTER_SAVE 保存后触发的事件
	 * @var string
	 */
	const EVENT_AFTER_SAVE = 'eventAfterSave';
	
	public function scenarios()
	{
		$scenarios = [
			self::SCENARIOS_CREATE => [],
			self::SCENARIOS_UPDATE => [],
		];	
		return array_merge(parent::scenarios(), $scenarios);
	}
	
	public function rules();
	
	public function attributeLabels();
	
	/**
	 * 添加
	 */
	public function create();
	
	/**
	 * 更新
	 * @param unknown $id
	 */
	public function update($id);
	
	/**
	 * 保存之前的操作
	 */
	public function boforeSave();
	
	/**
	 * 保存之后触发的事件
	 * @param unknown $data
	 */
	public function _eventAfterSave($data)
	{
		$this->on(self::EVENT_AFTER_SAVE, [$this, '', $data]);
		$this->trigger(self::EVENT_AFTER_SAVE);
	}
	
	public static function findOne($id);
}