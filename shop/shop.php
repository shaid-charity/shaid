<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
	<style>
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


/* -------------------- BUILD REQUEST -------------------- */

/**
 * Create the request object.
 */
$request = new Types\GetSellerListRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config[$MODE]['userAuthToken'];

$request->Pagination = new Types\PaginationType();
$request->Pagination->EntriesPerPage = 10;
//$request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$request->StartTimeFrom = DateTime::createFromFormat('d/m/Y', '23/02/2018');
$request->StartTimeTo   = DateTime::createFromFormat('d/m/Y', '15/04/2018');

$request->DetailLevel[] = Enums\DetailLevelCodeType::C_ITEM_RETURN_DESCRIPTION;

$request->UserID = 'dhammatek';

$pageNum = 1;
$request->Pagination->PageNumber = $pageNum;


/* -------------------- SEND REQUEST -------------------- */

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
	echo "<ul>";
    foreach ($response->ItemArray->Item as $item) {
        printf(
            "<li>(%s) %s <a href=\"%s\">View item</a></li>",
            $item->ItemID,
            $item->Title,
            $item->ListingDetails->ViewItemURL
        );
    }
	echo "</ul>";
}
?>
	</ul>
</body>
</html>
