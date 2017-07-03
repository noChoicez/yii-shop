<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
use common\models\GoodsSpecItemModel;
use common\models\GoodsSpecPriceModel;


/**
 * This is the model class for table "ch_goods_spec".
 *
 * @property string $id
 * @property string $type_id 商品类型id
 * @property string $spec_name 规格名称
 * @property int $spec_index 是否检索
 * @property string $order 排序
 */
class GoodsSpecModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'spec_name'], 'required'],
            [['type_id', 'spec_index', 'order'], 'integer'],
            [['spec_name'], 'string', 'max' => 50],
            ['spec_value', 'string'],
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
            'spec_name' => '规格名称',
            'spec_index' => '是否检索',
            'order' => '排序',
        ];
    }
    
    public function getItems()
    {
    	return $this->hasMany(GoodsSpecItemModel::className(), ['spec_id' => 'id']);
    }
    
    public function getGoodsSpecNamesByIds($ids)
    {
    	return self::find()->where(['in', 'id', $ids])->asArray()->all();
    }
    
    /**
     * 获取商品规格初始化配置
     */
    public function getInitialPreviewConfig($id)
    {
    	$spec = [];
    	if($id){
    		$spec['type_id'] = GoodsSpecPriceModel::getTypeIdByGoodsId($id);
    	}
    	return $spec;
    }
    
    /**
     * 获取规格input框
     * @param unknown $spec_arr
     * @return string
     */
    public function getGoodsSpecInput($spec_arr, $goods_id)
    {
    	//规格排序数组
    	$spec_arr_sort = []; 
    	//规格排序完成后的数组
    	$spec_arr_new = [];
    	foreach	($spec_arr as $k => $v){
    		$spec_arr_sort[$k] = count($v);
    	}
    	asort($spec_arr_sort);
    	foreach ($spec_arr_sort as $k => $v){
    		$spec_arr_new[$k] = $spec_arr[$k];
    	}
    	$colum_name = array_keys($spec_arr_new);
    	$spec = setArrayKeyWithColumKey($this->getGoodsSpecNamesByIds($colum_name));
    	$spec_item = setArrayKeyWithColumKey(GoodsSpecItemModel::getSpecItems());
    	$spec_arr_new = combineDika($spec_arr_new);
    	
    	if($goods_id)
    		$spec_price = GoodsSpecPriceModel::getSpecPriceByGoodsId($goods_id);
    	
    	//表格生成开始
    	$str = "<table class='table table-bordered' id='spec_input_tab'><thead><tr>";
    	foreach ($colum_name as $k => $v){
    		$str .= " <td>{$spec[$v]['spec_name']}</td>";
    	}
    	$str .= "<td>价格</td><td>库存</td><td>SKU</td></tr></thead><tbody>";
    	//input生成开始
    	foreach($spec_arr_new as $k => $v){
    		$str .= "<tr>";
    		$item_key_name = [];
    		foreach($v as $kk => $vv){
    			$str .= "<td>{$spec_item[$vv]['item']}</td>";
    			$item_key_name[$vv] = $spec[$spec_item[$vv]['spec_id']]['spec_name'].":".$spec_item[$vv]['item'];
    		}
    		ksort($item_key_name);
    		$item_key = implode('_', array_keys($item_key_name));
    		$item_key_name = implode(' ', $item_key_name);
    		$price[$k] = $spec_price[$k]['price']??'';
    		$stock_count[$k] = $spec_price[$k]['stock_count']??'';
    		$sku[$k] = $spec_price[$k]['sku']??'';
    		$space = '';
    		$str .= "<td><input class='form-control' name='GoodsForm[spec][item][{$item_key}][price]' value='".$price[$k]."' onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")'></td>";
    		$str .= "<td><input class='form-control' name='GoodsForm[spec][item][{$item_key}][stock_count]' value='".$stock_count[$k]."' onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")'></td>";
    		$str .= "<td><input class='form-control' name='GoodsForm[spec][item][{$item_key}][sku]' value=".$sku[$k].">
    		<input type='hidden' name='GoodsForm[spec][item][{$item_key}][key_name]' value='{$item_key_name}'></td>";
    		$str .= "</tr>";
    	}
    	$str .= "</tbody></table>";
    	return $str;
    }
    
    /**
     * 根据商品类型获取商品规格
     * @param unknown $type_id
     * @return string
     */
    public function getGoodsSpecByTypeId($type_id,$goods_id = 0)
    {
    	$result = self::find()
    		->with('items')
    		->where(['type_id' => $type_id])
    		->asArray()
    		->all();
    	$html = $this->formatGoodsSpecHtml($result, $goods_id);
    	return $html;
    }
    
    /**
     * 获取规格html
     */
    private function formatGoodsSpecHtml($result, $goods_id)
    {
    	$keys = GoodsSpecPriceModel::getSpecPriceKeyByGoodsId($goods_id);
		$images = GoodsSpecImageModel::getSpecImageByGoodsId($goods_id);
    	
    	$html = '';
    	foreach($result as $k => $v){
    		if(isset($v['items'])){
    			$html .= '<div class="form-group">'.$v['spec_name'];
    			foreach($v['items'] as $kk => $vv){
    				$class = (in_array($vv['id'], $keys))?'primary':'default';
    				$image = (isset($images[$vv['id']]))?'<img height="32" class="ml5" src='.$images[$vv['id']]['image'].'>':'<button type="button" class="btn btn-default btn-flat ml5"><i class="fa fa-image fa-lg"></i></button>';
    				$image_input = (isset($images[$vv['id']]))?$images[$vv['id']]['image']:'';
    				$html .= ' <button onclick="createDeleteInput(this)" class="btn btn-'.$class.' btn-flat ml10" type="button" data-spec_id='.$v['id'].' data-item_id='.$vv['id'].'>'.$vv['item'].'</button>';
    				$html .= '<input type="file" id='.$vv['id'].' name="Spec[image]" style="display:none" onchange="uploadFile(this)" >';
    				$html .= '<input type="hidden" id="spec-image-'.$vv['id'].'" name="GoodsForm[spec][image]['.$vv['id'].']" value='.$image_input.'>';
    				$html .= '<a onclick="selectFile(this)" id=item-'.$vv['id'].' data-item_id='.$vv['id'].' alt='.$vv['item'].'缩略图'.' title='.$vv['item'].'缩略图'.'>';
    				$html .= $image.'</a>';
    				//<img class="ml5" src="http://admin.info/upload/image/20170604/1496591084939239.jpg" width="auto" height="32">
    			}
    			$html .= '</div>';
    		}
    	}
    	return $html;
    }
}
