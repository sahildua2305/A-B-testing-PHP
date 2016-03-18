<?php
 
/**
 * Handling database connection
 *
 */
<<<<<<< HEAD


=======
require_once('includes/connection.inc.php');
>>>>>>> 120dee9f73b3debc4a2baca2a77794805c823a3d
class Database {
 
    private $DB;
 
    function __construct() {       
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function DB() {
<<<<<<< HEAD
    	$mysql_host = 'localhost';
		$mysql_user = 'root';
		$mysql_pass = '';
		$mysql_data = 'ab_testing';
=======
>>>>>>> 120dee9f73b3debc4a2baca2a77794805c823a3d
 
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
<<<<<<< HEAD
        $this->DB = new PDO("mysql :host=$mysql_host;dbname=$mysql_data", $mysql_user, $mysql_pass, $options);
=======
        $this->DB = new PDO('mysql :host=' . $mysql_host . ';dbname=' . $mysql_data, $mysql_user, $mysql_pass, $options);
>>>>>>> 120dee9f73b3debc4a2baca2a77794805c823a3d

        // returning connection resource
        return $this->DB;
    }
	
	/**
	 * select() - Selects given values from the given table with given conditions.
	 * Return false if table name or values to be selected are not supplied
	 *
	 * @param $table, Table name
	 * @param $values, Values to select
	 * @param $condition, Condition for selecting rows
	 * @param $db, Database name
	 * @param $fetch, Fetch method for PDO; options - 'fetch', 'fetchALL' etc
	 * @return selected rows if $table and $values are not null
	 */
	public function select($table = NULL, $values = NULL, $condition = 1, $db = 'DB', $fetch = 'fetch')
	{
		if($table == NULL || $values == NULL)
			return false;
		$this->$db();
		$values = implode(',', $values);
		$sql = "SELECT $values FROM $table WHERE $condition";
		$query = $this->$db->prepare($sql);
		$query->execute();
		$result = array();
		while ( $row = $query->fetch() ) {
			array_push( $result, $row );
        }
		$this->$db = null;
		return $result;
	}

	/**
	 * insert() - Inserts given values in the given table.
	 * Return false if table name or values or columns are not supplied
	 *
	 * @param $table, Table name
	 * @param $columns, Columns to update
	 * @param $values, Values to select
	 * @param $db, Database name
	 * @return true
	 */
	public function insert($table = NULL, $columns = NULL, $values = NULL, $db = 'DB')
	{
		if($table == NULL || $columns == NULL || $values == NULL)
			return false;
		$cols = implode(', ',$columns);
		$vals = implode(', :',$values);
		$this->$db();
		$sql  = "INSERT INTO $table ($cols) VALUES (:$vals)";
		$query = $this->$db->prepare($sql);
		foreach($columns as $i => $column)
			$query->bindParam(':'.$column, $values[$i]);
		$query->execute();
		$this->$db = NULL;
		return true;
	}
	
	/**
	 * update() - Updates given values in the given table with given conditions.
	 * Return false if table name or values or columns to be selected are not supplied
	 *
	 * @param $table, Table name
	 * @param $columns, Columns to update
	 * @param $values, Values to update
	 * @param $condition, Condition for updating rows
	 * @param $db, Database name
	 * @return true
	 */
	public function update($table = NULL, $columns = NULL, $values = NULL, $condition = 1, $db = 'DB')
	{
		if($table == NULL || $columns == NULL || $values == NULL)
			return false;
		$this->$db();
		$i = 0;
		$length = count($columns);
		$data = '';
		if($length > 1)
			while($i < $length)
			{
				$data .= $columns[$i]."= '".$values[$i]."'";
				if($i == $length-1);
				else
					$data .= ", ";
				$i++;
			}
		else if($length == 1)
			$data .= $columns[0]."= '".$values[0]."'";
		else
			return true;

		$sql  = "UPDATE $table SET $data WHERE $condition";
		$query = $this->$db->prepare($sql);
		foreach($columns as $i => $column)
			$query->bindParam(':'.$column, $values[$i]);
		$query->execute();
		$this->$db = NULL;
		return true;
	}

	/**
	 * delete() - Deletes rows in the given table.
	 *
	 * @param $table, Table name
	 * @param $condition, Condition to match to delete
	 * @param $db, Database name
	 * @return true
	 */
	function delete($table = NULL, $condition = 1, $db = 'DB')
	{
		if($table == NULL)
			return false;

		$this->$db();
		$sql = "DELETE FROM $table WHERE $condition";
		$query = $this->$db->prepare($sql);
		$query->execute();
		$this->$db = NULL;
		return true;
	}

}
 
?>
