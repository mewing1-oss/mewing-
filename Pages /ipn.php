<?php
// PayPal IPN PHP script

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cert/cacert.pem');

$res = curl_exec($ch);
curl_close($ch);

if (strcmp($res, "VERIFIED") == 0) {
    $item_name = $_POST['item_name'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];

    // تحقق من حالة الدفع
    if ($payment_status == "Completed") {
        // تحقق من مبلغ الدفع والعملة
        if ($payment_amount == "2.00" && $payment_currency == "USD") {
            // تحقق من البريد الإلكتروني للمستلم
            if ($receiver_email == "yassinelamachi16@gmail.com") {
                // احفظ التفاصيل في قاعدة البيانات أو قم بأي إجراء مطلوب
                // يمكن للمستخدم الآن تنزيل الملف
                // عرض رابط التحميل
                header("Location: https://mewing1-oss.github.io/mewing-/download.html");
                exit();
            }
        }
    }
} else if (strcmp($res, "INVALID") == 0) {
    // المعاملة غير صالحة
}
?>
