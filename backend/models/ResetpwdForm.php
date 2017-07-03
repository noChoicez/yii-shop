<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminModel;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $password;
    public $repassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'密码不一致'],

        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password'=>'密码',
            'repassword'=>'重复密码',
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = AdminModel::findOne(['id'=>$id]);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        
        return $user->save() ? $user : null;
    }
}
