<?php

require_once("functions.class.php");

$query_db = new functions;
$query_db->searchFunds();
$query_db->getAllFunds();
@$query_db->formatOutput();

?>