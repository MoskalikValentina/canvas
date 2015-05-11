<?php
/**
 * Request object
 */
header("Content-type: text/html; charset=utf-8");
class Request {
    private $request_data = array();
    private $request_structure = array();

    /**
     * Construct request object
     * @param array $req_data associative with request data
     * @param array $req_structure associative with request structure from config
     */
    public function __construct(Array $req_data, Array $req_structure){
        $this->request_structure = $req_structure;
        //Load only data which in structure only
        foreach($this->request_structure as $key => $val){
            $this->request_data[$key] = isset($req_data[$key]) ? $req_data[$key] : '';
        }
    }

    /*
     * Return data as array or as string
     * @param $data_name String Name of data param for return. Use optional
     * return Array with all data or string with field
     */
    public function get_data($data_name = ''){
        if($data_name !== ''){
            $res = $this->request_data[$data_name];
        } else {
            $res = $this->request_data;
        }
        return $res;
    }

    /*
     * Return subject for email sending
     */

    public function get_subject(){
        return "Новая заявка (" . date("d.m.Y H:i") . ")";
    }

    /*
     * Return prepared for send mail html body
     */
    public function get_mail(){
        $message = '<h4>Заявка от ' . date("d.m.Y H:i") . '</h4>'.
            'Имя клиента: ' . $_POST["name"] . '<br>' .
            'Номер телефона: ' . $_POST["phone"] . "<br>";

        if(isset($_POST['name']) && $_POST['name']){
            $customer_name = $_POST['name'];
        }

        if(isset($_POST['phone']) && $_POST['phone']){
            $phone = $_POST['phone'];
        }

        if(isset($_POST['email']) && $_POST['email'] !=''){
            $message = $message . 'Электронная почта: <a href="' . $_POST['email'] . '">' . $_POST['email'] . '</a><br>';
            $email = $_POST['email'];
        }

        $message = $message . '<br><i>Дополнительная информация</i><br>';

        if(isset($_POST['form_type']) && $_POST['form_type'] !=''){
            $message = $message . 'Тип заявки: ' . $_POST['form_type'] . '<br>';
            $form_type = $_POST['form_type'];
        }

        if(isset($_POST['text']) && $_POST['text'] != ''){
            $message = $message . 'Комментарий: ' . $_POST['text'];
            $salon_color =  $_POST['text'];
        }

       

        if( $form_type=='Корзина'){
        if ($_POST['payment'] == false) {
            if(isset($_POST['payment']) && $_POST['payment'] != ''){
                $message = $message . '<br> Оплата: ' . $_POST['payment'];
                $salon_color =  $_POST['payment'];
            }

            if(isset($_POST['delivery']) && $_POST['delivery'] != ''){
                $message = $message . '<br> Доставка: ' . $_POST['delivery'];
                $salon_color =  $_POST['delivery'];
            }

            if(isset($_POST['city']) && $_POST['city'] != ''){
                $message = $message . '<br> Город: ' . $_POST['city'];
                $salon_color =  $_POST['city'];
            }

            if(isset($_POST['number']) && $_POST['number'] != ''){
                $message = $message . '<br> Номер отделения: ' . $_POST['number'];
                $salon_color =  $_POST['number'];
            }

            if(isset($_POST['adress']) && $_POST['adress'] != ''){
                $message = $message . '<br> Адрес: ' . $_POST['adress'];
                $salon_color =  $_POST['adress'];
            }
        } else {
             $message = $message . 'Тип заказа: Быстрый ' . $_POST['adress'];
        }

            $message=$message.'<br><b>Заказ</b><br><table width=50% border=1><th>Артикул</th><th>Название</th><th>Цвет</th><th>Цена</th><th>Кол-во</th><th>Сумма</th>';
            $test=($_POST['order']);
            $order=json_decode($test, true);
            $summ=0;
            foreach ($order as $value) {   
                    $message=$message.'<tr>';
                    $message=$message.'<td>'.$value['article'].'</td>';  
                    $message=$message.'<td>'.$value['title'].'</td>';
                    $message=$message.'<td>'.$value['color'].'</td>';
                    $message=$message.'<td>'.$value['price'].'</td>';  
                    $message=$message.'<td>'.$value['amount'].'</td>';
                    $message=$message.'<td>'.$value['amount']*$value['price'].'</td>';   
                    $message=$message.'</tr>';
                    $summ=$summ+$value['amount']*$value['price'];
            };
            $message=$message.'</table><br><b>Итого: </b>'.$summ;

        }

        return $message;
    }
}