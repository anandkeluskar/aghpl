<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
	if(!empty(trim($_POST['list_id'])) && !empty(trim($_POST['item_id'])) && isset($_POST['is_completed'])){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_STRING);
	    $item_id = filter_input(INPUT_POST, "item_id", FILTER_SANITIZE_STRING);
	    $userid = $_SESSION['userid'];
	    $is_completed = (!empty($_POST['is_completed'])) ? '1' : '0';

    	$sql2 = "UPDATE list_items SET is_complete=:is_complete WHERE id=:item_id AND list_id=:list_id AND userid=:userid";
	    $query2 = $conn->prepare($sql2);
	    $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
	    $query2->bindParam(':list_id', $list_id, PDO::PARAM_INT);
	    $query2->bindParam(':item_id', $item_id, PDO::PARAM_INT);
	    $query2->bindParam(':is_complete', $is_completed, PDO::PARAM_STR);
	    $query2->execute();
    	$count2 = $query2->rowCount();

    	if($count2 > 0){
    		$response['status'] = 1;
			$response['msg'] = 'List item updated successfully';
    	} else {
    		$response['status'] = 0;
			$response['msg'] = 'unable to update item in the list';
    	}
	} else {
		$response['status'] = 0;
		$response['msg'] = 'Please provide list item id';
	}
} else {
	$response['status'] = 0;
	$response['msg'] = 'session expired';
}

echo json_encode($response);

?>