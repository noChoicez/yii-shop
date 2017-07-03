<?php
namespace backend\modules\goods\models;

use Yii;
use yii\base\Model;
use common\modes\GoodsSpecModel;
use common\models\GoodsSpecItemsModel;

/**
 * GoodsCategory Form
 * @author Administrator
 *
 */
class GoodsSpecItemForm extends Model
{
    public $id;         //ID
    public $spec_id;    //规格ID
    public $item;       //规格项

    public $items;      //规格项集合
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spec_id'], 'integer'],
            [['item'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spec_id' => '规格ID',
            'item' => '规格项',
        ];
    }
    
    public function saveSpecItems()
    {
        $model = new GoodsSpecItemsModel();
         
    }

}