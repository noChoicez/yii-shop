<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_goods".
 *
 * @property string $id
 * @property string $cat_id 分类id
 * @property string $brand_id 品牌id
 * @property string $goods_name 商品名称
 * @property string $goods_image 商品图片
 * @property string $goods_number 商品编号
 * @property string $goods_keyword 商品关键词
 * @property string $goods_desc 商品详情
 * @property string $goods_remark 商品备注
 * @property string $goods_weight 商品重量(克)
 * @property string $market_price 市场价
 * @property string $shop_price 本店价
 * @property string $cost_price 成本价
 * @property string $stock_count 库存数
 * @property string $comment_count 评论数
 * @property string $click_count 点击数
 * @property string $collect_count 收藏数
 * @property string $sale_count 商品销量
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property int $is_free_shipping 是否包邮
 * @property int $is_new 是否新品
 * @property int $is_hot 是否热卖
 * @property int $is_sale 是否上架
 */
class GoodsModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'brand_id', 'goods_name'], 'required'],
            [['cat_id', 'brand_id', 'goods_weight', 'stock_count', 'comment_count', 'click_count', 'collect_count', 'sale_count', 'create_time', 'update_time', 'is_free_shipping', 'is_new', 'is_hot', 'is_sale'], 'integer'],
            [['goods_desc'], 'string'],
            [['market_price', 'shop_price', 'cost_price'], 'number'],
            [['goods_name', 'goods_image', 'goods_remark'], 'string', 'max' => 255],
            [['goods_number'], 'string', 'max' => 50],
            [['goods_keyword'], 'string', 'max' => 100],
            ['goods_image','string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '分类名称',
            'brand_id' => '品牌名称',
            'goods_name' => '商品名称',
            'goods_image' => '商品图片',
            'goods_number' => '商品货号',
            'goods_keyword' => '关键词',
            'goods_desc' => '商品详情',
            'goods_remark' => '商品简介',
            'goods_weight' => '商品重量',
            'market_price' => '市场价',
            'shop_price' => '本店价',
            'cost_price' => '成本价',
            'stock_count' => '库存数',
            'comment_count' => '评论数',
            'click_count' => '点击数',
            'collect_count' => '收藏数',
            'sale_count' => '商品销量',
            'create_time' => '创建事件',
            'update_time' => '更新时间',
            'is_free_shipping' => '是否包邮',
            'is_new' => '是否上新',
            'is_hot' => '是否热卖',
            'is_sale' => '是否上架',
        ];
    }
    
    /**
     * 根据分类获取产品列表
     * @param number $cat_id
     * @param bool $all
     */
    public static function getGoodsByGoodsCategory($cat_id = 0, $level = 0)
    {
    	if($level == 1){
    		$ids = GoodsCategoryModel::getAllChildCatById($cat_id);
    		$goods = self::find()->where(['in','cat_id',$ids])->asArray()->all();

    	}elseif($level == 2){
    		$ids = GoodsCategoryModel()->getAllCatById($cat_id);
    		$goods = self::find()->where(['in','cat_id',$ids])->asArray()->all();
    	}else{
    		$goods = self::find()->where(['cat_id'=>$cat_id])->asArray()->all();
    	}
    	return $goods;
    }
    
}
