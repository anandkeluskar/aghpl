<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
	if(!empty(trim($_POST['item_name'])) && !empty(trim($_POST['list_id']))){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $item_name = filter_input(INPUT_POST, "item_name", FILTER_SANITIZE_STRING);
	    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_STRING);
	    $userid = $_SESSION['userid'];

	    $sql1 = "SELECT id FROM list_items WHERE name=:name AND list_id=:list_id";
	    $query1 = $conn->prepare($sql1);
	    $query1->bindParam(':name', $item_name, PDO::PARAM_STR);
		$query1->bindParam(':list_id', $list_id, PDO::PARAM_INT);
	    $query1->execute();
	    $count1 = $query1->rowCount();

	    if($count1 == 0){
	    	$sql2 = "INSERT INTO list_items (`list_id`,`name`,`userid`) VALUES(:list_id,:name,:userid)";
		    $query2 = $conn->prepare($sql2);
		    $query2->bindParam(':name', $item_name, PDO::PARAM_STR);
		    $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
		    $query2->bindParam(':list_id', $list_id, PDO::PARAM_INT);
		    $query2->execute();
	    	$item_id = $conn->lastInsertId();

	    	if($list_id > 0){
	    		$response['status'] = 1;
				$response['msg'] = 'List item added successfully';
				$response['item_id'] = $item_id;
	    	} else {
	    		$response['status'] = 0;
				$response['msg'] = 'unable to add item to the list';
	    	}
	    } else {
	    	$response['status'] = 0;
			$response['msg'] = 'List item name already exists';
	    }
	} else {
		$response['status'] = 0;
		$response['msg'] = 'Please provide list item name';
	}
} else {
	$response['status'] = 0;
	$response['msg'] = 'session expired';
}

echo json_encode($response);

?>