<?php
/**
 * Use for work with request
 */

//todo Make Parent class Controller with typical function and params

class RequestController {
    private $config;
    private $req;

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
//
//        if($this->config->siebel()){
//            $this->send_to_siebel();
//        }
    }

    /**
     * Send request by email
     */
    private function send_by_email(){
        require_once BASEDIR . 'sm/core/mailing/Mailer.class.php';
        $mailer = new Mailer();
        $mailer->init($this->config->email_conf());

        $subject = $this->req->get_subject();
        $body = $this->req->get_mail();
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
        $res = $db_tbl->write($clear_request);
        if(!$res){
            echo 'Error write to DB';
        }
    }

}