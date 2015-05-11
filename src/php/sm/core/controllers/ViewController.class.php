<?php
/**
 * Use for product output
 */

class ViewController {
    private $config;
    private $products;

    public function __construct(Config $config){
        require_once BASEDIR . 'sm/core/Request.class.php';
        $this->config = $config;
    }

    /**
     * @return array with products list
     */
    public function get_all(){
        if(count($this->products) > 0){
            $res = $this->products;
        } else {
            $res = $this->get_all_from_db();
        }

        return $res;
    }

    /**
     * Get products from DB and set $this->products
     * @return array with products list
     */
    private function get_all_from_db(){
        //Get data from DB
        require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
        require_once BASEDIR . 'sm/core/db/DBTbl.class.php';
        //Make connection
        $db_connection = DBConnect::withConfig($this->config);
        //Prepare table
        $tbl_name = $this->config->prod_tbl_name();
        $tbl_structure = $this->config->prod_structure();
        $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);
        //Get data from DB
        $data = $db_tbl->readFull();
        $this->products = $data;

        return $data;
    }




}