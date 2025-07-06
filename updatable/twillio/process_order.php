<?php
// /realtime/twillio/process_order.php

// Your order processing logic here...

// Now, call the WhatsApp script to send a notification
include __DIR__ . '/whatsapp_order_confirmation.php';
?>
