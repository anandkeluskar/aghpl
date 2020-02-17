<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
	if(!empty(trim($_POST['list_name'])) && !empty(trim($_POST['list_id']))){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $list_name = filter_input(INPUT_POST, "list_name", FILTER_SANITIZE_STRING);
	    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_STRING);
	    $userid = $_SESSION['userid'];

	    $sql1 = "SELECT id FROM lists WHERE name=:name";
	    $query1 = $conn->prepare($sql1);
	    $query1->bindParam(':name', $list_name, PDO::PARAM_STR);
	    $query1->execute();
	    $count1 = $query1->rowCount();

	    if($count1 == 0){
	    	$sql2 = "UPDATE lists SET name=:name WHERE id=:list_id AND userid=:userid";
		    $query2 = $conn->prepare($sql2);
		    $query2->bindParam(':name', $list_name, PDO::PARAM_STR);
		    $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
		    $query2->bindParam(':list_id', $list_id, PDO::PARAM_INT);
		    $query2->execute();
	    	$count2 = $query2->rowCount();

	    	if($count2 > 0){
	    		$response['status'] = 1;
				$response['msg'] = 'List updated successfully';
	    	} else {
	    		$response['status'] = 0;
				$response['msg'] = 'unable to update list';
	    	}
	    } else {
	    	$response['status'] = 0;
			$response['msg'] = 'List name already exists';
	    }
	} else {
		$response['status'] = 0;
		$response['msg'] = 'Please provide list name';
	}
} else {
	$response['status'] = 0;
	$response['msg'] = 'session expired';
}

echo json_encode($response);

?>