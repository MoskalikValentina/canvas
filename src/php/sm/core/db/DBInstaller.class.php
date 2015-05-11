<?php

/**
* Create new table in database
*
* @param $db_connect object Connection to database (Object of DBConnectoion class)
* @param $tbl_name string Name of new table
* @param $tbl_structure array Names and type of table fields
*	allowed types:
*		- text standart text field with default ''
*		- bool stabdart bool field
*		- stext varchar field (length 40)
*		- xstext varchar field (length 15)
*/

class DBInstaller
{
	protected $db_connect;
	protected $tbl_name;
	protected $tbl_structure ;
	protected $req;
	protected $tbl_fields;

	function __construct(DBConnect $db_connect, $tbl_name, $tbl_structure)
	{
		$this->db_connect = $db_connect;
		$this->tbl_name = $tbl_name;
		$this->tbl_structure = $tbl_structure;

		$this->parseFields();
		$this->prepearRequest();
	}

/*
* Parse table fileds and adding additional fields (ID and date_time) for use in SQL request
*/
	protected function parseFields(){
        $i = 0;
		foreach ($this->tbl_structure as $field_name => $field_type) {
            if($field_name === 'id'){
                $tmp_str = 'id smallint NOT NULL AUTO_INCREMENT, '; //ID prepearing
            } elseif ($field_name === 'date_time'){
                $tmp_str = 'date_time TIMESTAMP NOT NULL, '; //Date_time prepearing
            } else {
                switch ($field_type[1]) {
                    case 'text':
                        $tmp_str = $field_name . " TEXT DEFAULT '',";
                        break;
                    case 'bool':
                        $tmp_str = $field_name . ' BOOL, ';
                        break;
                    case 'stext':
                        $tmp_str = $field_name . ' varchar(40), ';
                        break;
                    case 'xstext':
                        $tmp_str = $field_name . ' varchar(15), ';
                        break;

                    default:
                        $tmp_str = $field_name . " TEXT DEFAULT '',";
                        break;
                }
            }
			$tbl_fields[$i] = $tmp_str;
			$i++;
		}
		$tbl_fields[$i] = 'PRIMARY KEY (id)';
		$this->tbl_fields = $tbl_fields;
	}


/*
* Prepeare SQL request
*/
	protected function prepearRequest(){
		$req = 'CREATE TABLE IF NOT EXISTS ' . $this->tbl_name . ' (';
		foreach($this->tbl_fields as $field) {
			$req = $req . $field;
		}
		$req = $req . ')';
		$this->req = $req;
	}

	public function installTBL(){
		$this->db_connect->DBSel();
		return mysql_query($this->req);
	}
}