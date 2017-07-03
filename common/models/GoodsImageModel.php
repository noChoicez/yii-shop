<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use common\models\GoodsModel;

/**
 * This is the model class for table "ch_goods_images".
 *
 * @property string $id
 * @property string $goods_id 商品id
 * @property string $url 图片路径
 *
 * @property Goods $goods
 */
class GoodsImageModel extends \yii\db\ActiveRecord
{
	public $_lastError;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ch_goods_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['url'], 'string', 'max' => 100],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsModel::className(), 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(GoodsModel::className(), ['id' => 'goods_id']);
    }
    
    /**
     * 通过商品id获取商品图册
     * @param unknown $goods_id
     */
    public static function getGoodsImageByGoodsId($goods_id)
    {
    	return self::findByCondition(['goods_id' => $goods_id])->asArray()->all();
    }
    
    /**
     * 获取图片初始化参数
     * @param unknown $goods_id
     */
    public function getInitialPreviewConfig($goods_id)
    {
    	$album = [];
    	$albums = self::getGoodsImageByGoodsId($goods_id);
    	if($albums){
    		foreach($albums as $k => $v){
    			$album['createInputElement'][$k] = [
    					'form'     => 'GoodsForm',
    					'field'    => 'album',
    					'url'      => $v['url'],
    					'state'    => 'SUCCESS',
    					'multiple' => true,
    			];
    			$album['initialPreviewConfig'][$k] = [
    					'caption' => is_file(substr($v['url'],1))?$v['url']:'文件不存在',
    					'url'     => Url::to(['goods/delete-album']),
    					'key'     => $v['id'],
    					'size'    => is_file(substr($v['url'],1))?filesize(substr($v['url'],1)):'',
    					'extra'   => [
    						'url' 	=> $v['url'],
    						'id' 	=> $v['id'],
    					],
    			];
    			$album['initialPreview'][$k] = '<img src='.$v['url'].' class="file-preview-image">';
    		}
    	}
    	return $album;
    }
    
    /**
     * 删除图片数据
     * @param unknown $id
     */
    public function deleteImage($post)
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		self::findOne($post['id'])->delete();
    		$this->deleteImageFile($post['url']);
    		
    		$transaction->commit();
    		return true;
    	} catch (\Exception $e) {
    		$transaction->rollBack();
    		$this->_lastError = $e->getMessage();
    		return false;
    	}
    	
    }
    
    /**
     * 删除图片源文件
     */
    private function deleteImageFile($url)
    {
    	$url = substr($url, 1);
    	if(is_file($url)){
    		if(!unlink($url))
    			throw new \Exception("图片删除失败！");
    	}
    }
    
}
