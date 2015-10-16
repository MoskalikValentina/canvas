<?php

class ROIRSSender {

    protected $url = 'https://umarker.roi.rs/';
    protected $config;
    protected $token;
    protected $sbjs_current;
    protected $form ='';
    protected $phone = '';
    protected $email = '';
    protected $special = '';
    protected $brand = '';
    protected $model = '';
    protected $name = '';

    protected $uid = '';
    protected $callback = '';

    public function init($config, $token, $sbjs_current, Array $params = array())
    {
        if(is_int((int)$config)) {
            $this->config = $config;
        } else {
            return false;
        }

        $this->token = $token;
        $this->sbjs_current = $sbjs_current;

        if(count($params) > 0){
            if(isset($params['form_type']))
                $this->form = $params['form_type'];

            if(isset($params['name']))
                $this->name = $params['name'];

            if(isset($params['phone']))
                $this->phone = $params['phone'];

            if(isset($params['email']))
                $this->email = $params['email'];

            if(isset($params['brand_info']))
                $this->brand = $params['brand_info'];

            if(isset($params['car_info']))
                $this->model = $params['car_info'];

            if(isset($params['spacial']))
                $this->special = $params['special'];

            if(isset($params['uid']))
                $this->uid = $params['uid'];

            if(isset($params['callback']))
                $this->callback = $params['callback'];
        }
    }


    public function send()
    {
        if($this->url !== '' && $this->token !== '' && $this->sbjs_current !== ''){
            $this->sendRequest();
        } else {
            return false;
        }
    }

    protected function sendRequest(){
        $params = '?config=' . $this->config . '&token=' . $this->token . '&sbjs_current==' . $this->sbjs_current;

        if($this->form !== '')
            $params .= '&form=' . urlencode($this->form);

        if($this->phone !== '')
            $params .= '&phone=' . urlencode($this->phone);

        if($this->email !== '')
            $params .= '&email=' . urlencode($this->email);

        if($this->brand !== '')
            $params .= '&brand=' . urlencode($this->brand);

        if($this->model !== '')
            $params .= '&model=' . urlencode($this->model);

        if($this->special !== '')
            $params .= '&special=' . urlencode($this->special);

        if($this->uid !== '')
            $params .= '&uid=' . urlencode($this->uid);

        if($this->callback !== '')
            $params .= '&callback=' . urlencode($this->callback);

        $url_with_get_fields = $this->url . $params;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url_with_get_fields);
        //curl_setopt($ch, CURLOPT_HEADER, true); //debug
        curl_setopt($ch, CURLOPT_REFERER, $this->url);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //debug
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $data = curl_exec($ch);
        if($data === false){
            //echo 'Curl: error' . curl_error($ch); //debug
        } else {
            //file_put_contents('response.txt', $data); //debug
        }
        //var_dump($data); //debug
        curl_close($ch);
    }
}