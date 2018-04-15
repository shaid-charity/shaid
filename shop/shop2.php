<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
</head>
<body>
	<?php
		error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

		// API request variables
		$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
		$version = '1.0.0';  // API version supported by your application
		$appid = 'CalebHam-SHAIDSto-PRD-2787d0107-02f8ef26';  // Replace with your own AppID
		$globalid = 'EBAY-US';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
		$query = 'harry potter';  // You may want to supply your own query
		$safequery = urlencode($query);  // Make the query URL-friendly

		// Create a PHP array of the item filters you want to use in your request
		$filterarray =
		  array(
		    array(
		    'name' => 'MaxPrice',
		    'value' => '25',
		    'paramName' => 'Currency',
		    'paramValue' => 'USD'),
		    array(
		    'name' => 'FreeShippingOnly',
		    'value' => 'true',
		    'paramName' => '',
		    'paramValue' => ''),
		    array(
		    'name' => 'ListingType',
		    'value' => array('AuctionWithBIN','FixedPrice'),
		    'paramName' => '',
		    'paramValue' => ''),
		  );

		 // Generates an indexed URL snippet from the array of item filters
		function buildURLArray ($filterarray) {
		  global $urlfilter;
		  global $i;
		  // Iterate through each filter in the array
		  foreach($filterarray as $itemfilter) {
		    // Iterate through each key in the filter
		    foreach ($itemfilter as $key =>$value) {
		      if(is_array($value)) {
		        foreach($value as $j => $content) { // Index the key for each value
		          $urlfilter .= "&itemFilter($i).$key($j)=$content";
		        }
		      }
		      else {
		        if($value != "") {
		          $urlfilter .= "&itemFilter($i).$key=$value";
		        }
		      }
		    }
		    $i++;
		  }
		  return "$urlfilter";
		} // End of buildURLArray function

		$i = '0';  // Initialize the item filter index to 0

		// Build the indexed item filter URL snippet
		buildURLArray($filterarray);

		// Construct the findItemsByKeywords HTTP GET call
		$apicall = "$endpoint?";
		$apicall .= "OPERATION-NAME=findItemsByKeywords";
		$apicall .= "&SERVICE-VERSION=$version";
		$apicall .= "&SECURITY-APPNAME=$appid";
		$apicall .= "&GLOBAL-ID=$globalid";
		$apicall .= "&keywords=$safequery";
		$apicall .= "&paginationInput.entriesPerPage=3";
		$apicall .= "$urlfilter";

		// Load the call and capture the document returned by eBay API
		$resp = simplexml_load_file($apicall);

		// Check to see if the request was successful, else print an error
		if ($resp->ack == "Success") {
		  $results = '';
		  // If the response was loaded, parse it and build links
		  foreach($resp->searchResult->item as $item) {
		    $pic   = $item->galleryURL;
		    $link  = $item->viewItemURL;
		    $title = $item->title;

		    // For each SearchResultItem node, build a link and append it to $results
		    $results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td></tr>";
		  }
		}
		// If the response does not indicate 'Success,' print an error
		else {
		  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
		  $results .= "AppID for the Production environment.</h3>";
		}

	?>
</body>
</html>
