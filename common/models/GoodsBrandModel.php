<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "ch_goods_brand".
 *
 * @property string $id
 * @property string $cat_id 分类id
 * @property string $name 品牌名称
 * @property string $url 品牌网址
 * @property string $logo 品牌LOGO
 * @property string $desc 品牌描述
 * @property string $order 品牌排序
 */
class GoodsBrandModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'order'], 'integer'],
            [['name'], 'required'],
            [['name', 'logo'], 'string', 'max' => 255],
            [['url', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '所属分类',
            'name' => '品牌名称',
            'url' => '品牌网址',
            'logo' => '品牌LOGO',
            'desc' => '品牌描述',
            'order' => '品牌排序',
        ];
    }
    
    public function getCat()
    {
        return $this->hasOne(GoodsCategoryModel::className(), ['id' => 'cat_id']);
    }

    /**
     * 获取所有品牌
     */
    public static function getGoodsBrand()
    {
    	$array[''] = '请选择品牌';
    	$arr = self::find()->asArray()->all();
    	foreach($arr as $k => $v){
    		$array[$v['id']] = $v['name'];
    	}
    	return $array;
    }
}
