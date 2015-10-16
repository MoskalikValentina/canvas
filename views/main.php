<!DOCTYPE html>
<html>
<head lang="ru">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../css/style.css?v=@version@"/>
    <link href="favicon.ico" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
<div class="wp">
<!-- Header -->
<header class="header">
    <div class="logo-left">
        <a href="http://www.audicenter.ru/suggestions/special/3891/"><span class="sel">Ауди</span>Центр Москва</a>
    </div>
    <div class="logo-right">
        <a href="/">
            <img src="../img/design/logo.png" alt="Ауди"/>
        </a>
    </div>
</header>
<!-- / Header -->
<!--Title section -->
<div class="ttl-section">
    <div class="add-phone callback">
        +7 (495) 797-90-90
    </div>
</div>
<!-- / Title section-->
<!-- Top block -->
<div class="top-blk">
    <div class="slider-blk">
        <img class="slider-blk-img" src="../img/design/top.jpg" alt=""/>
    </div>
</div>
<!-- / Top block -->
<!--Main blk -->
<div class="main-blk">
<!-- Tabs ttl -->
<div class="tabs-ttl">
    <ul class="tabs-list">
        <li class="tabs-list-item in-stock">
            <a class="tab-ttl" href="#in-stock">Автомобили в наличии</a>
        </li>
        <li class="tabs-list-item maps">
            <a class="tab-ttl" href="#maps">Где купить</a>
        </li>
    </ul>
</div>
<!-- / Tabs ttl -->
<!-- tab in stock-->
<div class="ac-ttl in-stock">
    <a class="tab-ttl" href="#in-stock">Автомобили в наличии</a>
</div>
<div class="tab active" id="in-stock">
<ul class="cars-list">
        <?
            /**
             * @param int $array_size Size of array counts
             * @return array with count from 1 to 4
             */
            function getCounts($array_size)
            {
                $count_file = '../car_count.php';
                $cur_date = date('d.m.y');
                $array_size = is_int($array_size) ? $array_size : 100;
                $count = array();
                if (file_exists($count_file)) {
                    include $count_file;
                }

                if (!isset($date) || $date !== $cur_date) {
                    $count_length = $array_size;
                    $count = array();
                    for ($i = 0; $i < $count_length; $i++) {
                        array_push($count, rand(1, 4));
                    }
                    file_put_contents($count_file, '<? $date="' . $cur_date . '"; $count=' . var_export($count, true) . ' ?>');
                }
                return $count;
            }
            $counts_size = count($products);
            $count = getCounts($counts_size);
        ?>
    <?php
    $counter = 0;
    function addSpace($value){
                    $price = str_replace(' ', '', $value);
                    $fprice = '';
                    $price_ln = strlen($price);
                    if($price_ln > 3){
                        for($i = $price_ln; $i >= 0; $i--){
                            $tmp = $i % 3 === 0 ? ' ' : '';
                            $fprice =$fprice . $tmp . substr($price, $price_ln - $i, 1);
                        }
                    } else {
                        $fprice = $price;
                    }
                    return $fprice;
                }
    foreach($products as $product): ?>
        <li class="car-blk">
            <div class="car-logo-blk">
                <div class="car-logo"> <img src="<?php echo $product['img'] ?>" alt=""/></div>
                <p class="car-special">от <span class="price-special"><?php
                echo addSpace($product['special']) ?> руб.</span></p>
            </div>
            <div class="car-info-blk">
                <p class="car-info-ttl"><?php echo $product['model'] ?></p>
                    <?php
                    // Addidional inforation list generation
                    if($product['add_info'] != '' && $product['add_info'] != null){
                        echo '<p class="list-ttl">Вас ждет сегодня:</p><ul class="list"><li>';
                        echo str_replace('|', '</li><li>', $product['add_info']);
                        echo '</li></ul>';
                    }
                    ?>
                <?php
                //Credit show off
                //<a href="#" class="credit">В кредит:<br> <p> <?php echo addSpace($product['credit']) ?> <?php // руб/мес*</p></a>
                ?>
            </div>
            <div class="offer-blk">
                <div class="offer-btn-blk">
                    <button class="brand-btn offer">Получить спецпредложение</button>
                     <?
                $car_count = $count[$counter++];
                if ($car_count == 1) {
                    ?> <p class="car-remain">остался всего <? echo $car_count; ?> автомобиль</p> <?
                } else{
                   ?> <p class="car-remain">осталось всего <? echo $car_count; ?> автомобиля</p> <?
                } ?>
                </div>
            </div>
        </li>
    <?php endforeach ?>
</ul>
</div>
<!-- / tab in stock -->
<!-- tab maps -->
<div class="ac-ttl maps">
    <a class="tab-ttl" href="#maps">Где купить</a>
