<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->boot();

use App\Models\Order;

$order = Order::first();
if ($order) {
    $order->update(['payment_status' => 'terkonfirmasi']);
    echo "Order payment status updated to terkonfirmasi for order ID: " . $order->id . "\n";
} else {
    echo "No orders found\n";
}
