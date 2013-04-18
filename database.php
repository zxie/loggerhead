<?php
class Db
{
	// Constructor method.
	// -------------------------------------------------
    function Db($host, $username, $password, $database)
    {
        $this->connect($host, $username, $password, $database);
    }
    
	function connect($host, $username, $password, $database)
	{
		mysql_select_db($database, mysql_connect($host, $username, $password));
	}

	// Delete method.
	// -------------------------------------------------
	function delete($table, $id)
	{
		$sql = "DELETE FROM `" . $table . "` WHERE `id` = '" . Db::escape($id) . "'";
		return mysql_query($sql);
	}

	// Select method.
	// -------------------------------------------------
	function select($table, $id=null)
	{
	    if ( $id!="0" && empty($id) || is_bool($id) ) // No $id given, thus select all rows.
        {
			$desc = $id ? " DESC" : "";
		    $sql = "SELECT * FROM `" . $table . "` ORDER BY `id`" . $desc;
		}
		elseif (is_array($id)) // grabs rows matching where clauses given
		{
			$sql = "SELECT * FROM `" . $table . "` WHERE ";
				$first=true;
				foreach($id as $col=>$val) {
				  if($first) $first=false;
					else $sql.=" AND ";
				  $sql .= "`".Db::escape($col)."` = '" . Db::escape($val) . "'";
				}

		} else { // Grabs the row associated with the given $id.
				$sql = "SELECT * FROM `" . $table . "` WHERE `id` = '" . Db::escape($id) . "'";
		}
		
		return mysql_query($sql);
	}

	// Update method.
	// -------------------------------------------------
	function update($table, $id)
	{
		$getColumns = mysql_query("SELECT * FROM " . $table);
		while($column = mysql_fetch_field($getColumns))
		{
			$column = $column->name;
			if (isset($_POST[$column]))
			{
				manipulateValues($column); // Manipulate certain values before inserting them into db.
				                                  // This will be built up-on in the future.
				
				$fields[] = "`" . $column . "` = '" . htmlspecialchars($_POST[$column]) . "'";
			}
		}

		$sql = "UPDATE `" . $table . "` SET " . implode(", ", $fields) . " WHERE `id` = '" . $id . "'";
		return mysql_query($sql);
	}

	// Insert method.
	// -------------------------------------------------
	function insert($table)
	{
		$getColumns = mysql_query("SELECT * FROM " . $table);

		while($column = mysql_fetch_field($getColumns))
		{
			$column = $column->name;
			if (isset($_POST[$column]))
			{
				$fields[$column] = "'" . htmlentities(addslashes($_POST[$column])) . "'";
			}
		}

		$sql = "INSERT INTO `" . $table . "` (`" . implode("`, `", array_keys($fields)) . "`) VALUES (" . implode(", ", $fields) . ")";
		mysql_query($sql);
		return mysql_insert_id();
	}
	
	// Normal query for custom needs.
	// NOTICE: When using this method, it is your job to assure user submitted-data is secure.
	// -------------------------------------------------
	function query($sql)
	{
		return mysql_query($sql);
	}
	
	function num_fields($result)
	{
	    return mysql_num_fields($result);
	}
	function fetch_field($result)
	{
	    return mysql_fetch_field($result);
	}
	
	function fetch_row($result)
	{
	    return mysql_fetch_row($result);
	}
	
	function num_rows($result)
	{
	  return mysql_num_rows($result);
	}
	
	function fetch_array($result)
	{
	    return mysql_fetch_array($result);
	}
	function fetch_assoc($result)
	{
	    return mysql_fetch_assoc($result);
	}
	function escape($string)
	{
	    return mysql_real_escape_string($string);
	}

	// Check for tables existance.
	function table_exists($sector)
	{
		$getTables = mysql_query("SHOW TABLES");
		while($table = mysql_fetch_array($getTables))
		{
			if ($sector == $table[0])
			{
				return true;
			}
		}
	}
	
    function show_columns($table, $column)
    {
        return mysql_query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $column . "'");
    }
	
	
	// Manipulate values before inserting or updating into db.
	// Used by the db class.
	// Doesn't return anything cause it modifies the $_POST.
	function manipulateValues($column)
	{
		$field = Utils::findField($column);
		if ($column == "password_txt") // Password? Then hash it.
		{
			$_POST[$column] = md5($_POST[$column]);
		}
		elseif ($field == "date") // Date? Then timestamp it.
		{
			$_POST[$column] = mktime(0, 0, 0, $_POST[$column][0], $_POST[$column][1], $_POST[$column][2]);
		}
	}
}

class Query{
	var $sql;
	
	function __construct(){
		$this->sql = '';
	}
	function select($table, $columns=null){
		if($columns==null) $columns = '*';
		$this->sql = "SELECT " . $columns . " FROM " . $table . " ";
		return $this;
	}
	function insert($table, $fields){
		$this->sql = "INSERT INTO `" . $table . "` (`" . implode("`, `", array_keys($fields)) . "`) VALUES (" . implode(", ", $fields) . ") ";
		return $this;
	}
	function update($table, $fields, $value=null){ //needs where
		if(isset($value))
			$this->sql = "UPDATE `" . $table . "` SET `" . $fields . "`='" . $value . "' ";
		else
			$this->sql = "UPDATE `" . $table . "` SET " . implode(", ", $fields) . " ";
		return $this;
	}
	function increment($table, $field, $value){
		$this->sql = "UPDATE `" . $table . "` SET " . $field . "=" . $field . "+1 ";
		return $this;
	}
	function delete($table){ //needs where
		$this->sql = "DELETE FROM `" . $table . "` ";
		return $this;
	}
	function alterAdd($table, $column){
		$this->sql = "ALTER TABLE `" . $table . "` ADD `". $column ."` INT NULL ";
		return $this;
	}
	function alterDrop($table, $column){
		$this->sql = "ALTER TABLE `" . $table . "` DROP `". $column ."` ";
		return $this;
	}
	
	function orderBy($field){
		$this->sql .= "ORDER BY " . $field . " ";
		return $this;
	}
	function desc(){
		$this->sql .= "DESC ";
		return $this;
	}
	function where($args){
		$this->sql .= "WHERE " . $args . " ";
		return $this;
	}
	function limit($args, $args2=null){
		if(isset($args2)) $args2 = ", ".$args2;
		$this->sql .= "LIMIT " . $args . $args2 . " ";
		return $this;
	}
	function leftJoin($table, $on){//after select  **Note: on links common value b/w the tables
		$this->sql .= "LEFT JOIN `" . $table . "` ON " . $on . " ";
		return $this;
	}
	
	function result(){
		return mysql_query($this->sql);
	}
	function nextAssoc(){
		return mysql_fetch_assoc($this->result());
	}
	function nextNum(){
		return mysql_fetch_rows($this->result());
	}
	function reset(){
		$this->sql = '';
		return $this;
	}
	function query(){
		return $this->sql;
	}
}

$Db = new Db($settings['database']['databaseHost'], $settings['database']['databaseUsername'], $settings['database']['databasePassword'], $settings['database']['databaseName']);
$query = new Query;
?>
