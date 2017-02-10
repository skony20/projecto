
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2016-12-27, 12:11:22
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
use yii\helpers\Html;

$this->title = 'Zwroty';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-returns">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="return-button text-center"><?= Html::a('Formularz zwrotu', Yii::$app->request->BaseUrl.'/img/formularz_zwrotu.pdf') ?></div>
    <p>
        Każdy konsument ma możliwość zwrotu, w związku z odstąpieniem od umowy bez podania przyczyny, towaru zakupionego w sklepie internetowym ProjektTop.pl nawet wtedy, gdy towar jest zgodny z zamówieniem. W celu uzyskania możliwości zwrotu towaru wystarczy w ciągu 14 dni od jego otrzymania poinformować sklep ProjektTop.pl o odstąpieniu od umowy.
    </p>
    <p>
        14 dniowy okres w którym konsument może odstąpić od umowy rozpoczyna się w chwili otrzymania towaru przez kupującego lub osobę przez niego wskazaną.
    </p>
    
    <span class="static-title">Co oznacza "odstąpienie od umowy"?</span><br>
    <p>
        W przypadku odstąpienia od umowy umowę uważa się za niezawartą. Jeśli konsument odstąpił od umowy, powinien w ciagu 14 dni zwrócić towar do sklepu. Sklep z kolei ma obowiązek niezwłocznie, nie później niż w terminie 14 dni od dnia otrzymania oświadczenia konsumenta o odstąpieniu od umowy, zwrócić konsumentowi wszystkie dokonane przez niego płatności, w tym koszty dostarczenia rzeczy do konsumenta.* Sklep może wstrzymać się ze zwrotem płatności otrzymanych od konsumenta do chwili otrzymania rzeczy z powrotem lub dostarczenia przez konsumenta dowodu jej odesłania, w zależności od tego, które zdarzenie nastąpi wcześniej.
    </p>
    <p>
        *UWAGA: Koszt związany bezpośrednio ze zwrotem towaru - czyli koszt dostarczenia zwracanego towaru do sklepu - ponosi konsument.
    </p>
    <p>
        *UWAGA 2: Możesz oczywiście odpakować zamówiony towar i sprawdzić jego cechy użytkowe jednak pamiętaj, że konsument ponosi odpowiedzialność za zmniejszenie wartości rzeczy będące wynikiem korzystania z niej w sposób wykraczający poza konieczny do stwierdzenia charakteru, cech i funkcjonowania. Jeśli wartość zwracanego towaru została zmniejszona w wyniku np. zużycia będziemy musieli pomniejszyć zwracaną sumę proporcjonalnie do spadku wartości towaru.
    </p>
    <p>
        *UWAGA 3: Sklep ma obowiązek zwrócić koszt dostarczenia towaru do konsumenta tylko do wysokości wyznaczonej przez najtańszy sposób dostarczenia dostępny w sklepie dla danego towaru.
    </p>
    
    <span class="static-title">Procedura zwrotu</span><br>
    <p>
        <ol class="return-list">
            <li>Poinformuj nas o chęci zwrotu towaru odstąp od umowy.<br>

                Aby poinformować nas o swojej decyzji (skutecznie odstąpić od umowy), prześlij do nas deklarację odstąpienia od umowy. Pamiętaj o uwzględnieniu informacji, która pozwoli nam zidentyfikować twoje zamówienie.<br>
                Zalecamy korzystanie z <?= Html::a('formularza', Yii::$app->request->BaseUrl.'/img/formularz_zwrotu.pdf') ?>, wydrukowany i wypełniony możesz przesłać do nas pocztą lub przesłać jego treść w wiadomości e-mail.
            </li>
            <li>Otrzymasz od nas potwierdzenie otrzymania oświadczenia o odstąpieniu od umowy.</li>

            <li>Dobrze spakuj towar, który chcesz zwrócić. Ważne aby dobrze zabezpieczyć przesyłkę na czas transportu.</li>

            <li>Pamiętaj aby dołączyć do paczki swoje dane adresowe, tak byśmy mogli się z Tobą skontaktować. Możesz też dołączyć do niej wypełniony Formularz zwrotu.</li>

            <li>Wyślij paczkę na adres naszej firmy: (<strong>ProjektTop.pl Wici 48/49 91-157 Łódź</strong>). Towar powinien być odesłany niezwłocznie, w terminie nie dłuższym niż 14 dni od odstąpienia od umowy.</li>
        </ol>
    </p>
    <p>
        UWAGA: Towar odsyłasz do sklepu na własny koszt i odpowiedzialność. Pamiętaj by wybrać odpowiednią formę wysyłki (sugerujemy korzystanie z przesyłek kurierskich) i dobrze zabezpieczyć ją na czas transportu.</p>
    
    <span class="static-title">Jak przyspieszyć procedurę zwrotu?</span><br>
    <p>
        Procedura zwrotu będzie przebiegać szybciej jeśli skorzystasz z poniższych porad:<br><br>
    <ul>
        <li>Aby nas poinformować o odstąpieniu od umowy korzystaj z formularza zwrotu.</li>
        <li>W miarę możliwości zwróć produkt w oryginalnym opakowaniu.</li>
        <li>Do przesyłki dołącz wydruk formularza zwrotu i dowód zakupu.</li>
        <li>Dobrze zabezpiecz towar na czas transportu.</li>
        <li>Aby odesłać towar korzystaj z usług firmy kurierskiej.</li>
    </ul>
    </p>
    
    <span class="static-title">Zwrot pieniędzy</span>
    <p>
        Pieniądze zwracamy w terminie nie przekraczającym 7 dni roboczych.<br>
        Jeśli towar został nabyty przez przedsiębiorcę w celu związanym z prowadzoną przez niego działalnością gospodarczą, pieniądze zwracamy po otrzymaniu od przedsiębiorcy podpisanej faktury korygującej.
    </p>
    
    <span class="static-title">PODSTAWA PRAWNA:</span><br>
    <p>
     Ustawa z dnia 30 maja 2014 o prawach konsumenta (Dz.U. z 2014 r. poz. 827)
    </p>
    <div class="return-button text-center"><?= Html::a('Formularz zwrotu', Yii::$app->request->BaseUrl.'/img/formularz_zwrotu.pdf') ?></div>
</div>
