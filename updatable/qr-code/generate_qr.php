<?php
// Include the QR Code library
include 'phpqrcode/qrlib.php';

// Function to generate a QR code and return it as a string
function generateQRCodeAsString($link)
{
    // Generate QR code as string
    ob_start(); // Start output buffering
    QRcode::png($link, null, QR_ECLEVEL_L, 5, 0); // Generate QR code (change parameters as needed)
    $imageString = base64_encode(ob_get_contents()); // Get QR code image content
    ob_end_clean(); // End output buffering

    return $imageString;
}
?>
    