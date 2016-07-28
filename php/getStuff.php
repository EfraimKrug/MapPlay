<?php
#
# building database access:
#
include_once 'dbInterface.php';
$DBConnArray = getDBConn();
if(!$DBConnArray['ErrorReturn']['Success']){
	echo json_encode(array('table' => $DBConnArray['ErrorReturn']['ErrorMessage']));
	}

$sql = "SELECT a.area_name, a.lat, a.lng, count(a.id) as count
					from 	areas as a,
								reports as r,
								area_reports as ar
					where a.id = ar.area_id
						and r.id = ar.report_id
						and r.symptom_2 = 1
						and r.symptom_3 = 1
						and r.symptom_4 = 1
						group by a.id;";

$returnArray = getDataSet($DBConnArray, $sql);
if(!$returnArray['ErrorReturn']['Success']){
	echo json_encode(array('table' => $DBConnArray['ErrorReturn']['ErrorMessage']));
	return;
	}

$collectionArray = array();
if(count($returnArray['DataSet']) > 0){
	foreach($returnArray['DataSet'] as $idx => $row){
		$collectionArray[$row['area_name']] =
											array('center' =>
														array('lat' => (double)$row['lat'], 'lng' => (double)$row['lng']),
														'population' => (int)$row['count']
													);
		}
}

#print_r($collectionArray);
#echo json_encode($collectionArray);
#exit(1);

// $arr = array(
// 				'gardner' =>
// 						array('center' =>
// 								array('lat' => 42.338, 'lng' => -71.09),
// 								'population' => 2
// 						),
// 				'parsons' =>
// 						array('center' =>
// 								array('lat' => 42.337, 'lng' => -71.115),
// 								'population' => 5
// 						),
// 				'kenmore' =>
// 						array('center' =>
// 								array('lat' => 42.349, 'lng' => -71.096),
// 								'population' => 3
// 						),
// 				'childrens' =>
// 						array('center' =>
// 								array('lat' => 42.337, 'lng' => -71.105),
// 								'population' => 1
// 						),
// 			);

#print_r($arr);
echo json_encode($collectionArray);
#echo "[" . json_encode($collectionArray) . "]";
#echo "\n\n";
#echo "[" . json_encode($arr) . "]";
?>
