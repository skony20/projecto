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
    public $delivery_lastname;
    public $delivery_street_local;
    public $delivery_zip;
    public $delivery_city;
    public $delivery_country;
    public $phone;
    public $invoice_nip;
    public $invoice_lastname;
    public $invoice_firm_name;
    public $invoice_street_local;
    public $invoice_zip;
    public $invoice_city;
    public $invoice_name;
    public $invoice_country;
    public $newslatter;
    public $agreement;
    public $source;
    


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Taki użytkownik już istnieje.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Pole {attribute} nie moze być puste'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Użytkownik z tym adresem email już istnieje.'],

            ['password', 'required', 'message' => 'Pole {attribute} nie moze być puste'],
            ['password', 'string', 'min' => 6],
            ['source', 'string', 'max' => 14],
            ['newslatter', 'boolean'],
            ['agreement', 'required', 'requiredValue' => 1, 'message' => 'Wyrażenie zgody jest konieczne w celu procesowania zamówień'],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Nazwa użytkownika',
            'password' => 'Hasło',
            'source' => 'Źródło',
            'newslatter' => 'Wyrażam zgodę na otrzymywanie informacji marketingowych  i promocyjnych drogą elektroniczną zgodnie z ustawą z dn. 18.07.2002 r. o świadczeniu usług drogą elektroniczną (Dz.U. nr 144, poz. 1204, z późn. zm.)',
            'agreement'=> 'Potwierdzam że zapoznałem się z regulaminem i akceptuję jego treść oraz wyrażam zgodę na przetwarzanie moich danych osobowych potrzebnych do realizacji zamówień',
            
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
        $user->newslatter = $this->newslatter;
        $user->email = $this->email;
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
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($user->email)
            ->setSubject('Witaj na stronie:  ' . Yii::$app->name)
            ->send();
    }
}
