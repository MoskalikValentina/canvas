<?php

/**
* Convert data to and from exel files
*/
class ExelConverter
{
	private $data;
	private $work_path;
	private $filename;
	private $data_structure;
	private $php_exel_path;


	//Using for importing
	private $exel_file_path;
	private $import_data_structure;
	private $tbl_structure;

	/**
	 * Empty cunstructor for using alternative constructors
	 */
	function __construct()
	{
		return false;
	}

	/**
	 * Construct new ExelConver object base on array with data
	 * @param Array $array_data Array with data for convertin g to exel
	 * @param Object $config Object Config class for geting data structure and saving path
	 * @param String $data_type String with type of table for exporting
	 */
	public static function fromArray($array_data, $config, $data_type){
		$instance = new self();

		$instance->data = $array_data;
		$instance->work_path = $config->getExportPath();
		$instance->filename = $data_type . '_' . $config->getExportFileName();
		$instance->data_structure = $config->getExportDataStructure($data_type);
		$instance->php_exel_path = $config->getPHPExelPath();

		return $instance;
	}

	/**
	 * Construct new object by exel file
	 */
	public static function fromExel($exel_file_path, $config, $data_type){
		$instance = new self();

		$instance->exel_file_path = $exel_file_path;
		$instance->php_exel_path = $config->getPHPExelPath();
		$instance->tbl_structure = $config->getPHPExelPath();
		$instance->import_data_structure = $config->getImportDataStructure($data_type);
		$instance->data_structure = $config->getExportDataStructure($data_type);
		$instance->tbl_structure = $config->getTBLStructureByType($data_type);
		$instance->convertFromExel();

		return $instance;
	}

	/**
	 * Converting to exel file object data
	 * Return path to file with exported data
	 */
	function convertToExel(){
		//Table prepearing
		require_once($this->php_exel_path . 'PHPExcel.php');
		require_once($this->php_exel_path . 'PHPExcel/Writer/Excel5.php');
		$xls = new PHPExcel();
		$xls->setActiveSheetIndex(0);
		$sheet = $xls->getActiveSheet();
		$sheet->setTitle('Все записи');
		//Titles generation
		foreach ($this->data_structure as $col_data) {
			$sheet->setCellValue($col_data[0] . '1', $col_data[1]);
		}
		//Table generation
		foreach ($this->data as $item => $item_datas) {
			foreach ($item_datas as $field_type => $value) {
				if(is_string($field_type) && isset($this->data_structure[$field_type][0])){
					$c = $this->data_structure[$field_type][0] . ($item + 2);
					$sheet->setCellValue($c, $value);
				}
			}
		}
		//Save to file
		$objWriter = new PHPExcel_Writer_Excel5($xls);
		$file_path = $this->work_path . $this->filename;
 		$objWriter->save($file_path);

 		return $file_path;
	}

	/**
	 * Convert current exel file to data by structuere
	 */
	private function convertFromExel(){
		require_once($this->php_exel_path . 'PHPExcel/IOFactory.php');
		$xls = PHPExcel_IOFactory::load($this->exel_file_path);
		$xls->setActiveSheetIndex(0);
		$sheet = $xls->getActiveSheet();

		//Parse file to array
		$sheet_size = $sheet->getHighestRow();
		$tmp_tbl = array();
		for($i=1; $i<=$sheet_size; $i++){
			$tmp_row = array();
			foreach ($this->import_data_structure as $s) {
				$val = $sheet->getCell($s['position'].$i)->getValue();
				array_push($tmp_row, $val);
			}
			array_push($tmp_tbl, $tmp_row);
		}

		//Prepear array base on structure
		$cars_parsed = array();
		foreach($tmp_tbl as $tbl_row){
			$row = array();
			$i = 0;
			foreach($tbl_row as $field){
				$row[$this->import_data_structure[$i]['name']] = $field;
				$i++;
			};
			array_push($cars_parsed, $row);
		}

		//Remove title
		$cars_parsed = array_slice($cars_parsed, 1);

		$this->data = $cars_parsed;
		}

		/**
		 * return current data from object
		 */
		public function getData(){
			return $this->data;
		}
}