<?php
#
# posting new user-report:
# Check for user - create user if new
# Then post report data
#
include_once 'dbInterface.php';
$DBConnArray = getDBConn();
if(!$DBConnArray['ErrorReturn']['Success']){
	echo json_encode(array('table' => $DBConnArray['ErrorReturn']['ErrorMessage']));
	}

#print_r($_POST); die;
#
# check for reporters
#
$sql = "SELECT *
					from 	reporters
					where name = :input";

$returnArray = getDataSetInput($DBConnArray, $sql, $_POST['reporter']);
if(!$returnArray['ErrorReturn']['Success']){
	echo json_encode(array('table' => $returnArray['ErrorReturn']['ErrorMessage']));
	return;
	}

#
# reporter not there - insert new
#
if(empty($returnArray['DataSet'])){
  $sql = "insert into reporters (name) values (:input1)";
  $returnArray = insertData($DBConnArray, $sql, $_POST['reporter']);
}

$reporterId = getLastInsertKey($DBConnArray);

#
# check for area and add (or not)
# There should be some relativity check on the coordinates here

$sql = "SELECT *
					from 	areas
					where area_name = :input";

$returnArray = getDataSetInput($DBConnArray, $sql, $_POST['place']);
if(!$returnArray['ErrorReturn']['Success']){
	echo json_encode(array('table' => $returnArray['ErrorReturn']['ErrorMessage']));
	return;
	}

#
# reporter not there - insert new
#
if(empty($returnArray['DataSet'])){
  $sql = "insert into areas (area_name, lat, lng) values (:input1, :input2, :input3)";
  $returnArray = insertData($DBConnArray, $sql,
                    $_POST['place'],
                    $_POST['Latitude'],
                    $_POST['Longitude']);
}

$areaId = getLastInsertKey($DBConnArray);

#
# now inserting an reports...
#
$sql = "insert into reports
            (reporter_id, symptom_1, symptom_2, symptom_3, symptom_4, symptom_5)
             values ($reporterId, :input1, :input2, :input3, :input4, :input5)";
$input1 = isset($_POST['symptom_1']) ? 1 : 0;
$input2 = isset($_POST['symptom_2']) ? 1 : 0;
$input3 = isset($_POST['symptom_3']) ? 1 : 0;
$input4 = isset($_POST['symptom_4']) ? 1 : 0;
$input5 = isset($_POST['symptom_5']) ? 1 : 0;

$returnArray = insertData($DBConnArray, $sql,
                                            $input1,
                                            $input2,
                                            $input3,
                                            $input4,
                                            $input5);

$reportId = getLastInsertKey($DBConnArray);
// connect areas and reports ...

$sql = "insert into area_reports
            (area_id, report_id)
             values ($areaId, $reportId)";

$returnArray = insertData($DBConnArray, $sql);
echo json_encode($returnArray);
?>
