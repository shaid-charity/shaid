<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
	<style>
	</style>
</head>
<body>
	<?php

		/* -------------------- SETUP -------------------- */

		// Load ebay-sdk
		require './includes/lib/ebay-sdk/ebay-sdk-php-autoloader.php';

		// Load config
		$config = require './config.php';

		// Set mode to use with ebay-sdk
		$MODE = 'production';

		// Set user to view items of
		$USER = 'dhammatek';

		// The namespaces provided by the SDK.
		use \DTS\eBaySDK\Constants;
		use \DTS\eBaySDK\Trading\Services;
		use \DTS\eBaySDK\Trading\Types;
		use \DTS\eBaySDK\Trading\Enums;
		
		// Create the service object.
		$service = new Services\TradingService([
		    'credentials' => $config[$MODE]['credentials'],
		    'siteId'      => Constants\SiteIds::GB
		]);


		/* -------------------- BUILD REQUEST -------------------- */

		// Create the request object.
		$request = new Types\GetSellerListRequestType();

		// An user token is required when using the Trading service.
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config[$MODE]['userAuthToken'];

		// Set pagination info
		$request->Pagination = new Types\PaginationType();
		$request->Pagination->EntriesPerPage = 10;
		// $request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

		$request->StartTimeFrom = DateTime::createFromFormat('d/m/Y', '23/02/2018');
		$request->StartTimeTo   = DateTime::createFromFormat('d/m/Y', '15/04/2018');

		$request->DetailLevel[] = Enums\DetailLevelCodeType::C_ITEM_RETURN_DESCRIPTION;

		$request->UserID = $USER;

		// Page
		$pageNum = 1;
		if (isset($_GET["page"])) {
			$pageNum = intval(htmlspecialchars($_GET["page"]));

			// TODO: Validate page number
			// ...
		} else {
			echo "<p>[no page number set; displaying page 1]</p>";
		}
		$request->Pagination->PageNumber = $pageNum;


		/* -------------------- PARSE RESPONSE -------------------- */

		$response = $service->getSellerList($request);
		/**
		 * Output the result of calling the service operation.
		 */
		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        printf(
		            "%s: %s\n%s\n\n",
		            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		            $error->ShortMessage,
		            $error->LongMessage
		        );
		    }
		    die();
		}
		$totalPages = $response->PaginationResult->TotalNumberOfPages;
		echo "<h1>Results for page $pageNum of $totalPages</h1>";
		if ($response->Ack !== 'Failure') {

			// Display list of results from requested page
			echo "<ul>";
		    foreach ($response->ItemArray->Item as $item) {
		        printf(
		            "<li>(%s) %s <a href=\"%s\">View item</a>
		            <br>
		            	<img src=\"%s\" width=\"200\">
		            <br>
		            </li>",
		            $item->ItemID,
		            $item->Title,
		            $item->ListingDetails->ViewItemURL,
		            $item->PictureDetails->PictureURL[0]
		        );
		    }
			echo "</ul>";

			// Pagination to navigate pages
			echo "<ul>";
			echo "<li><a href=\"?page=" . ($pageNum - 1) . "\">Previous page</a></li>";
			echo "<li><a href=\"?page=" . ($pageNum + 1) . "\">Next page</a></li>";
			echo "</ul>";
		}
	?>
</body>
</html>
