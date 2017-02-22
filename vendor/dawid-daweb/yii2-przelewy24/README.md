# yii2-przelewy24
yii2 support for przelewy24 https://www.przelewy24.pl/

Install
=====================
~~~ go
„require”: {

   "dawid-daweb/yii2-przelewy24" : "dev-master"
}
~~~
Add to config section components:
~~~ go
    'components' => [
        'P24Service' => [
            'class' => 'daweb\przelewy24\P24Service',
            'clientID' => 11111, 
            'sandboxSalt' => '1c323rewr24',  
            'salt' => '7aa35rg456hb4d6',
            'currency' => 'PLN',
            'testMode' => true // enable sandbox mode
        ],
    ]
~~~

Example
=====================
Prepare form
~~~ go
        $p24Service = \Yii::$app->P24Service;

        $p24Form = $p24Service->getModelForm();

        $p24Form->setAttributes([
            'p24_amount' => 5000,
            'p24_description' => 'Zapłata za subskrypcje',
            'p24_session_id' => '234234fsf8384h45ht84t8g',
            'p24_email' => 'example@email.com',
            'p24_url_status' => Url::to(['payment/update-status'], true),
            'p24_url_return' => Url::to(['site/index'], true)
            // if you need you can put other input
        ]);

        if ($p24Form->validate() && $p24Service->testConnection()) {

            $p24Form->createSigin(); // create and add to p24_sign input
        }

        return $this->renderPartial('payment_form', [
                    'p24Form' => $p24Form
                    ]);
~~~
In view
~~~ go
  <form action="<?= $p24Form->getAction() ?>" method="POST">
  
                <?php foreach ($p24Form->getAttributes() as $name => $value): ?>
                    <?= Html::hiddenInput($name, $value); ?>
                <?php endforeach; ?>
                
            <?= Html::submitButton('PRZEJDŹ DO PŁATNOŚCI') ?>
  </form>
~~~
Verify feedback from przelewy24 
~~~ go
class PaymentController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    function actionUpdateStatus() {

        $p24Service = Yii::$app->P24Service;

        $p24Form = $p24Service->getModelForm();

        $p24Form->setAttributes(Yii::$app->request->post());

        if (!$p24Form->validate()) {

            Yii::error('Błędne parametry płatności ' . serialize($p24Form->getErrors()));
            Yii::$app->end();
        }

        // verify payment

        if ($p24Service->trnVerify($p24Form)) { // response is available in $p24Service->result

            //success
            Yii::$app->end();
        }
        //update your payment with error message $p24Service->getErrorMessage();
        Yii::error($p24Service->getErrorMessage());
        Yii::$app->end();
    }

}
~~~
Require
=====================
PHP >= 5.4
yii2
