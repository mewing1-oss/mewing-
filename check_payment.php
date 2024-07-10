<?php
$txn_id = $_GET['txn_id'];
$verified = false;

if (file_exists('valid_txns.txt')) {
    $valid_txns = file('valid_txns.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($txn_id, $valid_txns)) {
        $verified = true;
    }
}

header('Content-Type: application/json');
echo json_encode(['verified' => $verified]);
?>
