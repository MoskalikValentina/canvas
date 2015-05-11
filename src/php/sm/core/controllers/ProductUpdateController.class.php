<?php
/**
 * Use for update product info in DB
 */

class ProductUpdateController {
    private $config;

    /**
     * @param Config $config Object with config data
     */
    public function __construct(Config $config){
        require_once BASEDIR . 'sm/core/helpers/ExelConverter/ExelExporter.class.php';
        $this->config = $config;
    }

    /**
     * @param string $file_path Path to loaded exel file with product data
     */
    public function update($file_path){
        if($this->config->prod_export()) {
            //Convert from exel to array
            require_once BASEDIR . 'sm/core/helpers/ExelConverter/ExelImporter.class.php';
            $importer = new ExelImporter();
            $data = $importer->convert($file_path);

            //Prepare data for saving to DB
            array_shift($data); //Remove titles

            //Prepare data keys
            $data_keys = array();
            foreach ($this->config->prod_structure() as $k => $v) {
                array_push($data_keys, $k);
            }

            //Convert data_array to associate array with prepares keys
            $p_data = array();
            foreach ($data as $product) {
                $tmp_arr = array();
                foreach ($product as $k => $v) {
                    $key = $data_keys[$k];
                    $tmp_arr[$key] = $v;
                }
                array_push($p_data, $tmp_arr);
            }

            //Prepare DB tbl for work
            require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
            require_once BASEDIR . 'sm/core/db/DBTbl.class.php';

            //Make connection
            $db_connection = DBConnect::withConfig($this->config);

            //Prepare table
            $tbl_name = $this->config->prod_tbl_name();
            $tbl_structure = $this->config->prod_structure();
            $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);
            //Make tbl backup
            $db_tbl->backupTbl();
            //Clear tbl
            $db_tbl->clearTbl(true);

            //Saving data to DB tbl
            foreach ($p_data as $record) {
                $db_tbl->write($record);
            }
        } else {
            echo 'Product update is "OFF"';
        }

    }


} 