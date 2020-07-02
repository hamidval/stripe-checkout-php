<?php  

// Product Details  
// Minimum amount is $0.50 US  
$productName = "PNAME";  
$productID = "DP12345";  
$productPrice = "not needed"; 
$currency = "gbp"; 
 
// Convert product price to cent 
// $stripeAmount = round($productPrice*100, 2); 
  
// Stripe API configuration   
define('STRIPE_API_KEY', 'TEST_KEY');  
define('STRIPE_PUBLISHABLE_KEY','PRIVATE_KEY');  
define('STRIPE_SUCCESS_URL', 'https://example.com/success.php'); 
define('STRIPE_CANCEL_URL', 'https://example.com/cancel.php'); 
   
