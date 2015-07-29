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

    /**
     * Check user credentials
     *
     * @param $name
     * @param $password
     * @return bool
     */
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
            if($user[0]['password'] === crypt($password, $user[0]['password']) && $user[0]['access_tbl'] === $access_tbl){
                $_SESSION['login'] = true;
                $_SESSION['id'] = $user[0]['id'];
                $res = true;
            }
        }
        return $res;
    }

    /**
     * Logout user
     */
    public static function log_out(){
        unset($_SESSION['login'], $_SESSION['id']);
    }
} 