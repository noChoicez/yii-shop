<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
/**
 * This is the model class for table "ch_goods_spec_items".
 *
 * @property string $id
 * @property string $spec_id 规格id
 * @property string $item 规格项
 */
class GoodsSpecItemModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_spec_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spec_id'], 'integer'],
            [['item'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spec_id' => '规格ID',
            'item' => '规格项',
        ];
    } 
    
    /**
     * 通过typeId获取规格类型项
     * @param unknown $id
     */
    public function getSpecItemsByTypeId($type_id)
    {
    	return self::findByCondition(['type_id' => $type_id])->asArray()->all();
    }
    
    /**
     * 获取所有规格项
     * @return \yii\db\ActiveRecord[]
     */
    public static function getSpecItems()
    {
    	return self::find()->asArray()->all();
    }
    
}
