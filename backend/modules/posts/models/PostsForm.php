<?php
namespace backend\modules\posts\models;

use Yii;
use yii\base\Model;
use common\models\PostsModel;

class PostsForm extends Model
{
	public $id;
	public $cat_id; 		//分类id
	public $posts_title; 	//文章标题
	public $posts_image; 	//文章图片
	public $posts_keyword; 	//文章关键词
	public $posts_link; 	//外部链接
	public $posts_desc; 	//文章简介
	public $posts_content; 	//文章详情
	public $create_time; 	//创建时间
	public $update_time;	//更新时间
	public $is_show; 		//是否显示
	public $is_open; 		//是否显示外部链接
	
	public $_lastError;
	
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
				self::SCENARIOS_CREATE => ['cat_id','posts_title','posts_image','posts_keyword','posts_link','posts_desc','posts_content','create_time','update_time','is_show','is_open'],
				self::SCENARIOS_UPDATE => ['cat_id','posts_title','posts_image','posts_keyword','posts_link','posts_desc','posts_content','update_time','is_show','is_open'],
		];
		return array_merge(parent::scenarios(), $scenarios);
	}
	
/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'create_time', 'is_show', 'is_open'], 'integer'],
            [['posts_title'], 'required'],
            [['posts_link', 'posts_content'], 'string'],
            [['posts_title', 'posts_image', 'posts_keyword'], 'string', 'max' => 100],
            [['posts_desc'], 'string', 'max' => 255],
        	[['create_time', 'update_time'],'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '文章分类',
            'posts_title' => '文章标题',
            'posts_image' => '文章图片',
            'posts_keyword' => '关键词',
            'posts_link' => '外部链接',
            'posts_desc' => '文章摘要',
            'posts_content' => '文章详情',
            'create_time' => '创建时间',
            'is_show' => '是否显示',
            'is_open' => '显示外链',
        ];
    }
	
	/**
	 * 添加
	 */
	public function create()
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$model = new PostsModel();
			$model->cat_id = $this->cat_id;
			$model->posts_title = $this->posts_title;
			$model->posts_image = $this->posts_image;
			$model->posts_keyword = $this->posts_keyword;
			$model->posts_link = $this->posts_link;
			$model->posts_desc = $this->posts_desc;
			$model->posts_content = $this->posts_content;
			$model->is_show = $this->is_show;
			$model->is_open = $this->is_open;
			if(!$model->save())
				throw new \Exception("文章保存失败！");
			$this->id = $model->id;
			
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
			$model = PostsModel::findOne($id);
			$model->cat_id = $this->cat_id;
			$model->posts_title = $this->posts_title;
			$model->posts_image = $this->posts_image;
			$model->posts_keyword = $this->posts_keyword;
			$model->posts_link = $this->posts_link;
			$model->posts_desc = $this->posts_desc;
			$model->posts_content = $this->posts_content;
			$model->is_show = $this->is_show;
			$model->is_open = $this->is_open;
			if(!$model->save())
				throw new \Exception("文章保存失败！");
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
	 * 保存之前的操作
	 */
	public function boforeSave()
	{
		
	}
	
	/**
	 * 保存之后触发的事件
	 * @param unknown $data
	 */
	public function _eventAfterSave($data)
	{
		$this->on(self::EVENT_AFTER_SAVE, [$this, '', $data]);
		$this->trigger(self::EVENT_AFTER_SAVE);
	}
	
	public static function findOne($id)
	{
		$model = PostsModel::findOne($id);
		$form = new PostsForm();
		$form->setAttributes($model->getAttributes());
		
		return $form;
	}
}