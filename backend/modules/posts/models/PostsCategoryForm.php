<?php 
namespace backend\modules\posts\models;

use Yii;
use yii\base\Model;
use common\models\PostsCategoryModel;

class PostsCategoryForm extends Model
{
	public $id;
	public $level;
	public $parent_id;
	public $cat_name;
	public $cat_desc;
	public $cat_path;
	public $is_show;
	public $order;
	
	public $_lastError;
	
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';
	
	const EVENT_AFTER_SAVE = '_eventAfterSave';
	
	public function scenarios()
	{
		$scenarios = [
			self::SCENARIOS_CREATE => ['level', 'parent_id', 'cat_name', 'cat_desc', 'cat_path', 'is_show', 'order'],	
			self::SCENARIOS_UPDATE => ['level', 'parent_id', 'cat_name', 'cat_desc', 'cat_path', 'is_show', 'order'],
		];
		return array_merge(parent::scenarios(), $scenarios);
	}
	
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parent_id', 'order', 'is_show'], 'integer'],
            [['cat_name'], 'required'],
            [['cat_name'], 'string', 'max' => 50],
            [['cat_desc'], 'string', 'max' => 255],
            [['cat_path'], 'string', 'max' => 500],
        	['order', 'default', 'value' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '等级',
            'parent_id' => '父级分类',
            'cat_name' => '分类名称',
            'cat_desc' => '分类描述',
            'cat_path' => '分类路径',
        	'is_show' => '是否显示',
            'order' => '分类排序',
        ];
    }
    
    public function create()
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$this->beforeSave();
    		$model = new PostsCategoryModel();
    		$model->level = $this->level;
    		$model->parent_id = $this->parent_id;
    		$model->cat_name = $this->cat_name;
    		$model->cat_desc = $this->cat_desc;
    		$model->cat_path = $this->cat_path;
    		$model->is_show = $this->is_show;
    		$model->order = $this->order;
    		if(!$model->save())
    			throw new \Exception("保存失败");
    		$this->id = $model->id;

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
    
    public function update($id)
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$this->beforeSave();
    		$model = PostsCategoryModel::findOne($id);
    		$model->level = $this->level;
    		$model->parent_id = $this->parent_id;
    		$model->cat_name = $this->cat_name;
    		$model->cat_desc = $this->cat_desc;
    		$model->cat_path = $this->cat_path;
    		$model->is_show = $this->is_show;
    		$model->order = $this->order;
    		if(!$model->save())
    			throw new \Exception("保存失败");
    		$this->id = $model->id;
    		
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
    
    public function beforeSave()
    {
    	//获取父级分类
    	$parent = PostsCategoryModel::findOne(['id'=>$this->parent_id]);
    	//判断分类等级
    	$this->level = ($this->parent_id == 0)?1:($parent['level'] + 1);
    	$this->cat_path = $parent['cat_path'];
    }
    
    public function _eventAfterSave($data)
    {
    	$this->on(self::EVENT_AFTER_SAVE, [$this, '_eventUpdateCatPath'], $data);
    	$this->trigger(self::EVENT_AFTER_SAVE);
    }
    
    public function _eventUpdateCatPath($event)
    {
    	$model = PostsCategoryModel::findOne($event->data['id']);
    	$model->cat_path = ($model->cat_path)?$event->data['cat_path'].'-'.$event->data['id']:$event->data['id'];
    	if(!$model->save())
    		throw new \Exception("分类路径保存失败！");
    }
    
    public static function findOne($id)
    {
    	$model = PostsCategoryModel::findOne($id);
    	$form = new PostsCategoryForm();
    	$form->setAttributes($model->getAttributes());
    	
    	return $form;
    }
    
}