<?php

/**
* Class with table object
*/
class DBTbl
{

	private $name;
	private $structure;
	private $db_connect;

	/**
	 * Default constructor base on tbl data in config
     * @param $tbl_name String with tbl name
     * @param $tbl_structure Array with tbl structure
	 * @param Object $db_connect DBConnect object
	 *                           Using for take access to DB table
	 */
	function __construct($tbl_name, $tbl_structure, $db_connect)
	{
		$this->name = $tbl_name;
		$this->structure = $tbl_structure;
		$this->db_connect = $db_connect;
	}

	/**
	 * Write data in DB table
	 * @param  Array $record Array with data for record in TABLE STRUCTURE FORMAT
	 *                       ['field_name' => 'value']
	 */
	function write($record){
		$req = $this->prepearRequest($record);
		$this->db_connect->DBSel();
		return mysql_query($req);
	}

	/**
	 * Prepear SQL request with user data
	 * @param  Array $record Array with data for record in TABLE STRUCTURE FORMAT
	 *                       ['field_name' => 'value']
	 * @return string        String with SQL request
	 */
	protected function prepearRequest($record){
		$req = "INSERT INTO " . $this->name . ' (';
		$val = '';
		foreach ($this->structure as $field_name => $value) {
			if($field_name !== 'id' && $field_name !== 'date_time') { //todo Add generarion timestamp when request making
                $req = $req . $field_name . ', ';
                //Use for saving NULL data as ''
                if (isset($record[$field_name])) {
                    $val = $val . "'" . $record[$field_name] . "', ";
                } else {
                    $val = $val . "'', ";
                }
            }
		}
		$req = substr($req, 0, strlen($req) - 2) . ') VALUES ('. substr($val, 0, strlen($val) - 2) . ')';

		return $req;

	}

	/**
	 * Read full date frome tbl
	 * @return array Full table data form DB in array
	 */
	function readFull(){
		$req = "SELECT * FROM " . $this->name;
		$this->db_connect->DBSel();
		$res = mysql_query($req);
		$res_array = array();
		$i = 0;
		while ($res_tmp = mysql_fetch_array($res, MYSQLI_ASSOC)) {
			$res_array[$i] = $res_tmp;
			$i++;
		}


		return $res_array;
	}

	/**
	 * Read field frome current DB
	 * All params must be clearing before
	 * @param string $col_name Name of table column
	 * @param string @col_value Name of field value
	 * @return array with data or bool false if error
	 */
	function readField($clear_col_name, $clear_col_value){
		$req = 'SELECT * FROM ' . $this->name . ' WHERE '. $clear_col_name . '="' . $clear_col_value . '"';
		$this->db_connect->DBSel();
		$res = mysql_query($req);
		if(!$res){
			$r = false;
		} else {
			$i = 0;
			$res_array = array();
			while ($res_tmp = mysql_fetch_array($res)) {
				$res_array[$i] = $res_tmp;
				$i++;
			}
			$r = $res_array;
		}

		return $r;
	}

	/**
	 * Delete all records from table in database
	 *	@param bool $resolution Using for comfirm clear table
	 */
	function clearTbl($resolution){
		$req = 'DELETE FROM '. $this->name; //Clear current table
		if($resolution){
			$this->db_connect->DBSel();
			$res = mysql_query($req);
		}
	}


	/**
	 * Make backup copy of current table
	 */
	function backupTbl(){
		$backup_name = 'backup_' . $this->name;
		$this->db_connect->DBSel();

		if(!mysql_query('DELETE FROM '. $backup_name)){
			mysql_query('CREATE TABLE ' . $backup_name . ' AS (SELECT * FROM ' . $this->name . ')');
		} else {
			mysql_query('INSERT INTO ' . $backup_name . ' SELECT * FROM ' . $this->name);
		}
	}

}

?>