<?

	mysql_connect( "localhost", ""/*ID*/, ""/*PW*/ );
	mysql_query( "SET NAMES 'utf8'" );
	mysql_select_db( ""/*Database name*/ );
	
	function send_notification ($tokens, $message)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array();
		$fields['data'] = $data;
		
		if(is_array($tokens)){
			//두개 이상 동시에 보낼 경우
			$fields['registration_ids'] = $tokens;
		}else {
			//한개만 보낼 경우
			$fields['to'] = $tokens;
		}
		
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key=AIzaSyAt1QmJH696GN-vUo1BEhsG7Wa0YmS8gu4'/*SERVER KEY*/
			);
	   

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);
	   curl_close($ch);
	   
       if (!$result) {
		   echo "FAIL!!";
           die('Curl failed: ' . curl_error($ch));
       }
	   
	   $obj = json_decode($result);
	   $cnt = $obj -> {"SUCCESS"};
	   //echo $obj;
       
       return $obj;
	}
	

	//get the token from the database

	$sql = "SELECT token FROM fcm";

	$result = mysql_query($sql) or die(mysql_error());
	$tokens = array();

	if(mysql_num_rows($result) > 0 ){

		while ($row = mysql_fetch_assoc($result)) {
			$tokens[] = $row["token"];
		}
	}
	//message create
	if ($myMessage == ""){
		$myMessage = "there is new posting";
	}

	$message = array("message" => $myMessage);
	$message_status = send_notification($tokens, $message);
	
	
	//sending message result
	if($message_status != null){
		echo "SUCCESS";
	} else {
		echo "FAILURE";
	}


?>