<?php
/**
 * Use for export control
 */

class ExportController {
    private $config;

    /**
     * @param Config $config Object with config data
     */
    public function __construct(Config $config){
        require_once BASEDIR . 'sm/core/helpers/ExelConverter/ExelExporter.class.php';
        $this->config = $config;
    }


    public function export_full_tbl($tbl_name, $tbl_structure, $exp_path, $exp_filename){
            //Get data from DB
            require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
            require_once BASEDIR . 'sm/core/db/DBTbl.class.php';
            //Make connection
            $db_connection = DBConnect::withConfig($this->config);
            //Prepare table
            $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);
            //Get data from DB
            $data = $db_tbl->readFull();

            //Add table titles
            $ttls = array();
            foreach($tbl_structure as $k => $v){
                array_push($ttls, $v[0]);
            }
            array_unshift($data, $ttls);

            //Export to exel
            require_once BASEDIR . 'sm/core/helpers/ExelConverter/ExelExporter.class.php';
            $exporter = new ExelExporter();
            $exporter->init($data, $exp_path, $exp_filename);
            $exporter->export();

            //Return full file path
            $exp_file_path = CLEAR_REQUEST_URI . $exp_path . $exp_filename;
            return $exp_file_path;

    }



} 