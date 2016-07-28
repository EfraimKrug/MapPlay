<?php
#
# get Database Connection
#
function getDBConn(){
	$servername = "localhost";
	$username = "root";
	$password = "b0st0n";
	$dbname = "fny";
	$conn = "";

	$dbArray = array();
	$dbErrorArray = array("Success" => 1, "ErrorMessage" => "");
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	catch(PDOException $e) {
		$dbErrorArray['Success'] = 0;
		$dbErrorArray['ErrorMessage'] =
				preg_replace("/SQLSTATE\[[^\]]*]\:\s/", "", $e->getMessage());
	}

	$dbArray = array('Connection' => $conn, 'ErrorReturn' => $dbErrorArray);
	return $dbArray;
}

function getDataSet($DBConnArray, $sql){		
	$errorMessage = "";
	$success = 1;
	$DBConn = $DBConnArray['Connection'];
	$dbErrorArray = array("Success" => 1, "ErrorMessage" => "");
	try {
		$stmt = $DBConn->prepare($sql);
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rows = $stmt->fetchAll();
	}
	catch(PDOException $e) {
		$rows = array();
		$dbErrorArray['Success'] = 0;
		$dbErrorArray['ErrorMessage'] =
					preg_replace("/SQLSTATE\[[^\]]*]\:\s/", "", $e->getMessage());
	}
$DBConn = null;
return array('DataSet' => $rows, 'ErrorReturn' => $dbErrorArray);
}
?>
