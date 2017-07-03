<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%plugin_shipping}}".
 *
 * @property string $id
 * @property string $plugin_id 插件id
 * @property string $name 名称
 * @property string $first_weight 首重（单位：克）
 * @property string $first_money 首重费用
 * @property int $add_weight 续重（单位：克）
 * @property string $add_money 续重费用
 * @property string $update_time 更新时间
 */
class PluginShippingModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin_shipping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plugin_id', 'name'], 'required'],
            [['id', 'first_weight', 'add_weight', 'update_time', 'plugin_id'], 'integer'],
            [['first_money', 'add_money'], 'number'],
            [['name'], 'string', 'max' => 50],
        	['update_time','default','value'=>time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plugin_id' => 'Plugin ID',
            'name' => '地区名称',
            'first_weight' => 'First Weight',
            'first_money' => 'First Money',
            'add_weight' => 'Add Weight',
            'add_money' => 'Add Money',
            'update_time' => 'Update Time',
        ];
    }
    
    public function getPlugin()
    {
    	return $this->hasOne(PluginModel::className(), ['id' => 'plugin_id']);
    }
    
    public function getShippingArea()
    {
    	return $this->hasMany(PluginShippingAreaModel::className(), ['plugin_shipping_id' => 'id']);
    }
    
}
