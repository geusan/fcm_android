<?

//insert or update token to database

	mysql_connect( "localhost", ""/*ID*/, ""/*PW*/ );
	mysql_query( "SET NAMES 'utf8'" );
	mysql_select_db( ""/*Database name*/ );
	
	if(isset($_REQUEST['Token'])){
		
		$token = $_REQUEST['Token'];
				
		$query = "INSERT INTO fcm(token) VALUES ('".$token."')
					ON DUPLICATE KEY UPDATE Token = '".$token."'";
					
		mysql_query($query);
		$res = mysql_query($query) or die(mysql_error());
	}
?>