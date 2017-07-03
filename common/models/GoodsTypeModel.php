<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
use yii\Db\Query;

/**
 * This is the model class for table "ch_goods_type".
 *
 * @property string $id
 * @property string $name 商品类型
 */
class GoodsTypeModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => '类型名称',
        ];
    }

    /**
     * 获取商品类型列表
     * @return [type] [description]
     */
    public static function getGoodsType($id = '')
    {
        if(empty($id)){
            $GoodsTypeList = (new \Yii\db\Query())
                ->from(self::tableName())
                ->all();
            $list[''] = '请选择商品类型';
            foreach($GoodsTypeList as $k => $v)
                $list[$v['id']] = $v['name'];

            return $list;
        }else{
            $model = self::findOne($id);
            return $model->name;
        }
        
    }
}
