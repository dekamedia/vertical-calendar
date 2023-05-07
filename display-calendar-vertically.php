<?php
//get list of date in a month
function get_data($input_month = false, $input_year = false){
	if(!$input_month) $input_month = date('m');
	if(!$input_year) $input_year = date('Y');
	
	$out = false;
	$day_start = 1;
	$day_end = date('t', strtotime( $input_year . '-' . $input_month . '-01' ));
	for($i = $day_start; $i <= $day_end; $i++){
		$date_int = strtotime( $input_year . '-' . $input_month . '-' . $i );
		$out[] = [
					'int' => $date_int,
					'str' => date('Y-m-d', $date_int),
					'day' => $i,
					'month' => $input_month,
					'year' => $input_year,
					'day_code' => date('w', $date_int),
					'day_name' => date('l', $date_int),
				 ];
	}
	return $out;
}

//display calendar vertically 
function display_vertically($arr){
	if(!is_array($arr)) return false;
	
	$num_cols = 5; //number of columns (maximum 5 weeks in a month)
	$num_rows= 7; //number of rows (number of days in a week)

	//header ie. May 2023
	$header = date('F Y', $arr[0]['int']);
	$header_days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	
	//output start
	$out = '<table border="1">';

	//main header
	$out .= '<caption>'. $header .'</caption>';
	
	//init date output
	$td = false;
	for($row = 0; $row < $num_rows; $row++){
		for($col = 0; $col < $num_cols; $col++){
			$td[$row][$col] = false;
		}
	}

	//start to fill the date
	$col = 0;
	foreach($arr as $index => $r){
		$the_col = $col;
		$the_row = $r['day_code'];
		$td[$the_row][$the_col] = $r['day'];
		
		if($the_row == $num_rows - 1){
			$col++;
		}
	}

	//output data
	for($row = 0; $row < $num_rows; $row++){
		$out .= '<tr>';
		for($col = 0; $col < $num_cols; $col++){
			//insert weekdays name at first column
			if($col == 0) $out .= '<th>' . $header_days[$row] . '</th>';
			
			//data
			$out .= '<td>' . $td[$row][$col] . '</td>';
		}
		$out .= '</tr>';
	}

	//output end
	$out .= '</table>';
	
	return $out;
}

$arr = get_data(11, 2022);
echo display_vertically($arr);
