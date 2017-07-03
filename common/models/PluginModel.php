<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%plugin}}".
 *
 * @property string $id
 * @property string $type 插件类型
 * @property string $name 插件名称
 * @property string $code 插件标识
 * @property string $author 插件作者
 * @property string $version 插件版本
 * @property string $desc 插件描述
 * @property string $cover_image 插件封面图
 * @property string $back_image 物流插件打印背景图
 * @property string $config 插件配置项
 * @property string $config_value 插件配置值
 * @property int $create_time
 * @property int $install_time
 * @property int $status
 */
class PluginModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','install_time', 'create_time', 'status'], 'integer'],
            [['type','name', 'code'], 'required'],
            [['config', 'config_value'], 'string'],
            [['name', 'code', 'author', 'version', 'cover_image', 'back_image'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 255],
        	['author', 'default', 'value' => 'CH'],
        	['version', 'default', 'value' =>'1.0'],
        	[['create_time','install_time'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'code' => 'Code',
            'author' => 'Author',
            'version' => 'Version',
            'desc' => 'Desc',
            'cover_image' => 'Cover Image',
            'back_image' => 'Back Image',
            'config' => 'Config',
            'config_value' => 'Config Value',
        	'create_time' => '创建时间',
        	'install_time' => '安装时间',
        	'status' => '状态',
        ];
    }
    
    /**
     * 插件分组
     */
    
    public static function pluginGroupByType()
    {
    	return groupArrayByKey(Yii::$app->db->createCommand("SELECT * FROM ".self::tableName()." ORDER BY FIELD(`type`,'payment','shipping','custom')")->queryAll(),'type');
    }
}
