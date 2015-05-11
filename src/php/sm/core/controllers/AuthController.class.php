<?php
/**
 * Use for authorize
 */

class AuthController {
    private $config;

    /**
     * @param Config $config Object with config data
     */
    public function __construct(Config $config){
        $this->config = $config;
    }

    public function log_in($name, $password){
        $res = false;
        //Get data from DB
        require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
        require_once BASEDIR . 'sm/core/db/DBTbl.class.php';
        //Make connection
        $db_connection = DBConnect::withConfig($this->config);
        //Prepare table
        $tbl_name = $this->config->users_tbl_name();
        $tbl_structure = $this->config->users_tbl_structure();
        $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);
        //Get data from DB
        $user = $db_tbl->readField('login', $name);

        $access_tbl = $this->config->req_tbl_name();
        if($user){
            if($user[0]['password'] === $password && $user[0]['access_tbl'] === $access_tbl){
                $_SESSION['login'] = true;
                $_SESSION['id'] = $user[0]['id'];
                $res = true;
            }
        }

        return $res;
    }
} 