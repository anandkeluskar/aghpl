<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
	if(!empty(trim($_POST['list_name']))){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $list_name = filter_input(INPUT_POST, "list_name", FILTER_SANITIZE_STRING);
	    $userid = $_SESSION['userid'];

	    $sql1 = "SELECT id FROM lists WHERE name=:name";
	    $query1 = $conn->prepare($sql1);
	    $query1->bindParam(':name', $list_name, PDO::PARAM_STR);
	    $query1->execute();
	    $count1 = $query1->rowCount();

	    if($count1 == 0){
	    	$sql2 = "INSERT INTO lists (`name`,`userid`) VALUES(:name,:userid)";
		    $query2 = $conn->prepare($sql2);
		    $query2->bindParam(':name', $list_name, PDO::PARAM_STR);
		    $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
		    $query2->execute();
	    	$list_id = $conn->lastInsertId();

	    	if($list_id > 0){
	    		$response['status'] = 1;
				$response['msg'] = 'List added successfully';
				$response['list_id'] = $list_id;
	    	} else {
	    		$response['status'] = 0;
				$response['msg'] = 'unable to create list';
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