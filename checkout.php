<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};
/*
if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span>$<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         
         <div class="inputBox">
    <span>payment method :</span>
    <select name="method" class="box" id="paymentMethod" required>
        <option value="paypal">paypal</option>
    </select>
</div>

<!-- ... (your previous HTML code) ... -->
         
<script src="https://www.paypal.com/sdk/js?client-id=Ad0bOYnIXshhR1_LBFcf1rukmWx5Ndrn9yY9xwlaV8P08B3xbJFUhpDIvdA-JX_rO8CljsWSroSuymyG&currency=USD"></script> 
<script>
document.getElementById('paymentMethod').addEventListener('change', function() {
    var selectedPaymentMethod = this.value;
    if (selectedPaymentMethod === 'paypal') {
        loadPayPalButton();
        document.getElementById('place-order-button').style.display = 'none';
    } else {
        hidePayPalButton();
        document.getElementById('place-order-button').style.display = 'block';
    }
});

/*function loadPayPalButton() {
    document.getElementById('paypal-button-container').style.display = 'block';
    document.getElementById('paypal-button-container').style.width = '600px';

    // Check if the PayPal script is already loaded
    if (typeof paypal.Buttons === 'undefined') {
        // Load PayPal script
        var script = document.createElement('script');
        script.src = 'https://www.paypal.com/sdk/js?client-id=AWwI2rgGmZNyEGhQl2_yf4G4u79aXkqKw4At1VxOSMV1DFyR2jG9yPYP7xc7Ts5UOeuTjwLihSYDahD3&currency=USD';
        document.head.appendChild(script);
        script.onload = function() {
            renderPayPalButton();
        };
    } else {
        renderPayPalButton();
    }
}*/

const baseURL = {
  sandbox: "https://api.paypal.com",
};
PAYPAL_CLIENT_ID = 'Ad0bOYnIXshhR1_LBFcf1rukmWx5Ndrn9yY9xwlaV8P08B3xbJFUhpDIvdA-JX_rO8CljsWSroSuymyG'
PAYPAL_CLIENT_SECRET = 'EGaJjCHHecEG2dhGNvF8Q08OFwObzXRJbQuj1vAklvrmocLu9CeFC09oPhrCDlG1MXNocKOmlH1HtfeR'
async function generateAccessToken() {
  try {
    const auth = btoa(`${PAYPAL_CLIENT_ID}:${PAYPAL_CLIENT_SECRET}`);
    const response = await fetch(`${baseURL.sandbox}/v1/oauth2/token`, {
      method: "POST",
      body: "grant_type=client_credentials",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Authorization": `Basic ${auth}`,
      },
    });

    const data = await response.json();
    return data.access_token;
  } catch (error) {
    console.error("Failed to generate Access Token:", error);
  }
}

// create an order
async function createOrder() {
    return new Promise(async (resolve, reject) => {
        const purchaseAmount = "<?= $grand_total; ?>"; // Replace with the total amount from PHP
        const accessToken = await generateAccessToken(); // Ensure this function is defined and returns an access token

        const url = `${baseURL.sandbox}/v2/checkout/orders`; // Ensure baseURL is defined
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${accessToken}`,
                },
                body: JSON.stringify({
                    intent: "CAPTURE",
                    purchase_units: [
                        {
                            amount: {
                                currency_code: "USD",
                                value: purchaseAmount
                            },
                        },
                    ],
                    // Add additional configurations if needed
                }),
            });

            const data = await response.json();
            if (data.id) {
                resolve(data.id); // Resolve the promise with the order ID
            } else {
                reject('Failed to create order');
            }
        } catch (error) {
            console.error('Error creating order:', error);
            reject(error);
        }
    });
}

    

async function capturePayment(orderId) {
    const accessToken = await generateAccessToken(); // Ensure this function is defined
    const url = `${baseURL.sandbox}/v2/checkout/orders/${orderId}/capture`; // Ensure baseURL is defined
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
        },
    });
    const data = await response.json();
    return data;
}

function renderPayPalButton() {
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Set up the transaction
           return createOrder();
        },
        onApprove: function(data, actions) {
    // Capture the funds from the transaction
    return capturePayment(data.orderID).then(function(captureResult) {
        // Send the captureResult to the server
        return fetch('orders.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: '<?= $user_id; ?>', // Assuming $user_id is available in the PHP session
                paypalOrderId: captureResult.id,
                status: captureResult.status,
                payerName: captureResult.payer.name.surname,
                payerEmail: captureResult.payer.email_address,
                street: captureResult.purchase_units[0].shipping.address.address_line_1,
                state: captureResult.purchase_units[0].shipping.address.admin_area_1,
                city: captureResult.purchase_units[0].shipping.address.admin_area_2,
                country: captureResult.purchase_units[0].shipping.address.country_code,
                zip: captureResult.purchase_units[0].shipping.address.postal_code,
                totalAmount: '<?= $grand_total; ?>'
            })
        })
        .then(response => {
           
        // Redirect or handle the response data as needed
            window.location.href = "orders.php";
        })
   
    });
}
    }).render('#paypal-button-container');
}
renderPayPalButton();
</script>

<!-- ... (the rest of your HTML code) ... -->

      <div id="paypal-button-container" >

<script>
/*loadPayPalButton();
function hidePlaceOrderButton() {
    document.getElementById('place-order-placeholder').style.display = 'none';
}*/

function showPlaceOrderButton() {
    document.getElementById('place-order-placeholder').style.display = 'block';
}
function deletePayPalBlocks() {
    var paypalContainer = document.getElementById('paypal-button-container');
    while (paypalContainer.firstChild) {
        paypalContainer.removeChild(paypalContainer.firstChild);
    }
}
</script>
</div>
   </form>

</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>