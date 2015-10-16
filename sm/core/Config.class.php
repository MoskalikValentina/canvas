<?php
/**
 * Use for work with config file
 */

//todo Change functions on getters methods
//todo add config load check when functions use

class Config {
    private $crude_conf;

    /**
     * Load config file
     * @param String $conf_file_path
     * @return true or String with error
     */
    public function load_conf($conf_file_path){
        if(is_string($conf_file_path) && file_exists($conf_file_path)){
            $config = include $conf_file_path; // todo add config file test

            $this->crude_conf = $config;
            $st = true;
        } else {
            $st = 'Error: File not exist';
        }
        return $st;
    }

    /**
     * Test option state
     * @param String $opt_name - name of testing option in config file
     * @return Bool
     */
    private function is_on($opt_name){
        if(isset($this->crude_conf[$opt_name])) {
            $state = $this->crude_conf[$opt_name];
            if ($state === 'on') {
                $st = true;

            } else {
                $st = false;
            }
        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * @return Bool with mail config state
     */
    public function mailing(){
        return $this->is_on('send_on_email');
    }

    /**
     * @return Bool Is on mail template
     */
    public function mail_template(){
        return $this->is_on('mail_template');
    }

    /**
     * @return string Mail template path
     */
    public function mail_template_path(){
        return $this->crude_conf['mail_template_path'];
    }

    /**
     * Return path to email config
     */
    public function email_conf(){
        return $this->crude_conf['send_email_config'];
    }

    /**
    * Return bool with request saving state
    */
    public function req_to_db(){
        $db_state = $this->is_on('db');
        $req_to_db_state = $this->is_on('save_req_to_db');
        if($db_state &&  $req_to_db_state){
            $st = true;

        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * Return array with DB connection data
     */
    public function get_db_data(){
        return $this->crude_conf['db_config'];
    }

    /**
     * Return request table name
     */
    public function req_tbl_name(){
        return $this->crude_conf['request_config']['db_table'];
    }

    /**
     * Return request structure
     */
    public function req_structure(){
        return $this->crude_conf['request_config']['req_fields'];
    }

    /**
     * Return export path
     */
    public function exp_path(){
        return $this->crude_conf['export_path'];
    }

    /**
     * Return request export state
     */
    public function req_export(){
        $db_state = $this->is_on('db');
        $req_export_state = $this->is_on('req_export');
        if($req_export_state &&  $db_state){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * Return request exp filename
     */
    public function req_exp_file_name(){
        return $this->crude_conf['req_export_file_name'];
    }

    /**
     * Return state of product store in DB
     */
    public function prodInDB(){
        $db_state = $this->is_on('db');
        $prod_in_db_state = $this->is_on('prod_in_db');
        if($prod_in_db_state &&  $db_state){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }


    /**
     * Return product table name
     */
    public function prod_tbl_name(){
        return $this->crude_conf['product_config']['db_table'];
    }

    /**
     * Return product structure
     */
    public function prod_structure(){
        return $this->crude_conf['product_config']['prod_fields'];
    }

    /**
     * Return product export state
     */
    public function prod_export(){
        $db_state = $this->is_on('db');
        $prod_export_state = $this->is_on('prod_export');
        if($prod_export_state &&  $db_state ){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * Return product exp filename
     */
    public function prod_exp_file_name()
    {
        return $this->crude_conf['prod_export_file_name'];
    }

    /**
     * Return product images exp filename
     */
    public function prod_img_exp_file_name()
    {
        return $this->crude_conf['prod_img_export_file_name'];
    }

    /**
     * Return product images export state
     */
    public function prodImgExport(){
        $db_state = $this->is_on('db');
        $prod_img_export_state = $this->is_on('prod_img_export');
        if($prod_img_export_state &&  $db_state ){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }


    /**
     * Return product import state
     */
    public function prod_update(){
        $db_state = $this->is_on('db');
        $prod_update_state = $this->is_on('prod_update');
        if($prod_update_state &&  $db_state){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * Return product images import state
     */
    public function prodImgUpdate(){
        $db_state = $this->is_on('db');
        $prod_img_update_state = $this->is_on('prod_img_update');
        if($prod_img_update_state &&  $db_state){
            $st = true;
        } else {
            $st = false;
        }
        return $st;
    }

    /**
     * Return product import path
     */
    public function import_path(){
        return $this->crude_conf['import_path'];
    }

    /**
     * Return product images path
     */
    public function prod_img_path(){
        return $this->crude_conf['product_img_path'];
    }

    /**
     * Return users tbl name
     */
    public function users_tbl_name(){
        return $this->crude_conf['users_config']['db_table'];
    }

    /**
     * Return users tbl structure
     */
    public function users_tbl_structure(){
        return $this->crude_conf['users_config']['users_fields'];
    }

    /**
     * Return enable admin panel state
     */
    public function admin_panel(){
        return $this->is_on('admin_panel');
    }


    /**
     * Return Siebel integration state
     */
    public function siebel(){
        return $this->is_on('siebel');
    }

    /**
     * Return URL for Siebel
     */
    public function siebelURL(){
        return $this->crude_conf['siebel_url'];
    }

    /**
     * Return counters state
     */
    public function counters(){
        return $this->is_on('counters');
    }
}