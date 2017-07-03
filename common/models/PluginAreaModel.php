<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%plugin_area}}".
 *
 * @property string $id 表id
 * @property string $name 地区名称
 * @property int $level 地区等级 分省市县区
 * @property int $parent_id 父id
 */
class PluginAreaModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin_area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'level' => 'Level',
            'parent_id' => 'Parent ID',
        ];
    }
    
    public function province()
    {
    	return createArrayForDropDownList(self::find()->select(['id','name'])->where(['level' => 1, 'parent_id' => 0])->asArray()->all());
    }
    
    public function city($id)
    {
    	return json_encode(self::find()->select(['id','name'])->where(['level' => 2, 'parent_id' => $id])->asArray()->all());
    }
    
    public function district($id)
    {
    	return json_encode(self::find()->select(['id','name'])->where(['level' => 3, 'parent_id' => $id])->asArray()->all());
    }
}
