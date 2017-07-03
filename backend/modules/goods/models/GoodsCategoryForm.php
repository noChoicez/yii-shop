<?php
namespace backend\modules\goods\models;

use Yii;
use yii\base\Model;
use common\models\GoodsCategoryModel;
use Behat\Gherkin\Exception\Exception;

/**
 * GoodsCategory Form
 * @author Administrator
 *
 */
class GoodsCategoryForm extends Model
{
    public $id;
    public $parent_id;
    public $cat_name;
    public $cat_image;
    public $cat_desc;
    public $cat_path;
    public $level;
    public $order;
    public $is_show;
    
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
     * EVENR_BEFORE_SAVE 保存之前的事件
     * EVENR_AFTER_SAVE  保存之后的事件
     */
    const EVENR_BEFORE_SAVE = 'eventBeforeSave';
    const EVENR_AFTER_SAVE  = 'eventAfterSave';

    /**
     * 场景设置
     * @return [type] [description]
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIOS_CREATE => ['parent_id','cat_name','cat_image','cat_desc','cat_path','level','order','is_show'],
            self::SCENARIOS_UPDATE => ['parent_id','cat_name','cat_image','cat_desc','cat_path','level','order','is_show'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name', 'is_show'],'required'],
            [['id', 'parent_id', 'level', 'order', 'is_show'], 'integer'],
            [['cat_name', 'cat_image'], 'string', 'max' => 50],
            [['cat_desc', 'cat_path'], 'string', 'max' => 255],
            ['order', 'default', 'value' => 50],
        	['parent_id', 'default', 'value' => 0],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类ID',
            'parent_id' => '父级分类',
            'cat_name' => '分类名称',
            'cat_image' => '分类图片',
            'cat_desc' => '分类描述',
            'cat_path' => '分类路径',
            'level' => '分类等级',
            'order' => '分类排序',
            'is_show' => '是否显示',
        ];
    }
    
    /**
     * 添加分类
     * @return [type] [description]
     */
    public function create()
    {
        //事物
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->beforeSave();
            $model = new GoodsCategoryModel();
            $model->parent_id = $this->parent_id;   //父级ID
            $model->cat_name = $this->cat_name;     //分类名
            $model->cat_image = $this->cat_image;   //分类图片
            $model->cat_desc = $this->cat_desc;     //分类描述
            $model->cat_path = $this->cat_path;     //分类路径
            $model->level = $this->level;           //分类等级
            $model->order = $this->order;           //分类排序
            $model->is_show = $this->is_show;       //是否显示
            if(!$model->save())
            	throw new \Exception("分类添加失败！");
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

    /**
     * 更新分类
     * @return [type] [description]
     */
    public function update($id)
    {
        //事物
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->beforeSave();
            $model = GoodsCategoryModel::findOne($id);
            $model->parent_id = $this->parent_id;   //父级ID
            $model->cat_name = $this->cat_name;     //分类名
            $model->cat_image = $this->cat_image;   //分类图片
            $model->cat_desc = $this->cat_desc;     //分类描述
            $model->cat_path = $this->cat_path;     //分类路径
            $model->level = $this->level;           //分类等级
            $model->order = $this->order;           //分类排序
            $model->is_show = $this->is_show;       //是否显示
            if(!$model->save())
            	throw new \Exception("分类更新失败！");
            $this->id = $model->id;

            $data = array_merge($this->getAttributes(), $model->getAttributes());
            $this->_eventAfterSave($data);
            
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
            exit();
        }
    }
   
    /**
     * 保存之前进行数据格式化
     * @return [type] [description]
     */
    private function beforeSave()
    {
    	//获取父级分类
    	$parent = GoodsCategoryModel::findOne(['id'=>$this->parent_id]);
    	//判断分类等级
    	$this->level = ($this->parent_id == 0)?1:($parent['level'] + 1);
    	$this->cat_path = $parent['cat_path'];
    }
    
    /**
     * 分类保存之后的事件
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function _eventAfterSave($data)
    {
        //添加事件
        $this->on(self::EVENR_AFTER_SAVE, [$this, '_eventUpdateCatPath'], $data);
        //触发事件
        $this->trigger(self::EVENR_AFTER_SAVE);
    }

    /**
     * 更新分类路径事件
     * @return [type] [description]
     */
    public function _eventUpdateCatPath($event)
    {            
        $model = GoodsCategoryModel::findOne($event->data['id']);
        $model->cat_path = ($model->cat_path)?$event->data['cat_path'].'-'.$event->data['id']:$event->data['id'];
        if(!$model->save())
        	throw new \Exception("分类路径保存失败！");
    }
    
    public static function findOne($id)
    {
        $model = GoodsCategoryModel::findOne($id);
        $form = new GoodsCategoryForm();
        $form->setAttributes($model->getAttributes());
        
        return $form;
    }

}