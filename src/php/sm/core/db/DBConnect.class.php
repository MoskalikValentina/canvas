<?php

/**
* Class for connection to DB
*
* @param $server string Url of database server
* @param $db_name string Name of database
* @param $user string User`s name for database connection
* @param $pass string Password for database connection
*/

class DBConnect
{
	protected $connection;	//Server connection
	protected $db_name;		//DataBase name
	protected $server;
	protected $user;
	protected $pass;

	/**
	 * Empty constructor. Not for using
	 */
	function __constract(){

	}

	/**
	 * Default constractor with using base connection data
	 * @param string $server db access url
	 * @param string $db_name name of db
	 * @param string $user    db user name
	 * @param string $pass    db user pass
	 */
	public static function withData($server, $db_name, $user, $pass)
	{
        $instance = new self();
        $instance->db_name = $db_name;
		$instance->server = $server;
		$instance->user = $user;
		$instance->pass = $pass;
	}


	/**
	 * Alternative constractor of Connection object to DB whith using object by Config class
	 * @param  Object $config Config class object
	 * @return Object         DBconnect object
	 */
	public static function withConfig($config){
		$instance = new self();
		$connect_data = $config->get_db_data();
		$instance->db_name = $connect_data['name'];
		$instance->server = $connect_data['url'];
		$instance->user = $connect_data['user'];
		$instance->pass = $connect_data['password'];
		$instance->connect();
		return $instance;
	}

	/**
	 * Make new connection base on object properties
	 */
	private function connect(){
		$this->connection = mysql_connect(
			$this->server,
			$this->user,
			$this->pass ) or die('<p>Error connection to server ' . $this->server . '</p>');
	}

	/**
	* Database selection
	*/
	public function DBSel(){
		@mysql_select_db($this->db_name, $this->connection) or die('<p>DataBase with name ' . $this->db_name . ' not found</p>');
	}
}


?>