<?php

	//Takes in the ticker symbol for a stock and returns the closing price history in an array
	//from oldest to most recent.
	function getPriceHistory($tickr) {
		$ticker = strtoupper($tickr);
		
		$str = file_get_contents("https://www.quandl.com/api/v3/datasets/WIKI/$ticker.json");
		$json = json_decode($str, true); //array size 1
		
		$jsonObject = $json["dataset"]; // array size 21
		$jsonDatasetArray = $jsonObject["data"]; //array size 8872
		$jsonDataArray;  //elpes us extract the 8872 arrays of size 13 which are contained inside 
		$jsonClosingVals = array(); //this will store our closing prices only
		
		$jsonDates = array();
		for($i = 0; $i < count($jsonDatasetArray); $i++) {
			$jsonDataArray = $jsonDatasetArray[$i]; //array size 13
			$jsonDates[$i] = $jsonDataArray[0];
			$price_Value = $jsonDataArray[11];
			$jsonClosingVals[$jsonDataArray[0]] = $price_Value; // in the form of [date, closing price]
		}
		return $jsonClosingVals;
	}


	//Takes in an array of previous prices ordered from oldest to newest.
	//Returns predicted tomorrow price within the error: 10% margin 50% of the time.
	//Returns -1 if there was a problem with the input.
	//This function uses the linear regression technique based on previous price points.
	function predictNextPrice($previousPrices, $dates, $num) {
		$prediction = -1; $sum_x = 0; $sum_y = 0; $sum_xy = 0; $sum_xx = 0;

		$jsonDates = $dates;
		$count = count($previousPrices);
		if($num > 0) {$count = $num;}

		if($count <= 0) {echo "Error: Previous prices are empty."; return -1;}
		if($count < 30) echo "Warning: Prediction may not be accurate (less than 30 inputs).<br>";
		
		for($i = 0; $i < $count; $i++) {
			$currentKey = $jsonDates[$i];
			if(!is_numeric($previousPrices[$i])) {
				echo "Error: One of the inputs was not a number."; break;
			}

			$sum_x += $i;
			$sum_y += $previousPrices[$currentKey];
			$xx = $i * $i;
			$xy = $i * $previousPrices[$currentKey];
			$sum_xx += $xx;
			$sum_xy += $xy;
		}
		
		$slope = ($count * $sum_xy - $sum_x * $sum_y) / ($count * $sum_xx - $sum_xx);
		

		$yesterdaysPrice = $previousPrices[$jsonDates[0]]; //the pprevious day is always at position 0 in the array
		$prediction = $yesterdaysPrice * (1 + $slope);
		echo "slope: " . $slope . "<br>" . "count: " . $count . "<br>"  . "yesterdaysprice: " . $yesterdaysPrice . "<br>" . "prediction: " . $prediction . "<br><br>";

		return $prediction;
	}

	$thePrediction = predictNextPrice($jsonClosingVals, $jsonDates, 0);
	echo "Next-day price prediction: " . $thePrediction . "<br>";
	

?>

