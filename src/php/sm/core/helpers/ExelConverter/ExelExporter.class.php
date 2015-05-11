<?php
/**
 * Use for export to exel file
 */

class ExelExporter {
    private $data;
    private $export_path;
    private $file_name;
    private $php_exel_path = 'sm/core/helpers/ExelConverter/';


    public function __constract(){

    }

    /**
     * @param array $export_data Data for exporting in exel.
     * @param $export_path Path for saving output exel file
     * @param string $file_name export file name
     */
    public function init(Array $export_data, $export_path, $file_name){
        $this->data = $export_data;
        $this->export_path = $export_path;
        $this->file_name = $file_name;
    }

    public function export(){
        //Requirement
        require_once($this->php_exel_path . 'PHPExcel.php');
        require_once($this->php_exel_path . 'PHPExcel/Writer/Excel5.php');

        //Table prepare
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Все записи');

        //Prepare array for write
        $exel_array = array();
        foreach($this->data as $array){
            $tmp_array = array();
            foreach($array as $k => $v){
                array_push($tmp_array, $v);
            }
            array_push($exel_array, $tmp_array);
        }

        //Write to sheet
        $sheet->fromArray(
                $exel_array,    // The data to set
                NULL,           // Array values with this value will not be set
                'A1'            // Top left coordinate of the worksheet range where
                                // we want to set these values (default is A1)
        );

        //Save to file
        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $file_path = $this->export_path . $this->file_name;
        $objWriter->save($file_path);

        return $file_path;
    }
} 