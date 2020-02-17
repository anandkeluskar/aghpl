<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
	if(!empty(trim($_POST['list_id']))){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_STRING);
	    $userid = $_SESSION['userid'];

    	$sql2 = "DELETE FROM lists WHERE id=:list_id AND userid=:userid";
	    $query2 = $conn->prepare($sql2);
	    $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
	    $query2->bindParam(':list_id', $list_id, PDO::PARAM_INT);
	    $query2->execute();
    	$count2 = $query2->rowCount();

    	if($count2 > 0){
    		$response['status'] = 1;
			$response['msg'] = 'List deleted successfully';
    	} else {
    		$response['status'] = 0;
			$response['msg'] = 'unable to delete the list';
    	}
	} else {
		$response['status'] = 0;
		$response['msg'] = 'Please provide list id';
	}
} else {
	$response['status'] = 0;
	$response['msg'] = 'session expired';
}

echo json_encode($response);

?>