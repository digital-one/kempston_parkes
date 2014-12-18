<?php
class db
{
	var $IP;
	var $LOGIN;
	var $PASS;
	var $DB;
	var $CONNECTION;

	function db()
	{
		global $CONF;
		$this->IP=$CONF->get("/configuration/db/address");
		$this->LOGIN=$CONF->get("/configuration/db/login");
		$this->PASS=$CONF->get("/configuration/db/pass");
		$this->DB=$CONF->get("/configuration/db/name");
		
		$this->CONNECTION=mysql_connect($this->IP,$this->LOGIN,$this->PASS) or die("Brak po³±czenia z baz± danych");

	}

	function query($query)
	{
		$ret=@mysql_db_query($this->DB,$query,$this->CONNECTION) or die("<br>B³±d zapytania sql : ".$query."<br>".mysql_error());
		return $ret;
		
	}
    
	function fetch_array($res,$assoc=true)
	{
		if($assoc)
			$ret=@mysql_fetch_assoc($res);
		else
			$ret=@mysql_fetch_array($res);
		
		return $ret;
	}
	
	function fetch_cols_name($res)
	{
		$num=$this->num_cols($res);
		
		for($i=0;$i<$num;$i++)
		$ret[$i]=mysql_field_name($res,$i);
		
		return $ret;
	}

    
	function insert_id()
	{
	 return mysql_insert_id($this->CONNECTION);
	}

	function num_rows($rs)
	{
	 return mysql_num_rows($rs);
	}
	
	function num_cols($rs)
	{
		return mysql_num_fields($rs); 
	}
	
	function affected_rows()
	{
	 return mysql_affected_rows($this->CONNECTION);
	}
	
	function data_seek($rs,$pos)
	{
	 return mysql_data_seek($rs,$pos);
	}

}

?>