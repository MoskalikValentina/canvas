<?php
/**
 * Convert exel doc to array
 */

class ExelImporter {
    private $file_path;
    private $php_exel_path = 'sm/core/helpers/ExelConverter/';

    public function __construct(){

    }

    public function convert($file_path){
        require_once($this->php_exel_path . 'PHPExcel/IOFactory.php');
        //Prepare
        $xls = PHPExcel_IOFactory::load($file_path);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $exel_array = $sheet->toArray(
            NULL,        // Value that should be returned for empty cells
            false,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            false,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            false         // Should the array be indexed by cell row and cell column
        );

        return $exel_array;
    }
} 