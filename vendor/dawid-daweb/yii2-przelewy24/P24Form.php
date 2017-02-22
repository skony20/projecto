<?php

namespace daweb\przelewy24;

/**
 * http://www.przelewy24.pl/files/cms/2/przelewy24_specyfikacja_3_2.pdf
 * 
 * @author Dawid Bednarz <dawid@daweb.vdl.pl>
 */
class P24Form extends \yii\base\Model {

    /**
     * ID sprzedawcy
     * @var int 
     */
    public $p24_merchant_id;

    /**
     * ID Sklepu (domyślnie ID Sprzedawcy) 
     * @var int 
     */
    public $p24_pos_id;
    public $p24_api_version;

    /**
     * PLN, EUR, GBP, CZK 
     * @var string 
     */
    public $p24_currency;

    /**
     * Opis transakcji 
     * @var string
     */
    public $p24_description;

    /**
     * Imię i nazwisko Klienta
     * @var string
     */
    public $p24_client;
    public $p24_address;
    public $p24_zip;
    public $p24_city;
    public $p24_phone;
    public $p24_country;

    /**
     * Nazwa towaru 
     * @var string 
     */
    public $p24_name_X;

    /**
     * Dodatkowy opis towaru 
     * @var type 
     */
    public $p24_description_X;

    /**
     * Ilość sztuk towaru
     * @var int 
     */
    public $p24_quantity_X;

    /**
     * Cena jednostkowa towaru 
     * @var int
     */
    public $p24_price_X;

    /**
     * Opis pojawiający się w tytule przelewu
     * @var int
     */
    public $p24_transfer_label;

    /**
     * System kodowania
     * przesyłanych znaków:
     * ISO-8859-2, UTF-8,
     * Windows-1250
     * @var string 
     */
    public $p24_encoding;

    /**
     * Koszt dostawy/wysyłki/etc 
     * @var int
     */
    public $p24_shipping;

    /**
     *
     * @var int
     */
    public $p24_channel;

    /**
     * 0 - nie
     * 1 - tak 
     * @var int 
     */
    public $p24_wait_for_result;

    /**
     * Limit czasu na wykonanie
     * transakcji, 0 - brak limitu,
     * maks. 99(w minutach) 
     * @var int 
     */
    public $p24_time_limit;

    /**
     * Suma kontrolna wyliczanawg opisu poniżej. (patrz generateSigin())
     * @var type 
     */
    public $p24_sign;
    public $p24_amount;
    public $p24_email;

    /**
     * Adres do przekazania
     * statusu transakcji 
     * @var string
     */
    public $p24_url_status;

    /**
     * Adres powrotny po
     * zakończeniu transakcji 
     * @var string 
     */
    public $p24_url_return;
    public $p24_session_id;
    public $p24_order_id;

    /**
     * Lista metod płatności widoczna w panelu lub
     * dostępna przez API (patrz pkt. 5) 
     * @var int 
     */
    public $p24_method;

    /**
     * pl / en / de / es / it 
     * @var string
     */
    public $p24_language;
    public $p24_karta;
    protected $salt;
    protected $action;

    /**
     * dostępne kanały płatności
     * @var array 
     */
    protected $channels = [
        1 => 'karty',
        2 => 'przelewy',
        4 => 'przelew tradycyjny',
        8 => 'N/A',
        16 => 'wszystkie 24/7',
        32 => 'użyj przedpłatę'
    ];

    public function rules() {

        $verifyChannel = function($attr, $params) {

            if (!isset($this->channels[$this->p24_channel])) {

                $this->addError($attr, 'Nieprawidłowy kanał płatności');
            }
        };
        return [
            [['p24_session_id', 'p24_pos_id', 'p24_amount', 'p24_currency'], 'required'],
            [['p24_merchant_id', 'p24_pos_id', 'p24_price_X', 'p24_time_limit', 'p24_channel', 'p24_wait_for_result', 'p24_amount', 'p24_shipping', 'p24_quantity_X', 'p24_order_id', 'p24_karta', 'p24_method'], 'integer'],
            ['p24_channel', $verifyChannel],
            ['p24_api_version', 'string'],
            [['p24_language', 'p24_country'], 'string', 'max' => 2],
            ['p24_phone', 'string', 'max' => 12],
            ['p24_city', 'string', 'max' => 30],
            ['p24_email', 'string', 'max' => 50],
            ['p24_email', 'email'],
            ['p24_client', 'string', 'max' => 50],
            ['p24_transfer_label', 'string', 'max' => 20],
            [['p24_session_id', 'p24_sign'], 'string', 'max' => 100],
            [['p24_url_return', 'p24_url_status'], 'string', 'max' => 250],
            ['p24_zip', 'string', 'max' => 10],
            ['p24_currency', 'string', 'max' => 3],
            ['p24_address', 'string', 'max' => 80],
            ['p24_description', 'string', 'max' => 1024],
            [['p24_name_X', 'p24_description_X'], 'string', 'max' => 127],
            ['p24_encoding', 'string', 'max' => 15]
        ];
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setAction($action) {
        $this->action = $action . 'trnDirect';
    }

    public function getAction() {
        return $this->action;
    }

    public function getChannels() {
        return $this->channels;
    }

    public function createSigin() {

        $merchant_id = is_null($this->p24_order_id) ? $this->p24_pos_id : $this->p24_order_id;

        $this->p24_sign = md5($this->p24_session_id . '|'
                . $merchant_id . '|'
                . $this->p24_amount . '|'
                . $this->p24_currency . '|'
                . $this->salt);
    }

}
