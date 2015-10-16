<?php
/**
 * Use for work with request
 */

//todo Make Parent class Controller with typical function and params

class RequestController {
    private $config;
    private $req;
    private $req_id;

    public function __construct(Config $config){
        require_once BASEDIR . 'sm/core/Request.class.php';
        $this->config = $config;
    }

    /**
     * Request processing
     * @param $req_array Array with crude request data
     */
    public function req_process(Array $req_array){
        $req_structure = $this->config->req_structure();
        $this->req = new Request($req_array, $req_structure); //todo add crude data validate

        //Send by mail if it`s 'on' in config
        if($this->config->mailing()){
            $this->send_by_email();
        }

        //Save request to DB if it`s 'on' in config
        if($this->config->req_to_db()){
            $this->save_to_db();
        }

        //Send to Siebel
        if($this->config->siebel()){
            $this->sendToSiebel();
        }

        //ROI.RS integrarion (crude)
        //$this->sendToROIRS();
    }

    /**
     * Send request by email
     */
    private function send_by_email(){
        require_once BASEDIR . 'sm/core/mailing/Mailer.class.php';
        $mailer = new Mailer();
        $mailer->init(BASEDIR . $this->config->email_conf());

        $subject = $this->req->get_subject();
        $body = $this->req->get_mail($this->config->mail_template(),  $this->config->mail_template_path());
        $mailer->send_email($subject, $body); //Add subject & body
    }

    /**
     * Save request to DB
     */
    private function save_to_db(){
        require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
        require_once BASEDIR . 'sm/core/db/DBTbl.class.php';

        //Make connection
        $db_connection = DBConnect::withConfig($this->config);

        //Prepare table
        $tbl_name = $this->config->req_tbl_name();
        $tbl_structure = $this->config->req_structure();
        $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);

        //Save to DB
        $clear_request = $this->req->get_data();
        $res_id = $db_tbl->write($clear_request);
        if(!$res_id){
            echo 'Error write to DB';
        } else {
            $this->req_id = $res_id;
        }
    }

    /**
     * Send to Siebel
     */
    private function sendToSiebel(){
        if(isset($this->req_id) &&  $this->req_id !== '') {
            require_once BASEDIR . 'sm/extends/SiebelIntegration/SiebelConnector.php';
            $siebel_url = $this->config->siebelURL();
            $request_data = $this->req->get_data();

            $siebel_data = array(
                'id' => $this->req_id,
                'integration_id' => 'sale_audi_yugozapad_ru',
                'first_name' => $request_data['name'],
                'last_name' => '',
                'phone' => $request_data['phone'],
                'email' => $request_data['email'],
                'comment' => '',
                'brand' => $request_data['brand_info'],
                'model' => $request_data['car_info']
            );

            if (isset($request_data['credit'])) {
                $siebel_data['credit'] = 'Y';
            }

            if (isset($request_data['test-drive'])) {
                $siebel_data['test_drive'] = 'Y';
            }

            $integration_id = 'IGC_AUDI_MSK_ACSW';
            $instance = 'AUDI';
            $region_integration_id = 'IGC_AUDI_MSK';
            $trend_integration_id = 'IGC_AUDI';

            $siebel_connector = new SiebelConnector($siebel_url, $siebel_data, $integration_id, $instance,
                $region_integration_id, $trend_integration_id);
            $siebel_client_id = $siebel_connector->customerDataSend();
            $siebel_request_id = $siebel_connector->requestDataSend();

            echo 'siebel_client_id = ' . $siebel_client_id . '<br> siebel_request_id = ' . $siebel_request_id; //debug
        }
    }

     /**
     * Send data to ROI.RS
     */
    private function sendToROIRS(){
        require_once BASEDIR . 'sm/extends/ROIRSSender.class.php';
        $token = 'LuvBmKwO3onZ40C3_A';
        if(isset($_COOKIE['sbjs_current']))
        {
            $sbjs_current = $_COOKIE['sbjs_current'];
        }
        $config = '15';
        $params = $this->req->get_data();
        $roi_rs = new ROIRSSender();
        $roi_rs->init($config, $token, $sbjs_current, $params);
        $roi_rs->send();
    }
}