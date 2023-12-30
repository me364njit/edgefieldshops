<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/pic-6.png" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Elevate Your Style, Define Your Elegance.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Reasons to Choose us</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <p>Affordable Premium Products</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Wide Range of Products</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Exceptional Customer Service</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Exclusive Deals and Offers</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Expertise and Curation</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Ease of Use and Navigation</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Social Proof and Testimonials</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Fast and Reliable Shipping</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Sustainability and Ethical Practices</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

      <div class="swiper-slide slide">
      <p>Informative Content and Guides</p>
         <div class=>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
            <i class=></i>
         </div>
         <h3></h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>