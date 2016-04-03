<?php

// The following code extracts the dates from the database and stores them in the $jsonClosingVals array.
//------------------------------------------------------------------------------------------------------------------------------------------
$str = file_get_contents("https://www.quandl.com/api/v3/datasets/WIKI/AAPL.json");
$json = json_decode($str, true); //array size 1
//var_dump($json);


$jsonObject = $json["dataset"]; // array size 21
$jsonDatasetArray = $jsonObject["data"]; //array size 8872
$jsonDataArray;  //elpes us extract the 8872 arrays of size 13 which are contained inside $jsonDatasetArray
$jsonClosingVals = array(); //this will store our closing prices only


/** This forloops only prints out the values we need, it does not store them in an array.
for($i = 0; $i < count($jsonDatasetArray); $i++) {
	$jsonDataArray = $jsonDatasetArray[$i]; //array size 13
	echo "Date: $jsonDataArray[0], " . "Closing Price: $jsonDataArray[11] \n";
}
*/

for($i = 0; $i < count($jsonDatasetArray); $i++) {
	$jsonDataArray = $jsonDatasetArray[$i]; //array size 13
	$jsonClosingVals[] =$jsonDataArray[11]; //assignment of closing prices only
}

/**
for($i = 0; $i < count($jsonClosingVals); $i++) {
	echo $jsonClosingVals[$i] . " \n"; 			//this loop is to verify that all items were transfered
}
*/


//The following code below predicts the next day closing price using $jsonCLosingVals as the input
//------------------------------------------------------------------------------------------------------------------------------------------


	
	//Takes in an array of previous prices ordered from oldest to newest.
	//Returns predicted tomorrow price within the error: 10% margin 50% of the time.
	//Returns -1 if there was a problem with the input.
	//This function uses the linear regression technique based on previous price points.
	function predictNextPrice($previousPrices) {
		$prediction = -1; $sum_x = 0; $sum_y = 0; $sum_xy = 0; $sum_xx = 0;
		$count = count($previousPrices);
		if($count <= 0) {echo "Error: Previous prices are empty."; return -1;}
		if($count < 30) echo "Warning: Prediction may not be accurate (less than 30 inputs).<br>";
		
		for($i = 0; $i < $count; $i++) {
			if(!is_numeric($previousPrices[$i])) {echo "Error: One of the inputs was not a number."; break;}
			$sum_x += $i;
			$sum_y += $previousPrices[$i];
			$xx = $i * $i;
			$xy = $i * $previousPrices[$i];
			$sum_xx += $xx;
			$sum_xy += $xy;
		}
		
		$slope = ($count * $sum_xy - $sum_x * $sum_y) / ($count * $sum_xx - $sum_xx);
		$intercept = ($sum_y - $slope * $sum_x) / $count;
		/**
		$prediction = $intercept + $slope * ($count+1);
		return $prediction;
		*/

		//^ the above comented code will not work because the prediction equation used is in the form of y = mx + b
		//However, tommorrow's predicted price cannot be a function of "count + 1" because actual stock prices are not 
		//a function of an abitrary number we give each day.
		//Tommorrows stock price prediction is formulated as such: prediction = yesterdaysPrice(1 + m)^t
		// where m is the slope calculated above and t is just 1 so we get prediction = yesterdaysPrice(1+m)
		

		$yesterdaysPrice = $previousPrices[0]; //the pprevious day is always at position 0 in the array
		$prediction = $yesterdaysPrice * (1 + $slope);
		echo "slope: " . $slope . "<br>" . "count: " . $count . "<br>"  . "yesterdaysprice: " . $yesterdaysPrice . "<br>" . "prediction: " . $prediction . "<br><br>";

		return $prediction;

	}
	
	echo "Next-day price prediction: " . predictNextPrice($jsonClosingVals) . "<br>";
	
	
	//Debug:
	foreach($jsonClosingVals as $element) {
		echo "element: " . $element . "<br>";
	}
	


?>

