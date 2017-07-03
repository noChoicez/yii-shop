<?php 
namespace backend\modules\goods\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use common\models\GoodsModel;
use common\models\GoodsImageModel;
use common\models\GoodsSpecModel;
use common\models\GoodsSpecImageModel;
use common\models\GoodsSpecPriceModel;
use common\models\GoodsSpecItemModel;
use common\models\GoodsAttributeModel;
use common\models\GoodsAttrModel;


class GoodsForm extends Model
{
	 public $id;
	 public $cat_id; 			//分类id
	 public $brand_id; 			//品牌id
	 public $goods_name; 		//商品名称
	 public $goods_image; 		//商品图片
	 public $goods_number; 		//商品编号
	 public $goods_keyword;		//商品关键词
	 public $goods_desc; 		//商品详情
	 public $goods_remark; 		//商品备注
	 public $goods_weight; 		//商品重量(克)
	 public $market_price; 		//市场价
	 public $shop_price; 		//本店价
	 public $cost_price; 		//成本价
	 public $stock_count; 		//库存数
	 public $comment_count;		//评论数
	 public $click_count; 		//点击数
	 public $collect_count; 	//收藏数
	 public $sale_count; 		//商品销量
	 public $create_time; 		//创建时间
	 public $update_time; 		//更新时间
	 public $is_free_shipping; 	//是否包邮
	 public $is_new; 			//是否新品
	 public $is_hot; 			//是否热卖
	 public $is_sale; 			//是否上架

     public $album;             //商品相册
     public $spec;              //商品规格
     public $attribute;         //商品属性

	 public $_lastError;

	 /**
	  * 定义场景
	  * SCENARIOS_CREATE 商品添加场景
	  * SCENARIOS_UPDATE 商品更新场景
	  */
	 const SCENARIOS_CREATE = 'create';
	 const SCENARIOS_UPDATE = 'update';

	 /**
	  * 定义事件
	  * EVENT_AFTER_SAVE 商品保存后的事件
	  */
	 const EVENT_AFTER_SAVE = 'eventAfterSave';

	 public function scenarios()
	 {
	 	$scenarios = [
	 		self::SCENARIOS_CREATE => ['cat_id', 'brand_id', 'goods_name', 'goods_image', 'goods_number', 'goods_keyword', 'goods_desc', 'goods_remark', 'goods_weight', 'market_price', 'shop_price', 'cost_price','stock_count', 'create_time', 'update_time', 'is_free_shipping', 'album', 'spec', 'attribute'],
	 		self::SCENARIOS_UPDATE => ['cat_id', 'brand_id', 'goods_name', 'goods_image', 'goods_number', 'goods_keyword', 'goods_desc', 'goods_remark', 'goods_weight', 'market_price', 'shop_price', 'cost_price','stock_count', 'update_time', 'is_free_shipping', 'album', 'spec', 'attribute'],
	 	];
	 	return array_merge(parent::scenarios(), $scenarios);
	 }

