<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Website</title>
    <!-- Add your CSS links or stylesheets here -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
    // Common Elements
    include('components/connect.php'); // Database connection
   // include('header.php'); // Common header

 
    // Page Routing
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    switch ($page) {
        case 'about':
            include('about.php');
            break;
        case 'cart':
            include('cart.php');
            break;
        case 'category':
            include('category.php');
            break;
        case 'checkout':
            include('checkout.ejs');
            break;
        case 'contact':
            include('contact.php');
            break;
        case 'home':
            include('home.php');
            break;
        case 'orders':
            include('orders.php');
            break;
        case 'quick_view':
            include('quick_view.php');
            break;
        case 'search_page':
            include('search_page.php');
            break;
        case 'shop':
            include('shop.php');
            break;
        case 'update_user':
            include('update_user.php');
            break;
        case 'user_login':
            include('user_login.php');
            break;
        case 'user_register':
            include('user_register.php');
            break;
        case 'wishlist':
            include('wishlist.php');
            break;
		 case 'admin_accounts':
            include('admin/admin_accounts.php');
            break;
        case 'admin_login':
            include('admin/admin_login.php');
            break;
        case 'dashboard':
            include('admin/dashboard.php');
            break;
        case 'messages':
            include('admin/messages.php');
            break;
        case 'placed_orders':
            include('admin/placed_orders.php');
            break;
        case 'products':
            include('admin/products.php');
            break;
        case 'register_admin':
            include('admin/register_admin.php');
            break;
        case 'update_product':
            include('admin/update_product.php');
            break;
        case 'update_profile':
            include('admin/update_profile.php');
            break;
        case 'users_accounts':
            include('admin/users_accounts.php');
            break;
        default:
            include('404.php'); // Or any error page for invalid requests
            break;
    }

    // Common Elements
    include('components/wishlist_cart.php'); // Wishlist and Cart section

    // User or Admin Check for Logout
    if ($userType === 'admin') {
        include('components/admin_logout.php'); // Admin logout
    } else {
        include('components/user_logout.php'); // User logout
    }

?>
<!-- Displaying images from the project_images folder -->


</body>
</html>
