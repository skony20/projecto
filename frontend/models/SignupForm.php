<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $delivery_name;
    public $invoice_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['delivery_name', 'required'],
            ['delivery_name', 'string', 'min' => 2, 'max' => 255],
            ['invoice_name', 'string', 'min' => 2, 'max' => 255],
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
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->delivery_name = $this->delivery_name;
        $user->invoice_name = $this->invoice_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
     public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->email,
            
        ]);
        //echo '<pre>'.print_r($user, TRUE); die();
        if (!$user) {
            return false;
        }
        
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'singUp-html', 'text' => 'singUp-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Witaj na stronie:  ' . Yii::$app->name)
            ->send();
    }
}
