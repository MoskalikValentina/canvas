<?php

$message = '<h4>Заявка от ' . date("d.m.Y H:i") . '</h4>';

$message .= isset($this->request_data['name']) ? 'Имя клиента: ' . $this->request_data['name'] . '<br>' : '';
$message .= isset($this->request_data['phone']) ? 'Номер телефона: ' . $this->request_data['phone'] . '<br>' : '';
$message .= isset($this->request_data['email']) ? 'Электронная почта: <a href="' . $this->request_data['email'] . '">' . $this->request_data['email'] . '</a><br>': '';
$message .= isset($this->request_data['comment']) ? 'Комментарий: ' . $this->request_data['comment'] . '<br>' : '';

$message .= '<br><i>Дополнительная информация</i><br>';

$message .= isset($this->request_data['form_type']) ? 'Тип заявки: ' . $this->request_data['form_type'] . '<br>' : '';
$message .= isset($this->request_data['car_info']) || isset($_POST['brand_info']) ? '<span style="color:red;">Интересует авто:</span> ' . $_POST['brand_info'] . ' ' . $_POST['car_info'] . '<br>' : '';
