<?php

namespace daweb\przelewy24;

/**
 * http://www.przelewy24.pl/files/cms/2/przelewy24_specyfikacja_3_2.pdf
 *
 * @author Dawid Bednarz <dawid@daweb.vdl.pl>
 */
class P24ServiceException extends \Exception {
    
}

class P24Service extends \yii\base\Component {

    const API_VARSION = '3.2';

    public $testHost = 'https://sandbox.przelewy24.pl/';
    public $liveHost = 'https://secure.przelewy24.pl/';
    public $salt;
    public $sandboxSalt;
    public $clientID;
    public $currency;
    public $testMode;

    /**
     * real host
     * @var string
     */
    protected $host;

    /**
     * result of execute CallUrl method
     * @var array
     */
    public $result = [];

    /**
     * allowed ip p24 servers
     * @var array
     */
    static $ips = ['91.216.191.181', '91.216.191.185'];

    CONST TEST_CONNECTION = 'testConnection';
    CONST TRN_REGISTER = 'trnRegister';
    CONST TRN_REQUEST = 'trnRequest';
    CONST TRN_VERIFY = 'trnVerify';

    public function init() {

        if ($this->testMode) {
            $this->host = $this->testHost;
            $this->salt = $this->sandboxSalt;
        } else {
            $this->host = $this->liveHost;
        }

        parent::init();
    }

    /**
     * 
     * @return P24Form
     */
    public function getModelForm() {

        $form = new P24Form;

        $form->setAction($this->host);
        $form->setSalt($this->salt);

        $form->setAttributes([
            'p24_api_version' => self::API_VARSION,
            'p24_currency' => $this->currency,
            'p24_merchant_id' => $this->clientID,
            'p24_pos_id' => $this->clientID,
        ]);

        return $form;
    }

    /**
     * after return false by callUrl function 
     * @return string
     */
    public function getErrorMessage() {

        if (isset($this->result['errorMessage'])) {
            return $this->result['errorMessage'];
        }
        return serialize($this->result);
    }

    /**
     * 
     * Function is testing a connection with P24 server
     * @return boolean
     */
    public function testConnection() {

        return $this->callUrl(self::TEST_CONNECTION, [
                    'p24_pos_id' => $this->clientID,
                    'p24_sign' => md5($this->clientID . "|" . $this->salt)
        ]);
    }

    /**
     * 
     * Prepare a transaction request
     * @param bool $redirect Set true to redirect to Przelewy24 after transaction registration
     * @param P24Form $form
     * @return boolean
     */
    public function trnRegister($redirect = false, P24Form $form) {

        $form->createSigin();

        if (!$this->callUrl(self::TRN_REGISTER, ['p24_sign' => $form->p24_sigin]))
            return false;

        if ($redirect) {
            $this->trnRequest($this->result["token"]);
        }

        return true;
    }

    /**
     * Redirects or returns URL to a P24 payment screen
     * @param string $token Token
     * @param bool $redirect If set to true redirects to P24 payment screen. If set to false function returns URL to redirect to P24 payment screen
     * @return string URL to P24 payment screen
     */
    public function trnRequest($token, $redirect = true) {

        if ($redirect) {
            header("Location:" . $this->host . self::TRN_REQUEST . '/' . $token);
            return "";
        } else {
            return $this->host . self::TRN_REQUEST . '/' . $token;
        }
    }

    /**
     * Function verify received from P24 system transaction's result.
     * @param P24Form $form
     * @return boolean
     */
    public function trnVerify(P24Form $form) {

        $form->createSigin();

        return $this->callUrl(self::TRN_VERIFY, [
                    
                    'p24_merchant_id' => $form->p24_merchant_id,
                    'p24_pos_id' => $form->p24_pos_id,            
                    'p24_session_id' => $form->p24_session_id,
                    'p24_amount' => $form->p24_amount,
                    'p24_currency' => $form->p24_currency,
                    'p24_order_id' => $form->p24_order_id,
                    'p24_sign' => $form->p24_sign,
        ]);
    }

    /**
     * 
     * Function contect to P24 system
     * @param string $function Method name
     * @param array $ARG POST parameters
     * @return boolean
     */
    private function callUrl($function, $ARG) {

        if ($this->testMode && $function == self::TEST_CONNECTION) {

            return true;
        }
        $ch = curl_init();

        if (!$ch) {
            throw new P24ServiceException('Curl init error', 202);
        }

        if (count($ARG)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ARG));
        }

        curl_setopt($ch, CURLOPT_URL, $this->host . $function);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

        $result = curl_exec($ch);

        if (!$result) {
            curl_close($ch);
            throw new P24ServiceException('Curl exec error', 203);
        }

        $INFO = curl_getinfo($ch);

        curl_close($ch);

        if ($INFO["http_code"] !== 200) {
            throw new P24ServiceException('Page load error', $INFO["http_code"]);
        }

        $X = explode("&", $result);

        foreach ($X as $val) {

            $Y = explode("=", $val);
            $this->result[trim($Y[0])] = urldecode(trim($Y[1]));
        }

        if (isset($this->result["error"]) && $this->result["error"] == 0)
            return true;
        else
            return false;
    }

}
