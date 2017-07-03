<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_goods_spec_price".
 *
 * @property string $goods_id
 * @property string $key
 * @property string $key_name
 * @property string $price
 * @property string $stock_count
 * @property string $sku
 *
 */
class GoodsSpecPriceModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_spec_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'stock_count'], 'integer'],
            [['price'], 'number'],
            [['key'], 'string', 'max' => 100],
            [['key_name'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 50],
            //[['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsModel::className(), 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'key' => 'Key',
            'key_name' => 'Key Name',
            'price' => 'Price',
            'stock_count' => 'Stock Count',
            'sku' => 'Sku',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(GoodsModel::className(), ['id' => 'goods_id']);
    }
    
    /**
     * 通过商品id获取商品规格的type_id
     * @param unknown $id
     */
    public static function getTypeIdByGoodsId($goods_id)
    {
    	$result = self::find()->where(['goods_id'=>$goods_id])->one();
    	return $result['type_id'];
    }
    
    public static function getSpecPriceKeyByGoodsId($goods_id)
    {
    	$result = self::find()->select(['key'])->where(['goods_id'=>$goods_id])->asArray()->all();
    	$keys = [];
    	foreach($result as $k => $v){
    		$keys = array_merge($keys,explode('_', $v['key']));
    	}
    	return array_values(array_unique($keys));
    }
    
    public static function getSpecPriceByGoodsId($goods_id)
    {
    	return self::find()->where(['goods_id'=>$goods_id])->asArray()->all();
    }
}
