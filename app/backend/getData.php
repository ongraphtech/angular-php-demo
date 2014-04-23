<?php
/* include config for DB connection  */
include_once 'config.php';

/* get params  */
$postData = file_get_contents("php://input");
$postArray = json_decode($postData,true);

$resp = array();

/* check for user info into DB  */
if(isset($postArray['uname']) && $postArray['uname'] != ''){
	$base = new SQLite3(DBNAME);
	$query = "SELECT UserKey, CreatedDate, ModifiedDate, UserName, FirstName, LastName, EmailId, Password FROM USERSTBL WHERE UserName ='".$postArray['uname']."'";
	$results = $base->query($query);

	if ($results) {
		$res = $results->fetchArray(SQLITE3_ASSOC); 
		if ($res['Password'] == md5($postArray['pswd'])) {
			$resp['status'] = 0;
			$resp['message'] = "Login successful";
			$resp['UserKey'] = $res['UserKey'];
			$resp['FirstName'] = $res['FirstName'];
			$resp['Password'] = $res['Password'];
		}
		else{
			$resp['status'] = 1;
			$resp['message'] = "Wrong username or password";
		}
	}else{
		$resp['status'] = 1;
		$resp['message'] = "Wrong username or password";
	}
	
	/* print response  */
	exit(json_encode($resp));
}
?>
