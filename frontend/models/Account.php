<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class Account extends Model
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

            ['password', 'string', 'min' => 6],
            ['phone', 'integer'],
            ['invoice_nip', 'integer'],
            ['delivery_name', 'string', 'min' => 2, 'max' => 255],
            ['delivery_lastname', 'string', 'min' => 2, 'max' => 255],
            ['delivery_street_local', 'string', 'min' => 2, 'max' => 255],
            ['delivery_zip', 'string', 'min' => 2, 'max' => 6],
            ['delivery_zip', 'match', 'pattern' => '/[0-9]{2}[-][0-9]{3}/'],
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
            [['delivery_name', 'delivery_lastname', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country', 'phone'], 'required'],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' =>'Nazwa użytkownika',
            'password' =>'Hasło',
            'email' =>'Adres email',
            'phone' =>'Telefon',
            'delivery_name' =>'Imię',
            'delivery_lastname' =>'Nazwisko',
            'delivery_street_local' =>'Adres',
            'delivery_zip' =>'Kod pocztowy',
            'delivery_city' =>'Miasto',
            'delivery_country' =>'Państwo',
            'invoice_name' =>'Imię',
            'invoice_lastname' =>'Nazwisko',
            'invoice_firm_name' =>'Nazwa firmy',
            'invoice_street_local' =>'Adres',
            'invoice_zip' =>'Kod pocztowy',
            'invoice_city' =>'Miasto',
            'invoice_country' =>'Państwo',
            'invoice_nip' =>'Numer NIP',
            
        ];

    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function changePassword()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $oUser = new User();
        $model = $oUser->findIdentity(Yii::$app->user->identity->id);
        //echo '<pre>'. print_r($this->password, TRUE);die();
        $model->setPassword($this->password);
        
        $model->save();
    }
     public function changeData()
    {
        $oUser = new User();
        $model = $oUser->findIdentity(Yii::$app->user->identity->id);
        //echo '<pre>'. print_r($this->delivery_name, TRUE); die();
        $model->delivery_name = $this->delivery_name;
        $model->delivery_lastname = $this->delivery_lastname;
        $model->delivery_street_local = $this->delivery_street_local;
        $model->delivery_zip = $this->delivery_zip;
        $model->delivery_city = $this->delivery_city;
        $model->delivery_country = $this->delivery_country;
        $model->invoice_name = $this->invoice_name;
        $model->invoice_lastname = $this->invoice_lastname;
        $model->invoice_firm_name = $this->invoice_firm_name;
        $model->invoice_street_local = $this->invoice_street_local;
        $model->invoice_zip = $this->invoice_zip;
        $model->invoice_city = $this->invoice_city;
        $model->invoice_country = $this->invoice_country;
        $model->invoice_nip = $this->invoice_nip;
        $model->save();
    }
    
}
