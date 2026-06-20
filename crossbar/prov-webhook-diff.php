$kazoo = new KazooCrossbarClient("https://<crossbar-url>:443", "API-Key")

$result_acc =  $kazoo->getAccountDetails($account_id);

$result_dev = $kazoo->getDeviceDetails($account_id, $device_id);
