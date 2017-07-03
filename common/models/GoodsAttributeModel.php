<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
use yii\helpers\Html;
/**
 * This is the model class for table "ch_goods_attribute".
 *
 * @property string $id
 * @property string $type_id 属性类型id
 * @property string $attr_name 属性名称
 * @property int $attr_index 0不检索1关键词检索2范围检索
 * @property int $attr_input_type 0文本框1选择框2文本域
 * @property string $attr_values 属性值
 * @property string $order 属性排序
 */
class GoodsAttributeModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['attr_name','required'],
            [['type_id', 'attr_index', 'attr_input_type', 'order'], 'integer'],
            [['attr_values'], 'string'],
            [['attr_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '商品类型',
            'attr_name' => '属性名称',
            'attr_index' => '是否检索',
            'attr_input_type' => '输入类型',
            'attr_values' => '属性值',
            'order' => '排序',
        ];
    }

    public static function getAttrIndex($index = '')
    {
        $attrIndex = [0=>'不检索',1=>'关键词检索','2'=>'范围检索'];
        return ($index !== '')?$attrIndex[$index]:$attrIndex;
    }

    public static function getInputType($index = '')
    {
        $inputType = [0=>'文本框',1=>'选择框',2=>'文本域'];
        return ($index !== '')?$inputType[$index]:$inputType;
    } 
    
    public function getInitialPreviewConfig($goods_id)
    {
    	$attr = [];
    	if($goods_id)
    		$attr['type_id'] = GoodsAttrModel::getTypeIdByGoodsId($goods_id);
    	return $attr;
    }
    
    public function getGoodsAttributeByTypeId($type_id, $goods_id)
    {
    	//商品属性
    	$result = self::find()
    		->where(['type_id' => $type_id])
    		->asArray()
    		->all();
		$attr = GoodsAttrModel::find()
			->where(['goods_id' => $goods_id])
			->asArray()
			->all();
		$attr = setArrayKeyWithColumKey($attr,'attr_id');
    	//商品属性html
 		$html = '';
    	foreach($result as $k => $v){
    		if(isset($v)){
    			$html .= '<div class="form-group"><div class="row">';
    			$html .= '<div class="col-sm-2 max-width-120"><label>'.$v['attr_name'].'：</label></div><div class="col-sm-10"><div class="row"><div class="col-sm-8">';
    			if($v['attr_input_type'] == 1){
    				$data[$k] = setArrayKeyWithColumVal(array_filter(explode(PHP_EOL, $v['attr_values'])));
    				$html .= Html::dropDownList('GoodsForm[attribute][attr]['.$v['id'].']',$attr[$v['id']]['attr_value']??'',$data[$k],['class'=>'form-control']);
    			}elseif($v['attr_input_type'] == 2){
    				$html .= Html::textarea('GoodsForm[attribute][attr]['.$v['id'].']',$attr[$v['id']]['attr_value']??'',['class'=>'form-control']);
    			}else{
    				$html .= Html::textInput('GoodsForm[attribute][attr]['.$v['id'].']',$attr[$v['id']]['attr_value']??'',['class'=>'form-control']);
    			}
    			
    			$html .= '</div></div></div></div></div>';
    		}
    	}
    	return $html;
    }
}
