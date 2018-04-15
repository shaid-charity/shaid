<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
	<style>
	li {
		padding-bottom: 100px;
	}
	</style>
</head>
<body>
	<?php

		$MODE = 'production';

		/*
			REMOVE THESE LINES
		*/
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		/*
			REMOVE THESE LINES
		*/

		require './includes/lib/ebay-sdk/ebay-sdk-php-autoloader.php';

		$config = require './config.php';
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config[$MODE]['credentials'],
    'siteId'      => Constants\SiteIds::GB
]);

/**
 * Create the request object.
 */
$request = new Types\GetSellerListRequestType();
/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config[$MODE]['userAuthToken'];

//$request->Pagination = new Types\PaginationType();
//$request->Pagination->EntriesPerPage = 10;
//$request->Pagination->PageNumber = 1;

$request->Pagination = new Types\PaginationType();
$request->Pagination->EntriesPerPage = 10;
//$request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$request->StartTimeFrom = DateTime::createFromFormat('d/m/Y', '23/02/2018');
$request->StartTimeTo   = DateTime::createFromFormat('d/m/Y', '15/04/2018');

$request->DetailLevel[] = Enums\DetailLevelCodeType::C_ITEM_RETURN_DESCRIPTION;

$request->UserID = 'dhammatek';

echo "<ul>";

$pageNum = 1;

do {
    $request->Pagination->PageNumber = $pageNum;

	/**
	 * Send the request.
	 */
	$response = $service->getSellerList($request);
	/**
	 * Output the result of calling the service operation.
	 */
	echo "<li>";
	echo "<p>=== Results for page $pageNum ===</p>";
	if (isset($response->Errors)) {
	    foreach ($response->Errors as $error) {
	        printf(
	            "%s: %s\n%s\n\n",
	            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
	            $error->ShortMessage,
	            $error->LongMessage
	        );
	    }
	}
	if ($response->Ack !== 'Failure') {
        foreach ($response->ItemArray->Item as $item) {
            printf(
                "<p>(%s) %s <a href=\"%s\">View item</a></p>",
                $item->ItemID,
                $item->Title,
                $item->ListingDetails->ViewItemURL
            );
        }
    }
    echo "</li>";
    $pageNum += 1;
} while (false === true && $pageNum <= $response->PaginationResult->TotalNumberOfPages);
echo "</ul>";
?>
	</ul>
</body>
</html>
