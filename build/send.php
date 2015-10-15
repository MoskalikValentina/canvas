<?
require_once('lib/phpmailer/PHPMailerAutoload.php');
$mailer = new PHPMailer();

//$mailer->SMTPDebug = 3;

 //$mailer->From = 'zakaz@friday-bar.ru';
 $mailer->FromName = '';

//print_r($order_data);
include 'next_order.php';


//Message prepearing
$subject = "Новая заявка №" . $order_nbr . " (" . date("d.m.Y H:i") . ")";

 $message = 'Заявка от ' . date("d.m.Y H:i") . '<br><br>'.
 'Имя клиента: ' . $_POST['name'] . '<br>' .
 'Номер телефона: ' . $_POST['phone'] . "<br>".
 'E-mail: ' . $_POST['email'] . "<br>";
  if(isset($_POST['company'])) $message=$message.'<br>Компания: '.$_POST['company'];
  if(isset($_POST['title'])) $message=$message.'<br>Должность: '.$_POST['title'];
  if(isset($_POST['fax'])) $message=$message.'<br>Факс: '.$_POST['fax'];
  if(isset($_POST['comment'])) $message=$message.'<br>Комментарии и предложения по мероприятию: '.$_POST['comment'];
  if(isset($_POST['pay'])) $message=$message.'<br>Способ оплаты: '.$_POST['pay'];
$message=$message.'<br>Номер записи: ' . $order_nbr;

// Устанавливаем тему письма
$subject = iconv("UTF-8", "WINDOWS-1251", $subject);
$mailer->Subject = $subject;


// Задаем тело письма
$message = iconv("UTF-8", "WINDOWS-1251", $message);
$htmlBody = $message;



$mailer->Body = $htmlBody;
$mailer->isHTML(true);
$mailer->CharSet = "Windows-1251";


//Mails list prepearing
include 'emails.php';
$mails = $emails_list[$order_data->diler->name . ' ' . $order_data->diler->adress];

$mailer->AddAddress('silver22@xaker.ru');

 if ($mailer->send()){

 	//echo 'Почта отправлена';

 } else {

 	echo 'Ошибка отправки почты';

 }


echo '{ "order_number":"' . $order_nbr . '"}';

$order_nbr = $order_nbr + 1;

file_put_contents('next_order.php', '<?php $order_nbr=' . $order_nbr .'; ?>');

?>

