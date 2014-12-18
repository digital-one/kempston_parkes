<?php
class validator extends templateEngine
{
	public $errors;
	
	function __construct()
	{
	
	}
  
	function validate()
	{
		$ret=true;
		
		if(sizeof($this->errors)>0) 
		$ret=false;

		return $ret;
	}
	
	function error()
	{
		$this->parseTemplate("templates/validator.html");
		
		
		return $this->getHtml();
	}
	
	function verifyText($text,$minimal_length=0,$error="<li>Nieprawid³owy text.<br>")
	{
	    $text=trim($text);
		$text=strip_tags($text);
		$text=addslashes($text);
		$ret=true;
		if(empty($text)) 
			{ $this->errors[]=$error; $ret=false; }
		else if( ($minimal_length>0) && (strlen($text)<$minimal_length) )
			{ $this->errors[]=$error; $ret=false; }
		return $ret;
	}
	
	function verifyLogin($login,$error="<li>Taka nazwa u¿ytkownika ju¿ istnieje, wpisz inn± nazwe.</li>")
	{
		global $DB;
		$ret=true;
		$rs=$DB->query("SELECT * FROM user WHERE login like '".$login."'");
		if($DB->num_rows($rs)>0) { $this->errors[]=$error;   $ret=false; }
		
		return $ret;
	}
	
	function verifyDbField($table,$field,$value,$error="<li>Taka nazwa u¿ytkownika ju¿ istnieje, wpisz inn± nazwe.</li>",$exists=true)
	{
		global $DB;
		$ret=true;
		$rs=$DB->query("SELECT ".$field." FROM ".$table." WHERE ".$field." like '".$value."'");
		if($exists)
		{
			if($DB->num_rows($rs)>0) { $this->error[]=$error;   $ret=false; }
		}
		else
		{
			if($DB->num_rows($rs)<1) { $this->error[]=$error;   $ret=false; }
		}
		
		return $ret;
	}

	function verifyEmail($email,$error="<li>Nieprawid³owy adres email.<br>") 
	{
		$wholeexp = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,5})$/i';
		$userexp = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
		if (preg_match($wholeexp, $email, $regs))
		{
			$username = $regs[1];
			$host = $regs[2];
			if(1)//(checkdnsrr($host, MX)) 
			{
				if (preg_match($userexp, $username)) return true;
				else { $this->errors[]=$error; return false; }
			} 
			else { $this->errors[]=$error; return false; }
		} 
		else { $this->errors[]=$error; return false; }
	}

	function verifyPasses($pass,$pass2,$error="<li>Wprowadzone has³a nie zgadzaj± siê.</li>")
	{
		$ret=true;
		if($pass!=$pass2)     	 { $this->errors[]=$error; $ret=false; }
		return $ret;
	}
	
	function verifyOldPass($id,$pass,$error="<li>Wprowadzono niepoprawne has³o.<br>",$tableName='customer')
	{
		global $DB;
		$pass=trim($pass);
        $rs=$DB->query("SELECT id FROM ".$tableName." WHERE id='".$id."' AND pass LIKE '".$pass."'");
		if($DB->num_rows($rs)==1) return true;
		else { $this->errors[]=$error;  return false; };
	}
  
}

?>