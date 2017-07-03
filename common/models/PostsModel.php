<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_posts".
 *
 * @property string $id
 * @property string $cat_id 分类id
 * @property string $posts_title 文章标题
 * @property string $posts_image 文章图片
 * @property string $posts_keyword 文章关键词
 * @property string $posts_link 外部链接
 * @property string $posts_desc 文章简介
 * @property string $posts_content 文章详情
 * @property string $create_time 创建时间
 * @property int $is_show 是否显示
 * @property int $is_open 是否显示外部链接
 */
class PostsModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'create_time',  'update_time', 'is_show', 'is_open'], 'integer'],
            [['posts_title'], 'required'],
            [['posts_link', 'posts_content'], 'string'],
            [['posts_title', 'posts_image', 'posts_keyword'], 'string', 'max' => 100],
            [['posts_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '文章分类',
            'posts_title' => '文章标题',
            'posts_image' => '文章图片',
            'posts_keyword' => '关键词',
            'posts_link' => '外部链接',
            'posts_desc' => '文章摘要',
            'posts_content' => '文章详情',
            'create_time' => '创建时间',
        	'update_time' => '更新时间',
            'is_show' => '是否显示',
            'is_open' => '显示外链',
        ];
    }
}
