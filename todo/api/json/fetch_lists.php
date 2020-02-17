<?php

session_start();
$response = array();

if(!empty($_SESSION['userid'])){
		include('../common/cons.php');
	    $obj = new Connection();
	    $conn = $obj->getConnection();

	    $userid = $_SESSION['userid'];

	    $sql1 = "SELECT l.id list_id, l.name list_name, li.id item_id, li.name item_name, li.is_complete item_status FROM lists l LEFT JOIN list_items li ON li.list_id = l.id WHERE l.userid=:userid";
	    $query1 = $conn->prepare($sql1);
		$query1->bindParam(':userid', $userid, PDO::PARAM_INT);
		$query1->setFetchMode(PDO::FETCH_ASSOC);
	    $query1->execute();
	    $count1 = $query1->rowCount();

	    if($count1 > 0){
	    	$response['lists'] = array();

	    	foreach($query1 as $row){
	    		$response['lists'][$row['list_id']]['list_id'] = $row['list_id'];
	    		$response['lists'][$row['list_id']]['list_name'] = $row['list_name'];

	    		if(!empty($row['item_id'])){
	    			$response['lists'][$row['list_id']]['list_items'][$row['item_id']] = array('item_id'=>$row['item_id'],'item_name'=>$row['item_name'],'item_status'=>$row['item_status']);
	    		}
	    	}

	    	$response['status'] = 1;
			$response['msg'] = 'Item list fetched successfully';
	    } else {
	    	$response['status'] = 0;
			$response['msg'] = 'unable to fetch item list';
	    }
} else {
	$response['status'] = 0;
	$response['msg'] = 'session expired';
}

echo json_encode($response);

?>