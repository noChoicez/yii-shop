<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ch_promo_coupon".
 *
 * @property string $id
 * @property int $type 优惠券类型0满减1满折2免邮
 * @property string $name 优惠券名称
 * @property string $desc 优惠券描述
 * @property int $range 作用范围0全场1指定商品
 * @property string $create_num 发放总数量
 * @property string $send_num 已发放数量
 * @property string $use_num 已使用数量
 * @property string $send_type 发放类型
 * @property string $send_start_time 发放开始时间
 * @property string $send_end_time 发放结束时间
 * @property string $use_start_time 使用开始时间
 * @property string $use_end_time 使用结束时间
 * @property string $create_time 创建事件
 */
class PromoCouponModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_promo_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'range', 'create_num', 'send_num', 'use_num', 'send_type', 'send_start_time', 'send_end_time', 'use_start_time', 'use_end_time', 'create_time'], 'integer'],
            [['desc'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '优惠类型',
            'name' => '优惠券名称',
            'desc' => '描述',
            'range' => '作用范围',
            'create_num' => '发放总数量',
            'send_num' => '已发放数量',
            'use_num' => '已使用数量',
            'send_type' => '发放类型',
            'send_start_time' => '发放开始时间',
            'send_end_time' => '发放结束时间',
            'use_start_time' => '使用开始时间',
            'use_end_time' => '使用结束时间',
            'create_time' => '创建时间',
        ];
    }
    
    public static function type($index = '')
    {
    	$array = [0 => '满减', 1 => '满折', 2 => '免邮'];
    	return ($index !== '')?$array[$index]:$array;
    }
    
    public static function range($index = '')
    {
    	$array = [ 0 => '全场', 1 => '指定商品'];
    	return ($index !== '')?$array[$index]:$array;
    }
    public static function sendType($index = '')
    {
    	$array = [ 0 => '自动发放', 1 => '注册发放', 2=> '指定用户'];
    	return ($index !== '')?$array[$index]:$array;
    }
}
