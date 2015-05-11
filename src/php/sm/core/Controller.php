<?php
/**
 * Using for manage web app
 */

namespace Samovar\Engine;


class Controller {
    private $config;

    public function __construct(){

    }

    /*
     * Make new config and init int
     * @params $config_file_path String with path to main config file
     * return config load state
     */
    public function init($config_file_path){
        $config = new Config();
        $st = $config->load_conf($config_file_path);
        if($st === true){
            $this->config = $config;
        }
        return $st;
    }

    /*
     *
     */
}