</div>
<div class="tab hidden" id="maps">
    <div class="point-blk">
        <div class="map-blk" id="map-1"></div>
        <div class="point-info">
            <div class="adress">
                <p class="point-info-ttl">Адрес</p>

                <p class="point-info-txt">Москва,<br>Бережковская наб., д.38, стр.2 <br/>Тел.: +7 (495) 797-90-90</p>

                <p class="point-info-ttl">График работы:</p>

                <p class="point-info-txt">Ежедневно с 9:00 до 22:00</p>
            </div>
        </div>
    </div>
    <div class="point-blk">
        <div class="map-blk" id="map-2"></div>
        <div class="point-info">
            <div class="adress">
                <p class="point-info-ttl">Адрес</p>

                <p class="point-info-txt">Москва, <br/>Хорошевское ш., 70, корп. 1 <br/>Тел.: +7 (495) 797-90-90</p>

                <p class="point-info-ttl">График работы:</p>

                <p class="point-info-txt">Ежедневно с 9:00 до 22:00</p>
            </div>
        </div>
    </div>
</div>
<!-- / tab maps -->
</div>
<!--/ Main blk-->
<!-- footer -->
<footer class="footer">
    <div class="contact-blk">
        <?php // <p class="c-ttl">Ауди Центр Москва</p> ?>
        <p class="c-phone">+7 (495) 797-90-90</p>
    </div>
    <div class="f-info-blk">
        <p class="f-info-txt">Обращаем Ваше внимание на то, что данный интернет-сайт носит исключительно информационный
            характер и ни при каких условиях предложения, размещенные на нем, не являются публичной офертой,
            определяемой положениями действующего гражданского законодательства Российской Федерации. Для получения
            подробной информации о комплектации и стоимости автомобилей и др., пожалуйста, обращайтесь к менеджерам по
            продажам официального дилера Audi компании - Ауди Центр Москва.</p>
        <div class="footer__hide hide">
            <p>* Продавец оставляет за собой право предоставления скидки на новые автомобили Audi A1, A3, А3 седан, A4, Q3, Q5 в размере затрат клиента на покупку полиса КАСКО сроком на 12 месяцев для водителей от 25 лет и старше со стажем вождения от 2 лет и более. Предложение ограничено. Услуги страхования предоставляются компанией ОАО «Альфа Страхование» (Лицензия ФССН С №223977, http://www.alfastrah.ru), ООО «Группа Ренессанс Страхование» (Лицензия ФССН С №128477, http://www.renins.com), ООО «Росгосстрах» (Лицензия ФССН С №097750, http://www.rgs.ru).Тарифы и условия могут быть изменены без предварительного уведомления. Возможность предоставления услуги страхования, тарифы, условия и ограничения, а также сроки действия необходимо уточнять у дилера. Подробная информация по тел. 8-800-700-75-57.Ауди Страхование  </p>
            <p>** Денежный эквивалент премии лояльности не выдается. Получить вознаграждение за преданность марке могут клиенты, воспользовавшиеся услугой трейд-ин при приобретении нового автомобиля Audi в Ауди Центре Москва. </p>
            <p>***Основные условия кредитования ООО «Фольксваген Банк РУС» (далее Банк) в рамках специальной акции «AudiCredit* 5,9%» для приобретения нового автомобиля AudiA4: валюта кредита – рубли РФ; сумма кредита от 120 тыс. до 4 млн. рублей, первоначальный взнос – от 40% от стоимости автомобиля и страховой премии, в случае их включения в сумму кредита. Процентная ставка при предоставлении полного пакета документов составит: при сроке 12 месяцев – 5,9% годовых. Основные условия кредитования ООО «Фольксваген Банк РУС» (далее Банк) в рамках специальной акции «AudiA3, A4, A5, Q3» для приобретения нового автомобиля AudiA4: валюта кредита – рубли РФ; сумма кредита от 120 тыс. до 4 млн. рублей, первоначальный взнос – от 40% от стоимости автомобиля и страховой премии, в случае их включения в сумму кредита. Процентная ставка при предоставлении полного пакета документов составит: при сроке от 13 до 36 месяцев 10,0% годовых. Процентная ставка при предоставлении двух документов составит: при сроке от 12 до 36 месяцев - 21,5% годовых. Обеспечение по кредиту – залог приобретаемого автомобиля. Срок действия акции с 01.04.2015 г. по 30.06.2015 г. Подробности по телефону: 8-800-700-75-57, лицензия ЦБ РФ № 3500, 117485, г. Москва, ул. Обручева, д.30/1, стр.1. www.vwbank.ru. </p>
            <p>**** Основные условия кредитования ООО «Фольксваген Банк РУС» (далее – «Банк»)  в рамках специального предложения «Кредит на приобретение нового автомобиля Audi» на приобретение нового автомобиля Audi: валюта кредита – рубли РФ; сумма кредита от 120 тыс. до 4 млн. рублей при предоставлении полного комплекта документов и до 1,2 млн. рублей при предоставлении двух документов. Минимальный первоначальный взнос (далее – «ПВ») – 15% от стоимости автомобиля и страховых премий, в случае их включения в сумму кредита. Процентная ставка при предоставлении полного пакета документов составит: при сроке 12 месяцев – 20,0% годовых при ПВ от 15% до 40%, 19,0% годовых при ПВ от 40% (включительно) при сроке от 13 до 36 месяцев – 22,0% годовых при ПВ от 15% до 40%, 21,0% годовых при ПВ от 40% (включительно), при сроке от 37 до 60 месяцев – 22,0% годовых при ПВ от 15%. Процентная ставка при предоставлении двух документов составит: при сроке от 12 до 60 месяцев – 23,0% годовых. Обеспечение по кредиту – залог приобретаемого автомобиля. Часть кредита может быть направлена на оплату страхования КАСКО и/или иных программ страхования, сумма страховой премии по которым зависит от перечня страхуемых рисков, выбранной Клиентом программы и суммы кредита. <br>
                Условия предоставления кредита действительны на 01.04.2015 г. и могут быть изменены Банком. Информация по телефону Банка: 8-800-700-75-57 (звонок по России бесплатный). Лицензия ЦБ РФ № 3500, 117485, г. Москва, ул. Обручева, д.30/1, стр.1. www.vwbank.ru </p>
            <p>***** Основные условия кредитования ООО «Фольксваген Банк РУС» (далее Банк) в рамках специальной акции «AudiA3, A4, A5, Q3» для приобретения нового автомобиля AudiA3, A5, Q3: валюта кредита – рубли РФ; сумма кредита от 120 тыс. до 4 млн. рублей, первоначальный взнос – от 40% от стоимости автомобиля и страховой премии, в случае их включения в сумму кредита. Процентная ставка при предоставлении полного пакета документов составит: при сроке от 13 до 24 месяцев 13,0% годовых, при сроке от 25 до 36 месяцев 14,0% годовых. Процентная ставка при предоставлении двух документов составит: при сроке от 12 до 36 месяцев - 21,5% годовых. Обеспечение по кредиту – залог приобретаемого автомобиля.
                Срок действия акции с 01.04.2015 г. по 30.06.2015 г. Подробности по телефону: 8-800-700-75-57, лицензия ЦБ РФ № 3500, 117485, г. Москва, ул. Обручева, д.30/1, стр.1. www.vwbank.ru. </p>
        </div>
        <a href="#" class="footer__toggle">Читать дальше</a>
    </div>
    <a class="fb" href="https://www.facebook.com/audicenter"></a>
</footer>
<div class="brdr">
    <div class="brdr-1"></div>
    <div class="brdr-2"></div>
</div>
<!-- / footer -->
<!-- Modals -->
<div class="modals hidden">
    <div class="callback-modal req-modal">
        <div class="req-blk">
            <p class="req-ttl">Заказ обратного звонка</p>
            <form class="req-form" action="/" method="post">
                <input type="hidden" name="send" value="1">
                <input type="hidden" name="form_type" value="Запрос обратного звонка">
                <input type="hidden" name="brand_info" value="Audi">
                <p class="inp-blk">
                    <label class="inp-lbl lbl-name"></label>
                    <input type="text" name="name" class="req-inp inp-name" placeholder="Имя" required=""/>
                </p>
                <p class="inp-blk">
                    <label class="inp-lbl lbl-phone"></label>
                    <input type="tel" name="phone" class="req-inp inp-phone" placeholder="Номер телефона" required=""/>
                </p>
                <p class="inp-blk">
                    <button class="brand-btn">Отправить заявку</button>
                </p>
            </form>
        </div>
    </div>
    <div class="offer-modal req-modal">
        <div class="req-blk">
            <p class="req-ttl">Позвоните по телефону<br>+7(495) 797-90-90<br>или заполните форму ниже</p>
            <form class="req-form" action="/" method="post">
                <input type="hidden" name="send" value="1">
                <input type="hidden" name="form_type" value="Запрос спецпредложения">
                <input type="hidden" name="brand_info" value="Audi">
                <input type="hidden" name="car_info" value="">
                <input type="hidden" name="car_remain" value="">
                <input type="hidden" name="car_special" value="">
                <p class="inp-blk">
                    <label class="inp-lbl lbl-name"></label>
                    <input type="text" name="name" class="req-inp inp-name" placeholder="Имя" required=""/>
                </p>
                <p class="inp-blk">
                    <label class="inp-lbl lbl-phone"></label>
                    <input type="tel" name="phone" class="req-inp inp-phone" placeholder="Номер телефона" required=""/>
                </p>
                <p class="inp-blk">
                    <label class="inp-lbl lbl-email"> </label>
                    <input type="email" name="email" class="req-inp inp-email" placeholder="Электронная почта"/>
                </p>
                <p class="inp-blk">
                    <button class="brand-btn">Получить спецпредложение</button>
                </p>
            </form>
        </div>
    </div>
    <div class="thanks req-modal">
        <div class="req-blk">
            <p class="req-ttl">Заявка отправлена</p>
            <p>Ваша заявка успешна отправлена менеджеру.<br> Cовсем скоро мы Вам позвоним и уточним детали</p>
        </div>
    </div>
</div>
<!--END Modals -->
</div>
<script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="../js/script.js?v=@version@"></script>

<!-- Counters -->
<?php
    if($config->counters() && file_exists(BASEDIR . 'views/counters.php')){
        include BASEDIR . 'views/counters.php';
    }
?>
<!-- / Counters -->

</body>
</html>