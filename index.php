<html>

<?php 
// Include configuration file   
// Product Details  
// Minimum amount is $0.50 US  
require_once 'config.php';  



 


?>



<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="style.css" >
<body class="text-center">
<div class="formBox">

<!-- Display errors returned by checkout session -->
<div id="paymentResponse"></div>
	
<!-- Product details -->
<!-- <h2><?php echo $productName; ?></h2> -->



<div class="form">
    <h4 class='block'>Donation</h4>
    <input class="input  marg-input block form-control" id="donation" placeholder="£"/>
	<br />
    <button class="btn btn-info  margleft block custom" onchange="calculateFee">Calculate Fee</button>



	<div class="row" >
        <div class='col' ><h4>Convinience Fee:</h4></div> 
        <div class='col' id="fee">0</div>
    </div>
    
	<div class='row'>
        <div class="col" ><h4>Total:</h4> </div>
        <div class='col' id="total">0</div>
    </div>

    <div class='row'>
    <div class="col" id="buynow">
    <button class="stripe-button btn btn-success marg" id="payButton">Donate</button>
    </div>
    </div>


</div>


</div>
<script>
var buyBtn = document.getElementById('payButton');
var responseContainer = document.getElementById('paymentResponse');
var donation = document.getElementById('donation'); 
var total = document.getElementById('total');

var fee = document.getElementById('fee');

donation.onchange = function(){
	fee.innerHTML = (((donation.value/100)*1.5)+0.2).toFixed(2);
	total.innerHTML = ((donation.value*1)+(fee.innerHTML*1));
};



// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    return fetch("stripe_charge.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
			amount:((donation.value*100)+(fee.innerHTML*100)),
        }),
    }).then(function (result) {
        return result.json();
    });
};

// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
    }

    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

buyBtn.addEventListener("click", function (evt) {
	
	
	
    buyBtn.disabled = true;
    buyBtn.textContent = 'Please wait...';
    
    createCheckoutSession().then(function (data) {
        if(data.sessionId){
            stripe.redirectToCheckout({
                sessionId: data.sessionId,
            }).then(handleResult);
        }else{
            handleResult(data);
        }
    });
});
</script>
</body>
</html>