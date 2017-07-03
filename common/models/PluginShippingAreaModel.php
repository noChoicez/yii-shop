<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%plugin_shipping_area}}".
 *
 * @property string $plugin_shipping_id 物流插件id
 * @property string $plugin_area_id 地区id
 */
class PluginShippingAreaModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin_shipping_area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plugin_shipping_id', 'plugin_area_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plugin_shipping_id' => 'Plugin Shipping ID',
            'plugin_area_id' => 'Plugin Area ID',
        ];
    }
    
    public function getShipping()
    {
    	return $this->hasOne(PluginShippingModel::className(), ['id' => 'plugin_shipping_id']);
    }
    
    public function getArea()
    {
    	return $this->hasOne(PluginAreaModel::className(), ['id' => 'plugin_area_id']);
    }
    
    public static function getShippingAreaById($id)
    {
    	return self::find()
    		->with('area')
    		->where(['plugin_shipping_id'=>$id])
    		->asArray()
    		->all();
    }
}
