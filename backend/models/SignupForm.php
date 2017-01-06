<?php
namespace backend\models;

use common\models\Adminuser;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $nickname;
    public $email;
    public $password_hash;
    public $password_repeat;
    public $profile;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该用户名已被使用！'],
            ['username', 'string', 'min' => 6, 'max' => 16],
            ['username', 'match', 'pattern' => '/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u', 'message' => '用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],

            ['nickname','required'],
            ['nickname','string','max'=>128],

            ['profile','string','max'=>256],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该邮箱已经被注册！'],

            [['password_hash', 'password_repeat'], 'required'],
            [['password_hash', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash', 'message' => '两次输入的密码不一致！'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password_hash' => '密码',
            'password_repeat' => '重复密码',
            'profile' => '描述',
            'nickname'=>'昵称',
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

        $user = new Adminuser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->nickname = $this->nickname;
        $user->profile =$this->profile;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
