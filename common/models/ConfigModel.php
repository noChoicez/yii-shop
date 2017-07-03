<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $type
 * @property string $desc
 */
class ConfigModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 612],
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
            'value' => 'Value',
            'type' => 'Type',
            'desc' => 'Desc',
        ];
    }
    
    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }
    
    /**
     * 获取配置信息
     */
    public static function getConfigs()
    {
        $configs = [];
        $data = static::find()->asArray()->all();
        foreach($data as $key => $val){
            $configs[$val['name']] = $val['value'];
        }
        
        return $configs;
    }

}
