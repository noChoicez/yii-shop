<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminModel;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $status;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\AdminModel', 'message' => '用户名已存在 '],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\AdminModel', 'message' => '邮箱已存在 '],
    
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'密码不一致'],
        
            ['status', 'default', 'value' => AdminModel::STATUS_ACTIVE],
            ['status', 'in', 'range' => [AdminModel::STATUS_ACTIVE, AdminModel::STATUS_DELETED]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'email'=>'邮箱',
            'repassword'=>'重复密码',
            'status'=>'状态',
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new AdminModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
