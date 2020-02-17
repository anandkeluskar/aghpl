<?php

$str = '';
$n = 12;		//assign default value

/* check for user input and assign value */
if(isset($_GET['n']) && !empty($_GET['n']) && is_numeric($_GET['n'])){
	$n = $_GET['n'];
}

/* Initialize matrix array and start and end rows and columns values */
$matrix = array();
$start_row = $start_col = 0;
$last_row = $last_col = $n-1;

/* loop until center point of matrix is reached where start row will be greater than end row */
while($start_row < $last_row){
	/* for loop to mark forward and downward pattern */
	for ($i = $start_row; $i < $last_row; $i++) {
		$matrix[$start_row][$i] = 1;
		$matrix[$i][$last_col] = 1;
	}

	$start_row += 2;
	$start_col += 2;

	/* for loop to mark upward and backward pattern */
	for ($i = $last_row; $i >= $start_row; $i--) {
		$matrix[$last_row][$i] = 1;
		$matrix[$i][$start_col-1] = 1;
	}

	$last_row -= 2;
	$last_col -= 2;
}

/* loop to print the matrix array */
for ($i = 0; $i < $n; $i++) {
  	for ($j = 0; $j < $n; $j++) {
  		if(!empty($matrix[$i][$j])){
  			$str .= '*';
  		} else {
  			$str .= '&nbsp;&nbsp;';
  		}
	}
	$str .= '<br>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Spiral Pattern</title>
</head>
<body>
	<h3>Spiral Pattern</h3>
	<form method="GET">
		<input type="number" name="n" value="<?php echo $n; ?>"> &nbsp;
		<input type="submit" name="btn_generate" value="Generate Pattern">
	</form>
	<br><hr><br>
	<div id="spiral_container">
		<?php echo $str; ?>
	</div>
</body>
</html>