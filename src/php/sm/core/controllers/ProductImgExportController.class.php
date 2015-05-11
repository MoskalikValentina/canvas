<?php
/**
 * Use for exporting products images
 */

class ProductImgExportController {
    private $config;

    /**
     * @param Config $config Object with config data
     */
    public function __construct(Config $config){
        $this->config = $config;
    }


    public function export(){
        //Prepare ZIP
        require_once BASEDIR . 'sm/core/helpers/ZIP.class.php';
        $export_path = $this->config->exp_path();
        $export_file_name = $this->config->prod_img_exp_file_name();
        $img_zip = new Zip($export_file_name, $export_path);

        //Get product for taking only used images
        //Get data from DB
        require_once BASEDIR . 'sm/core/db/DBConnect.class.php';
        require_once BASEDIR . 'sm/core/db/DBTbl.class.php';
        //Make connection
        $db_connection = DBConnect::withConfig($this->config);
        //Prepare table
        $tbl_name = $this->config->prod_tbl_name();
        $tbl_structure = $this->config->req_structure();
        $db_tbl = new DBTbl($tbl_name, $tbl_structure, $db_connection);
        //Get data from DB
        $products = $db_tbl->readFull();

        //Add files to zip
        foreach ($products as $product) {
        	$img_path = str_replace(array("\r\n", "\r", "\n"), '', $product['image']); //Remove newline sings //todo add it to unput line cleaner
            $img_zip->add_file($img_path); //todo Use there variable from config
        }

        //save and return
        $img_zip->save();
        echo $file_path = $export_path . $export_file_name; //todo Move link echo into engine.php
        //return

    }
}