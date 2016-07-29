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

function getDataSetInput($DBConnArray, $sql, $input){
$errorMessage = "";
$success = 1;
$DBConn = $DBConnArray['Connection'];
$dbErrorArray = array("Success" => 1, "ErrorMessage" => "");
try {
	$stmt = $DBConn->prepare($sql);
	$stmt->bindParam(":input", $input);
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

function insertData($DBConnArray, $sql, $input1, $input2="", $input3="", $input4="", $input5=""){
	$errorMessage = "";
	$success = 1;
	$DBConn = $DBConnArray['Connection'];
	$dbErrorArray = array("Success" => 1, "ErrorMessage" => "");
	try {
		$stmt = $DBConn->prepare($sql);
		$stmt->bindParam(":input1", $input1);
		if(!preg_match("/$\s*^/", $input2)){
			$stmt->bindParam(":input2", $input2);
		}
		if(!preg_match("/$\s*^/", $input3)){
			$stmt->bindParam(":input3", $input3);
		}
		if(!preg_match("/$\s*^/", $input4)){
			$stmt->bindParam(":input4", $input4);
		}
		if(!preg_match("/$\s*^/", $input5)){
			$stmt->bindParam(":input5", $input5);
		}

		$stmt->execute();
		#$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		#$rows = $stmt->fetchAll();
	}
	catch(PDOException $e) {
		#$rows = array();
		$dbErrorArray['Success'] = 0;
		$dbErrorArray['ErrorMessage'] =
					preg_replace("/SQLSTATE\[[^\]]*]\:\s/", "", $e->getMessage());
	}
$DBConn = null;
return array('DataSet' => array(), 'ErrorReturn' => $dbErrorArray);
}

function getLastInsertKey($DBConnArray){
	$DBConn = $DBConnArray['Connection'];
	return $DBConn->lastInsertId();
}
?>
