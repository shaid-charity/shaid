<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="./style/blog.css" rel="stylesheet">
	<link href="./style/store.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/header.php');

		/* ----- EBAY SETUP ----- */

		// Load ebay-sdk
		require './includes/lib/ebay-sdk/ebay-sdk-php-autoloader.php';

		// Load config
		$config = require './config.php';

		// Set mode to use with ebay-sdk
		$MODE = 'production';

		// Set user to view items of
		$USER = 'sofas4less';

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


		/* ----- BUILD API REQUEST ----- */

		// Create the request object.
		$request = new Types\GetSellerListRequestType();

		// An user token is required when using the Trading service.
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $config[$MODE]['userAuthToken'];

		// Set pagination info
		$request->Pagination = new Types\PaginationType();
		$request->Pagination->EntriesPerPage = 10;
		// $request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

		$startDate = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
		// Do NOT modify - 120 days is the maximum range supported by the ebay sdk and despite what
		// the documentation says, a date range is a required parameter of GetSellerList.
		$startDate->modify('-120 days');
		$request->StartTimeFrom = $startDate;
		$request->StartTimeTo   = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));

		$request->DetailLevel[] = Enums\DetailLevelCodeType::C_ITEM_RETURN_DESCRIPTION;

		$request->UserID = $USER;

		// Set page number to load
		$pageNum = 1;
		if (isset($_GET["page"])) {
			$pageNum = intval(htmlspecialchars($_GET["page"]));

			// TODO: Validate page number
			// ...
		}
		$request->Pagination->PageNumber = $pageNum;


		/* ----- FETCH API RESPONSE ----- */

		$response = $service->getSellerList($request);
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="page-title">
							<h1>SHAID Store</h1>
						</div>
						<p>Below you can see all of the items we have for sale on our <a href="https://ebay.co.uk/usr/<?php echo $USER; ?>" target="_blank">eBay store</a>. By purchasing an item through our eBay store you are directly supporting SHAID.</p>
						<?php

							/**
							 * Output the result of calling the service operation.
							 */
							if (isset($response->Errors)) {
								/*
							    foreach ($response->Errors as $error) {
							        printf(
							            "%s: %s\n%s\n\n",
							            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
							            $error->ShortMessage,
							            $error->LongMessage
							        );
							    }
							    die();
							    */
								echo "<p>Error: Request to eBay failed.</p>";
							} elseif ($response->Ack !== 'Failure') {
								$totalPages = $response->PaginationResult->TotalNumberOfPages;

								echo "<ul class=\"products-results-list\">";
									foreach ($response->ItemArray->Item as $item) {
								        printf(
								            "<li class=\"product-result\">
									            <h2 class=\"product-result-title\">%s</h2>
									            <div class=\"product-result-image-container\"> 
									            	<div class=\"product-result-image\" style=\"background-image:url('%s');\"></div>
									            </div>
									            <a href=\"%s\" target=\"_blank\" class=\"button-dark product-result-button\">View on eBay</a>
								            </li>",
								            $item->Title,
								            $item->PictureDetails->PictureURL[0],
								            $item->ListingDetails->ViewItemURL
								        );
								    }
								echo "</ul>";

								// Pagination to navigate pages
								?>
								<nav>
									<ul class="pagination">
										<?php if ($pageNum > 1) { ?>
											<li><a href="?page=<?php echo ($pageNum - 1); ?>" class="button-dark button-smaller"><!--Previous-->&laquo;</a></li>
										<?php } ?>
										<li><a href="?page=<?php echo $pageNum; ?>" class="button-dark-filled button-smaller"><?php echo $pageNum; ?></a></li>
										<?php if ($pageNum < $totalPages) { ?>
											<li><a href="?page=<?php echo ($pageNum + 1); ?>" class="button-dark button-smaller"><!--Next-->&raquo;</a></li>
										<?php } ?>
									</ul>
								</nav>
								<?php
							} else {
								echo "<p>Error: Could not connect to Ebay.</p>";
							}
						?>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
