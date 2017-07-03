<?php
namespace backend\modules\goods\models;

use Yii;
use yii\base\Model;
use common\models\GoodsBrandModel;

class GoodsBrandForm extends Model
{
    public $id;
    public $cat_id;
    public $name;
    public $url;
    public $logo;
    public $desc;
    public $order;

    public $_lastError;

    /**
     * 定义场景
     */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    /**
     * 定义事件
     */
    const EVENT_BEFORE_SAVE = 'eventBeforeSave';
    const EVENT_AFTER_SAVE  = 'eventAfterSave';

    public function scenarios()
    {
        $scenarios = [
            self::SCENARIOS_CREATE => ['cat_id','name','url','logo','desc','order'],
            self::SCENARIOS_UPDATE => ['cat_id','name','url','logo','desc','order'],
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cat_id', 'order'], 'integer'],
            [['url', 'desc','name','logo'], 'string', 'max' => 255],
        	['order', 'default', 'value' => 50],
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
    
    /**
     * 添加商品品牌
     * @return [type] [description]
     */
    public function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new GoodsBrandModel();
            $model->cat_id = $this->cat_id;
            $model->name = $this->name;
            $model->url = $this->url;
            $model->logo = $this->logo;
            $model->desc = $this->desc;
            $model->order = $this->order;
            if(!$model->save())
            	throw new \Exception("商品品牌保存失败！");
            $this->id = $model->id;

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
    
    /**
     * 更新商品品牌
     */
    public function update($id)
    {
        $transaciton = Yii::$app->db->beginTransaction();
        try {
            $model = GoodsBrandModel::findOne($id);
            $model->cat_id = $this->cat_id;
            $model->name = $this->name;
            $model->url = $this->url;
            $model->logo = $this->logo;
            $model->desc = $this->desc;
            $model->order = $this->order;
            if(!$model->save())
            	throw new \Exception("商品品牌保存失败！");
            $this->id = $model->id;

            $transaciton->commit();
            return true;
        } catch (\Exception $e) {
            $transaciton->rollBack();
            $this->_lastError = $e->getMessage();
            return false; 
        }
    }

    public static function findOne($id)
    {
        $model = GoodsBrandModel::findOne($id);
        $form = new GoodsBrandForm();
		$form->setAttributes($model->getAttributes());

        return $form;
    }

}