<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
</head>
<body>
	<?php

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
		use \DTS\eBaySDK\Browse\Services;
		use \DTS\eBaySDK\Browse\Types;
		use \DTS\eBaySDK\Browse\Enums;
		/**
		 * Create the service object.
		 */
		$service = new Services\BrowseService([
		    'authorization' => $config['production']['oauthUserToken'],
		    'marketplaceId' => Constants\GlobalIds::GB
		]);
		/**
		 * Create the request object.
		 */
		$request = new Types\SearchForItemsRestRequest();
		/**
		 * Note how URI parameters are just properties on the request object.
		 */
		$request->q = 'Harry Potter';
		$request->sort = '-price';
		$request->limit = '10';
		$request->offset = '0';
		/**
		 * Send the request.
		 */
		$response = $service->searchForItems($request);
		/**
		 * Output the result of calling the service operation.
		 */
		printf("\nStatus Code: %s\n\n", $response->getStatusCode());
		if (isset($response->errors)) {
		    foreach ($response->errors as $error) {
		        printf(
		            "%s: %s\n%s\n\n",
		            $error->errorId,
		            $error->message,
		            $error->longMessage
		        );
		    }
		}
		if ($response->getStatusCode() === 200) {
		    foreach ($response->itemSummaries as $item) {
		        printf(
		            "(%s) %s: %s %.2f\n",
		            $item->itemId,
		            $item->title,
		            $item->price->currency,
		            $item->price->value
		        );
		    }
		}
	?>
</body>
</html>
