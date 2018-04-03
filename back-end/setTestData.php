<?php
require_once 'includes/settings.php';
require_once 'includes/config.php';

$f = new Friend($db, null, 'matthew.accounts@gmx.com', 'Matthew', 'Watson', 'Newsletter');
$f = new Friend($db, null, '1@test.com', 'Test Account', 'Num 1', 'Newsletter');
$f = new Friend($db, null, '2@test.com', 'Test Account', 'Num 2', 'Newsletter');
$f = new Friend($db, null, '3@test.com', 'Test Account', 'Num 3', 'Donor');
$f = new Friend($db, null, '4@test.com', 'Test Account', 'Num 4', 'Donor');
$f = new Friend($db, null, '5@test.com', 'Test Account', 'Num 5', 'Newsletter');
$f = new Friend($db, null, '6@test.com', 'Test Account', 'Num 6', 'Donor');
$f = new Friend($db, null, '7@test.com', 'Test Account', 'Num 7', 'Newsletter');
$f = new Friend($db, null, '8@test.com', 'Test Account', 'Num 8', 'Donor');
$f = new Friend($db, null, '9@test.com', 'Test Account', 'Num 9', 'Donor');
$f = new Friend($db, null, '10@test.com', 'Test Account', 'Num 10', 'Donor');
$f = new Friend($db, null, '11@test.com', 'Test Account', 'Num 11', 'Donor');
$f = new Friend($db, null, '12@test.com', 'Test Account', 'Num 12', 'Newsletter');

?>