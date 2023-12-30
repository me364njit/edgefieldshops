<?php

include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['add_to_wishlist'])) {

    if ($user_id == '') {
        header('location:user_login.php');
        exit;
    } else {

        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_STRING);

        $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ?");
        $check_wishlist->execute([$pid, $user_id]);

        if ($check_wishlist->rowCount() > 0) {
            $message[] = 'Already added to wishlist!';
        } else {
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
            $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
            $message[] = 'Added to wishlist!';
        }
    }
}

if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:user_login.php');
        exit;
    } else {

        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_STRING);
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
        $check_cart->execute([$pid, $user_id]);

        if ($check_cart->rowCount() > 0) {
            $fetch_cart = $check_cart->fetch(PDO::FETCH_ASSOC);
            $cart_id = $fetch_cart['id'];
            $updated_qty = $fetch_cart['quantity'] + $qty;

            $update_cart = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
            $update_cart->execute([$updated_qty, $cart_id]);

            $message[] = 'Cart quantity updated!';
        } else {

            $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ?");
            $check_wishlist->execute([$pid, $user_id]);

            if ($check_wishlist->rowCount() > 0) {
                $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? AND user_id = ?");
                $delete_wishlist->execute([$pid, $user_id]);
            }

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);

            $message[] = 'Added to cart!';
        }
    }
}
$total_quantity = 0;
if ($user_id != '') {
    $query = $conn->prepare("SELECT SUM(quantity) AS total_quantity FROM `cart` WHERE user_id = ?");
    $query->execute([$user_id]);

    if ($query->rowCount() > 0) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $total_quantity = $row['total_quantity'];
    }
}

?>
