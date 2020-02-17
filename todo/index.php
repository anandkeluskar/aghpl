<?php 
	session_start();
	$_SESSION['userid'] = 1;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo Application</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			margin: 0px;
			padding: 5px;
		}
	</style>
</head>
<body>
	<div style="padding: 20px;">
		<h3>Add List</h3>
		<input type="text" id="list_name">&nbsp;
		<input type="button" id="btn_add_list" value="Add List" class="btn-primary">
	</div>
	<hr>
	<div id="list_container" style="padding: 20px;" class="col-md-6 offset-md-3">
	</div>

	<div id="addListItemModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Add New List Item</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <input type="text" id="item_name" list_id="0">&nbsp;&nbsp;
	        <input type="button" id="btn_add_list_item" value="Add List Item">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<div id="editListItemModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Edit List Item</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <input type="text" id="edit_item_name" list_id="0" item_id="0" value="">&nbsp;&nbsp;
	        <input type="button" id="btn_edit_list_item" value="Save">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<div id="editListModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Edit List</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <input type="text" id="edit_list_name" list_id="0" value="">&nbsp;&nbsp;
	        <input type="button" id="btn_edit_list_name" value="Save">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			console.log("ready....");
			fetch_list();

			$("#btn_add_list").on('click', function(e){
				e.stopPropagation();

				var list_name = $("#list_name").val().trim();

				if(list_name != ''){
					$.ajax({
						url: 'api/crud/insert_list.php',
						data: {list_name:list_name},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							alert(data.msg);

							if(data.status == 1){
								$("#list_name").val('');
								fetch_list();
							}
						},
						error: function(err){
							console.log('add list error: ',err);
						}
					});
				} else {
					alert('Please enter valid list name');
				}
			});

			$("#btn_add_list_item").on('click', function(e){
				e.stopPropagation();

				var item_name = $("#item_name").val().trim();
				var list_id = $("#item_name").attr('list_id');

				if(list_name != ''){
					$.ajax({
						url: 'api/crud/insert_list_item.php',
						data: {list_id:list_id, item_name:item_name},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							if(data.status == 1){
								$("#addListItemModal").modal('hide');
								$("#item_name").val('');
								$("#item_name").attr('list_id', 0);
								fetch_list();
							} else {
								alert(data.msg);
							}
						},
						error: function(err){
							console.log('add list item error: ',err);
						}
					});
				} else {
					alert('Please enter valid list item name');
				}
			});

			$("#btn_edit_list_item").on('click', function(e){
				e.stopPropagation();

				var item_name = $("#edit_item_name").val().trim();
				var list_id = $("#edit_item_name").attr('list_id');
				var item_id = $("#edit_item_name").attr('item_id');

				if(item_name != ''){
					$.ajax({
						url: 'api/crud/update_list_item.php',
						data: {list_id:list_id, item_id:item_id, item_name:item_name},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							if(data.status == 1){
								$("#editListItemModal").modal('hide');
								fetch_list();
							} else {
								alert(data.msg);
							}
						},
						error: function(err){
							console.log('edit list item error: ',err);
						}
					});
				} else {
					alert('Please enter valid list item name');
				}
			});

			$("#btn_edit_list_name").on('click', function(e){
				e.stopPropagation();

				var list_name = $("#edit_list_name").val().trim();
				var list_id = $("#edit_list_name").attr('list_id');

				if(list_name != ''){
					$.ajax({
						url: 'api/crud/update_list.php',
						data: {list_id:list_id, list_name:list_name},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							if(data.status == 1){
								$("#editListModal").modal('hide');
								fetch_list();
							} else {
								alert(data.msg);
							}
						},
						error: function(err){
							console.log('edit list name error: ',err);
						}
					});
				} else {
					alert('Please enter valid list name');
				}
			});
		});

		function fetch_list(){
			$.ajax({
				url: 'api/json/fetch_lists.php',
				dataType: 'json',
				success: function(data){ console.log(data);
					if(data.status == 1){
						var list_html = '';
						var lists = data.lists;
						var chk = '';
						var disabled = '';
						for(var key1 in lists){
							list_html += `<div class="card">
											<div class="card-header">
												${lists[key1].list_name}
												<a class="btn btn-danger float-right" style="margin-right: 10px;" onclick="deleteList(${lists[key1].list_id})">Delete List</a>
												<a class="btn btn-warning float-right" style="margin-right: 10px;"onclick="showEditListModal(${lists[key1].list_id},'${lists[key1].list_name}')">Edit List</a>&nbsp;
												<a class="btn btn-primary float-right" style="margin-right: 10px;"onclick="showAddListItemModal(${lists[key1].list_id})">Add Item</a>
											</div>
											<div class="card-body">`;

								if(lists[key1].hasOwnProperty('list_items')){
									list_html += `<ul class="list-group list-group-flush">`;

									for(var key2 in lists[key1].list_items){
										if(lists[key1].list_items[key2].item_status == 1){
											chk = 'checked';
											disabled = 'disabled';
										}else{
											chk = '';
											disabled = '';
										}
										list_html += `<li class="list-group-item">
								                        <label class="checkbox">
								                            <input type="checkbox" ${chk} ${disabled}  onchange="markCompleted(${lists[key1].list_id},${lists[key1].list_items[key2].item_id},'${lists[key1].list_items[key2].item_name}', this)">
								                            <span class="default"></span>
								                        </label>
								                        ${lists[key1].list_items[key2].item_name}
								                        <a class="btn btn-danger float-right" style="margin-right: 10px;"onclick="deleteListItem(${lists[key1].list_id},${lists[key1].list_items[key2].item_id})">Delete</a>
								                        <a class="btn btn-warning float-right" style="margin-right: 10px;"onclick="editListItem(${lists[key1].list_id},${lists[key1].list_items[key2].item_id},'${lists[key1].list_items[key2].item_name}')">Edit</a>
								                    </li>`;
									}

									list_html += `</ul>`;
								} else {
									list_html += `No list items available`;
								}

							list_html += `</div></div><br>`;

							$('#list_container').html(list_html);
						}
					} else {
						alert(data.msg);
					}
				},
				error: function(err){
					console.log('fetch list error: ',err);
				}
			});
		}

		function showAddListItemModal(list_id){
			$("#item_name").attr('list_id', list_id);
			$("#addListItemModal").modal('show');
		}

		function showEditListModal(list_id, list_name){
			$("#edit_list_name").attr('list_id', list_id);
			$("#edit_list_name").val(list_name);
			$("#editListModal").modal('show');
		}

		function editListItem(list_id, item_id, item_name){
			$("#edit_item_name").attr('list_id', list_id);
			$("#edit_item_name").attr('item_id', item_id);
			$("#edit_item_name").val(item_name);
			$("#editListItemModal").modal('show');
		}

		function deleteListItem(list_id, item_id){
			if(list_id != null, item_id != null){
				if(confirm('Are you sure, you want to delete this list item?')){
					$.ajax({
						url: 'api/crud/delete_list_item.php',
						data: {list_id:list_id, item_id:item_id},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							alert(data.msg);

							if(data.status == 1){
								fetch_list();
							}
						},
						error: function(err){
							console.log('delete list item error: ',err);
						}
					});
				}
			}
		}

		function deleteList(list_id){
			if(list_id != null){
				if(confirm('Are you sure, you want to delete this list?')){
					$.ajax({
						url: 'api/crud/delete_list.php',
						data: {list_id:list_id},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							alert(data.msg);

							if(data.status == 1){
								fetch_list();
							}
						},
						error: function(err){
							console.log('delete list error: ',err);
						}
					});
				}
			}
		}

		function markCompleted(list_id, item_id, item_name, elem){
			if(list_id != null && item_id != null){
				var is_completed = elem.checked ? 1:0;
				var complete_txt = is_completed ? 'complete':'incomplete';

				if(confirm('Are you sure, you want to mark this as '+ complete_txt +'?')){
					$.ajax({
						url: 'api/crud/mark_list_item_completed.php',
						data: {list_id:list_id,item_id:item_id,is_completed:is_completed},
						type: 'POST',
						dataType: 'json',
						success: function(data){
							alert(data.msg);

							if(data.status == 1){
								fetch_list();
							}
						},
						error: function(err){
							console.log('delete list error: ',err);
						}
					});
				}
			}
		}
	</script>
</body>
</html>