<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_goods_category".
 *
 * @property string $id 分类id
 * @property string $level 分类等级
 * @property string $parent_id 父级id
 * @property string $cat_name 分类名称
 * @property string $cat_path 分类路径
 * @property string $cat_image 分类图片
 * @property string $cat_desc 分类描述
 * @property string $order 分类排序
 * @property int $is_show 是否显示
 */
class GoodsCategoryModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parent_id', 'order', 'is_show'], 'integer'],
            [['cat_name', 'cat_image'], 'string', 'max' => 50],
            [['cat_desc', 'cat_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '分类等级',
            'parent_id' => '父级分类',
            'cat_name' => '分类名称',
            'cat_image' => '分类图片',
            'cat_desc' => '分类描述',
            'cat_path' => '排序路径',
            'order' => '分类排序',
            'is_show' => '是否显示',
        ];
    }

    /**
     * 获取所有子分类
     * @return [type] [description]
     */
    public static function getGoodsCategory($is_array = false)
    {
        $array = self::find()
            ->select('id, cat_name, level, parent_id')
            ->asArray()
            ->all();
        return $is_array?getCatTree($array):getCatTreeOptions(getCatTree($array));
    }

    /**
     * 判断是否有子分类
     * @param  integer $id [description]
     * @return boolean     [description]
     */
    public static function hasChild($id = 0)
    {
        return self::findOne(['parent_id' => $id]);
    }

    /**
     * 获取分类深度
     * @param  integer $level [description]
     * @return [type]         [description]
     */
    public static function getSpace($level = 1)
    {
        $space = '';
        for($i = 1; $i < $level; $i ++){
            $space .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        //$space .= ($level >= 2)?'└─ ':''; 
        return $space;
    }

    public static function getCatName($id)
    {
        $array = static::findOne($id);
        return $id?$array['cat_name']:'顶级分类';
    } 
    
    public static function getAllChildCatById($cat_id = 0)
    {
    	$ids = self::find()->select(['id'])->where(['parent_id' => $cat_id])->asArray()->all();
    	foreach($ids as $k => $v){
    		unset($ids[$k]);
    		$ids[$k] = $v['id'];
    	}
    	return $ids;
    }
    
    public static function getAllCatById($cat_id = 0)
    {
    	static $ids = '';
    	$id = self::find()->select(['id'])->where(['parent_id' => $cat_id])->asArray()->all();
    	foreach($id as $k => $v){
    		$ids[] = $v['id'];
    		self::getAllCatById($v['id']);
    	}
    	
    	return $ids;
    }
    
    
}