	 /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['cat_id', 'brand_id', 'goods_name'], 'required'],
            [['id', 'cat_id', 'brand_id', 'goods_weight', 'stock_count', 'comment_count', 'click_count', 'collect_count', 'sale_count', 'create_time', 'update_time', 'is_free_shipping', 'is_new', 'is_hot', 'is_sale'], 'integer'],
            [['goods_desc'], 'string'],
            [['market_price', 'shop_price', 'cost_price'], 'number'],
            [['goods_name', 'goods_image', 'goods_remark'], 'string', 'max' => 255],
            [['goods_number'], 'string', 'max' => 50],
            [['goods_keyword'], 'string', 'max' => 100],
            ['goods_image','string'],
            //['album','default', 'value' => ''],
            ['spec','default', 'value' => ''],
            ['attribute','default', 'value' => ''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '分类',
            'brand_id' => '品牌',
            'goods_name' => '商品名称',
            'goods_image' => '缩略图',
            'goods_number' => '商品编号',
            'goods_keyword' => '商品关键词',
            'goods_desc' => '商品详情',
            'goods_remark' => '商品备注',
            'goods_weight' => '商品重量',
            'market_price' => '市场价',
            'shop_price' => '本店价',
            'cost_price' => '成本价',
            'stock_count' => '库存数',
            'comment_count' => '评论数',
            'click_count' => '点击数',
            'collect_count' => '收藏数',
            'sale_count' => '商品销量',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'is_free_shipping' => '是否包邮',
            'is_new' => '是否上新',
            'is_hot' => '是否热卖',
            'is_sale' => '是否上架',
        ];
    }

    /**
     * 添加商品
     * @return [type] [description]
     */
    public function create()
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$model = new GoodsModel();
    		$model->cat_id = $this->cat_id;
    		$model->brand_id = $this->brand_id;
    		$model->goods_name = $this->goods_name;
    		$model->goods_image = $this->goods_image;
    		$model->goods_number = $this->goods_number;
    		$model->goods_remark = $this->goods_remark;
    		$model->goods_weight = $this->goods_weight;
    		$model->goods_keyword = $this->goods_keyword;
    		$model->goods_desc = $this->goods_desc;
    		$model->market_price = $this->market_price;
    		$model->shop_price = $this->shop_price;
    		$model->cost_price = $this->cost_price;
    		$model->stock_count = $this->stock_count;
    		$model->is_free_shipping = $this->is_free_shipping;
    		if(!$model->save())
    			throw new \Exception("商品添加失败！");
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
     * 更新商品
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update($id)
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$model = GoodsModel::findOne($id);
    		$model->cat_id = $this->cat_id;
    		$model->brand_id = $this->brand_id;
    		$model->goods_name = $this->goods_name;
    		$model->goods_image = $this->goods_image;
    		$model->goods_number = $this->goods_number;
    		$model->goods_remark = $this->goods_remark;
    		$model->goods_weight = $this->goods_weight;
    		$model->goods_keyword = $this->goods_keyword;
    		$model->goods_desc = $this->goods_desc;
    		$model->market_price = $this->market_price;
    		$model->shop_price = $this->shop_price;
    		$model->cost_price = $this->cost_price;
    		$model->stock_count = $this->stock_count;
    		$model->is_free_shipping = $this->is_free_shipping;
    		if(!$model->save())
    			throw new \Exception("商品更新失败！");
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
     * 商品保存后触发事件
     * @param  [type] [description]
     * @return [type] [description]
     */
    public function _eventAfterSave($data)
    {
    	$this->on(self::EVENT_AFTER_SAVE, [$this, '_eventUpdateImage'], $data);
    	$this->on(self::EVENT_AFTER_SAVE, [$this, '_eventUpdateAttribute'], $data);
    	$this->on(self::EVENT_AFTER_SAVE, [$this, '_eventUpdateSpec'], $data);

    	$this->trigger(self::EVENT_AFTER_SAVE);
    }

    /**
     * 更新商品图片
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function _eventUpdateImage($event)
    {
    	//删除之前的商品商品图片
    	GoodsImageModel::deleteAll(['goods_id' => $event->data['id']]);
    	
    	//批量添加商品图片
    	$rows = [];
    	$album = array_values(array_filter($event->data['album']));
    	foreach($album as $k => $v){
    		if($v){
    			$rows[$k]['goods_id'] = $event->data['id'];
    			$rows[$k]['url'] = $v;
    		}
    	}
    	if($rows){
    		$result = (new Query())->createCommand()
    		->batchInsert(GoodsImageModel::tableName(), ['goods_id', 'url'], $rows)
    		->execute();
    		if(!$result)
    			throw new \Exception('商品图片保存失败，请重新添加！');
    	}
    }

    /**
     * 更新商品规格相关信息
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function _eventUpdateSpec($event)
    {
    	$items = $event->data['spec']['item']??[];
    	$images = array_filter($event->data['spec']['image'])??[]; 
    	
    	//删除规格项图片关联关系
 		GoodsSpecImageModel::deleteAll(['goods_id' => $event->data['id']]);
 		//删除规格项价格关联关系
 		GoodsSpecPriceModel::deleteAll(['goods_id' => $event->data['id']]);
    	
 		//格式化数据
 		$spec_items  = []; //商品规格信息
 		$spec_images = []; //商品规格图片
 		foreach ($items as $k => $v){
 			$spec_items[$k]['goods_id'] = $event->data['id'];
 			$spec_items[$k]['type_id'] = $event->data['spec']['type_id'];
 			$spec_items[$k]['key'] = $k;
 			$spec_items[$k]['key_name'] = $v['key_name'];
 			$spec_items[$k]['price'] = $v['price'];
 			$spec_items[$k]['stock_count'] = $v['stock_count'];
 			$spec_items[$k]['sku'] = $v['sku'];
 		}
 		foreach($images as $k => $v){
 			$spec_images[$k]['goods_id'] = $event->data['id'];
 			$spec_images[$k]['item_id'] = $k;
 			$spec_images[$k]['image'] = $v;
 		}
 		
 		//批量添加商品规格
 		if($spec_items){
 			$res = (new \yii\db\Query())->createCommand()
 				->batchInsert(GoodsSpecPriceModel::tableName(), ['goods_id','type_id','key','key_name','price','stock_count','sku'], array_values($spec_items))
 				->execute();
 			if(!$res)
 				throw new \Exception("商品规格信息保存失败！请重新添加");
 		}
 		//批量添加商品规格图片
 		if($images){
 			$res = (new \yii\db\Query())->createCommand()
	 			->batchInsert(GoodsSpecImageModel::tableName(), ['goods_id','item_id','image'], array_values($spec_images))
	 			->execute();
 			if(!$res)
 				throw new \Exception("商品规格图片保存失败！请重新添加");
 		}
 		
 		
    }
    
    /**
     * 更新商品属性
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function _eventUpdateAttribute($event)
    {
    	//删除商品属性关联关系
    	GoodsAttrModel::deleteAll(['goods_id' => $event->data['id']]);
    	
    	$attrs = $event->data['attribute']['attr']??[];
    	$goods_attrs = [];
    	foreach($attrs as $k => $v){
    		$goods_attrs[$k]['goods_id'] = $event->data['id'];
    		$goods_attrs[$k]['type_id'] = $event->data['attribute']['type_id'];
    		$goods_attrs[$k]['attr_id'] = $k;
    		$goods_attrs[$k]['attr_value'] = $v;
    	}
    	//批量添加商品属性
    	if($goods_attrs){
    		$res = (new \yii\db\Query())->createCommand()
	 			->batchInsert(GoodsAttrModel::tableName(), ['goods_id','type_id','attr_id','attr_value'], array_values($goods_attrs))
	 			->execute();
 			if(!$res)
 				throw new \Exception("商品属性保存失败！请重新添加");
    	}
    }

    public static function findOne($id)
    {	
    	$model = GoodsModel::findOne($id);
    	$goodsImageModel = new GoodsImageModel();
    	$goodsSpecModel = new GoodsSpecModel();
		$goodsAttributeModel = new GoodsAttributeModel();
    	
    	$form = new GoodsForm();
		$form->setAttributes($model->getAttributes());
    	$form->album = $goodsImageModel->getInitialPreviewConfig($id);
		$form->spec = $goodsSpecModel->getInitialPreviewConfig($id);
    	$form->attribute = $goodsAttributeModel->getInitialPreviewConfig($id);
		
    	return $form;
    }

}