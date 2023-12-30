<?php
include 'components/connect.php';
session_start();

// Check if the user is logged in
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON POST body and decode it
    $requestData = file_get_contents('php://input');
    $orderData = json_decode($requestData, true);

    // Validate the required fields
    if (isset($orderData['paypalOrderId'], $orderData['status'], $orderData['payerName'], $orderData['payerEmail'], $orderData['street'], $orderData['state'], $orderData['city'], $orderData['country'], $orderData['zip'], $orderData['totalAmount'])) {
        $paypalOrderId = $orderData['paypalOrderId'];
        $status = $orderData['status'];
        $payerName = $orderData['payerName'];
        $payerEmail = $orderData['payerEmail'];
        $street = $orderData['street'];
        $state = $orderData['state'];
        $city = $orderData['city'];
        $country = $orderData['country'];
        $zip = $orderData['zip'];
        $totalAmount = $orderData['totalAmount'];

        // Prepare and execute the SQL query
        try {
            $insertOrder = $conn->prepare("INSERT INTO `orders` (user_id, paypalOrderId, status, payerName, payerEmail, street, state, city, country, zip, totalAmount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insertOrder->execute([$_SESSION['user_id'], $paypalOrderId, $status, $payerName, $payerEmail, $street, $state, $city, $country, $zip, $totalAmount]);
            $message[] = 'order placed successfully!';
            echo json_encode(['success' => true, 'message' => 'Order processed successfully']);
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            $message[] = 'order placed successfully!';
        } catch (PDOException $e) {
            // Handle any errors during database operation
            error_log('Database error: ' . $e->getMessage());
            echo json_encode(['failed' => false, 'message' => 'Invalid order data']);
        }
    } else {
        // Missing required fields
        echo json_encode(['failed' => false, 'message' => 'Invalid order data']);
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>id : <span><?= $fetch_orders['user_id']; ?></span></p>
      <p>order-id : <span><?= $fetch_orders['paypalOrderId']; ?></span></p>
      <p>status : <span><?= $fetch_orders['status']; ?></span></p>
      <p>name : <span><?= $fetch_orders['payerName']; ?></span></p>
      <p>email : <span><?= $fetch_orders['payerEmail']; ?></span></p>
      <p>street : <span><?= $fetch_orders['street']; ?></span></p>
      <p>state : <span><?= $fetch_orders['state']; ?></span></p>
      <p>city : <span><?= $fetch_orders['city']; ?></span></p>
      <p>country : <span><?= $fetch_orders['country']; ?></span></p>
      <p>zip : <span><?= $fetch_orders['zip']; ?></span></p>
      <p>total Paid : <span><?= $fetch_orders['totalAmount']; ?></span></p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>
   </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
