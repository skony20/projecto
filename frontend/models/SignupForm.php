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
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Użytkownik z tym adresem email już istnieje.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['phone', 'integer'],
            [['delivery_name', 'delivery_lastname', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country', 'phone'], 'required'],
            ['delivery_name', 'string', 'min' => 2, 'max' => 255],
            ['delivery_lastname', 'string', 'min' => 2, 'max' => 255],
            ['delivery_street_local', 'string', 'min' => 2, 'max' => 255],
            ['delivery_zip', 'string', 'min' => 2, 'max' => 255],
            ['delivery_city', 'string', 'min' => 2, 'max' => 255],
            ['delivery_country', 'string', 'min' => 2, 'max' => 255],
            ['invoice_nip', 'string', 'min' => 2, 'max' => 255],
            ['invoice_lastname', 'string', 'min' => 2, 'max' => 255],
            ['invoice_firm_name', 'string', 'min' => 2, 'max' => 255],
            ['invoice_street_local', 'string', 'min' => 2, 'max' => 255],
            ['invoice_zip', 'string', 'min' => 2, 'max' => 255],
            ['invoice_city', 'string', 'min' => 2, 'max' => 255],
            ['invoice_name', 'string', 'min' => 2, 'max' => 255],
            ['invoice_country', 'string', 'min' => 2, 'max' => 255],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Nazwa użytkownika',
            'password' => 'Hasło',
            'email' => 'Adres email',
            'phone' => 'Telefon',
            'delivery_name' => 'Imię',
            'delivery_lastname' => 'Nazwisko',
            'delivery_street_local' => 'Adres',
            'delivery_zip' => 'Kod pocztowy',
            'delivery_city' => 'Miasto',
            'delivery_country' => 'Państwo',
            'invoice_name' => 'Imię',
            'invoice_lastname' => 'Nazwisko',
            'invoice_firm_name' => 'Nazwa firmy',
            'invoice_street_local' => 'Adres',
            'invoice_zip' => 'Kod pocztowy',
            'invoice_city' => 'Miasto',
            'invoice_country' => 'Państwo',
            'invoice_nip' => 'Numer NIP',
            
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
        $user->delivery_lastname = $this->delivery_lastname;
        $user->delivery_street_local = $this->delivery_street_local;
        $user->delivery_zip = $this->delivery_zip;
        $user->delivery_city = $this->delivery_city;
        $user->delivery_country = $this->delivery_country;
        $user->phone = $this->phone;
        $user->invoice_nip = $this->invoice_nip;
        $user->invoice_lastname = $this->invoice_lastname;
        $user->invoice_firm_name = $this->invoice_firm_name;
        $user->invoice_street_local = $this->invoice_street_local;
        $user->invoice_zip = $this->invoice_zip;
        $user->invoice_city = $this->invoice_city;
        $user->invoice_name = $this->invoice_name;
        $user->invoice_country = $this->invoice_country;
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
