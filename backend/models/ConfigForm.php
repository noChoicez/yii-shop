<?php
namespace backend\models;

use Yii;
use common\models\base\BaseModel;
use common\models\ConfigModel;

class ConfigForm extends BaseModel
{
    public $site_url;    //网站域名
    public $site_record; //网站备案号
    public $site_name;   //网站名称
    public $site_logo;   //网站LOGO
    public $site_title;  //网站标题
    public $site_desc;   //网站描述
    public $site_keyword;//网站关键词
    public $site_contact;//联系人
    public $site_phone;  //联系电话
    public $site_address;//具体地址
    public $site_qq_1;   //客服QQ1
    public $site_qq_2;   //客服QQ2
    public $site_qq_3;   //客服QQ3
    
    public $smtp_server; //邮件服务器
    public $smtp_port;   //服务器端口
    public $smtp_user;   //邮箱账号
    public $smtp_pass;   //邮箱密码

    public $_lastError;  //错误

    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            [['site_url','site_record','site_name','site_title'],'required'],
            ['site_url', 'url', 'defaultScheme' => 'http'],
            [['site_url','site_record','site_name','site_logo','site_title','site_desc','site_keyword','site_contact','site_address'], 'string', 'min' => 0, 'max' => 255],
            ['site_phone', 'string', 'min' => 8, 'max' => 11],
            [['site_qq_1','site_qq_2','site_qq_3'], 'string', 'min' => 1, 'max' => 10],
            [['site_phone','site_qq_1','site_qq_2','site_qq_3'], 'integer'],
        ];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'site_url'    => '网站域名',
            'site_record'  => '网站备案号',
            'site_name'   => '网站名称',
            'site_logo'   => '网站LOGO',
            'site_title'  => '网站标题',
            'site_desc'   => '网站描述',
            'site_keyword'=> '关键词',
            'site_contact'=> '联系人',
            'site_phone'  => '联系电话',
            'site_address'=> '具体地址',
            'site_qq_1'   => '客服QQ1',
            'site_qq_2'   => '客服QQ2',
            'site_qq_3'   => '客服QQ3',
            'smtp_server' => '邮件服务器',
            'smtp_port'   => '服务器端口',
            'smtp_user'   => '邮箱账号',
            'smtp_pass'   => '邮箱密码',
        ];
    }
    
    /**
     * 更新系统配置
     */
    public function updateConfig()
    {
        if(!$this->validate())
            return null; 
        $transaction = Yii::$app->db->beginTransaction(); //开启事物
        try {
            $post = Yii::$app->request->post('ConfigForm');
            $model = new ConfigModel();
            $config = [];
            foreach ($post as $k => $v){
                if($config_old[$k] = ConfigModel::findByName($k)){  //判断数据是否存在，不存在稍后执行插入操作
                    $config_old[$k]->value = ($k == 'smtp_pass')?(($config_old[$k]->value == $v)?:authcode($v,'ENCODE',Yii::$app->params['auth_code'])):$v;
                    $config_old[$k]->save();
                }else{
                    $config[] = [$k,$v];
                }
            }
            Yii::$app->db->createCommand()
                ->batchInsert(ConfigModel::tableName(), ['name', 'value'], $config)
                ->execute();  //批量插入
            $transaction->commit();  //事物提交
        } catch (Exception $e) {
            throw new \Exception('配置修改失败');  //抛出异常
            $transaction->rollBack(); //事物回滚
            $this->_lastError = $e->getMessage();
            return false; 
        }
        
        return true;
    }

}