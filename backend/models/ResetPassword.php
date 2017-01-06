<?php
namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;

/**
 * Password reset form
 */
class ResetPassword extends Model
{
    public $password;
    public $password_repeat;

    public function rules(){
        return[
            [['password','password_repeat'],'required'],
            [['password','password_repeat'],'string','min'=>6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入密码不一致'],
        ];
    }

    public function attributeLabels(){
        return[
            'password' => '密码',
            'password_repeat'=>'重复密码',
        ];
    }

    public function resetPassword($id){
        if(!$this->validate()){
            return null;
        }

        $adminuser = Adminuser::findOne($id);
        $adminuser->setPassword($this->password);
        $adminuser->removePasswordResetToken();
        return $adminuser->save() ? true : false;
    }
}
