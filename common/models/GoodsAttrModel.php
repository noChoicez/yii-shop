<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_goods_attr".
 *
 * @property string $goods_id
 * @property string $attr_id
 * @property string $attr_value
 */
class GoodsAttrModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'attr_id'], 'integer'],
            [['attr_value'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'attr_id' => 'Attr ID',
            'attr_value' => 'Attr Value',
        ];
    }
    
    /**
     * 通过商品id获取商品属性的type_id
     * @param unknown $id
     */
    public static function getTypeIdByGoodsId($goods_id)
    {
    	$result = self::find()->where(['goods_id'=>$goods_id])->one();
    	return $result['type_id'];
    }
}
