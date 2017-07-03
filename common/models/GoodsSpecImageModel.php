<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_goods_spec_image".
 *
 * @property string $goods_id
 * @property string $item_id
 * @property string $image
 *
 * @property GoodsSpecItem $item
 * @property Goods $goods
 */
class GoodsSpecImageModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_spec_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'item_id'], 'integer'],
            [['image'], 'string', 'max' => 100],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsSpecItemModel::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsModel::className(), 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'item_id' => 'Item ID',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(GoodsSpecItemModel::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(GoodsModel::className(), ['id' => 'goods_id']);
    }
    
    public static function getSpecImageByGoodsId($goods_id)
    {
    	return setArrayKeyWithColumKey(self::find()->where(array('goods_id'=>$goods_id))->asArray()->all(),'item_id');
    }
}
