<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_posts_category".
 *
 * @property string $id
 * @property int $level
 * @property string $parent_id
 * @property string $cat_name
 * @property string $cat_desc
 * @property string $cat_path
 * @property string $is_show
 * @property string $order
 */
class PostsCategoryModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_posts_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parent_id', 'order', 'is_show'], 'integer'],
            [['cat_name'], 'required'],
            [['cat_name'], 'string', 'max' => 50],
            [['cat_desc'], 'string', 'max' => 255],
            [['cat_path'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '等级',
            'parent_id' => '父级分类',
            'cat_name' => '分类名称',
            'cat_desc' => '分类描述',
            'cat_path' => '分类路径',
            'order' => '分类排序',
        ];
    }
    
    /**
     * 获取所有子分类
     * @return [type] [description]
     */
    public static function getPostsCategory()
    {
    	$array = self::find()
    	->select('id, cat_name, level, parent_id')
    	->orderBy(['substring_index(cat_path,"-",1)' => SORT_ASC,'length(substring_index(cat_path,"-",2))' => SORT_ASC,'cat_path' => SORT_ASC])
    	->asArray()
    	->all();
   		
    	return getCatTreeOptions(getCatTree($array));
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
}
