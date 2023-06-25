<?php
  include_once "connection.php";
  // include_once "upload files/proses_up.php";

  $sql = "SELECT * FROM menu_name";
  $result = mysqli_query($conn, $sql);


  $sql_cart = "SELECT * FROM cart";
  $all_cart = $conn-> query($sql_cart);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Healthy Food</title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,600&family=Quicksand&display=swap"
      rel="stylesheet"
    />

    <!-- my style -->
    <link rel="stylesheet" href="style.css" />

    <!-- feather icons -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="https://unpkg.com/feather-icons"></script>
    
  </head>
  
  <body>
    <!-- navbar start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo"><span>Healthy</span>Food</a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#menu">Menu</a>
        <a href="#contact">Contact us</a>
        <a href="nama kel.html" target="_blank">About us</a>
        <a href="upload.php">Upload</a>
      </div>

      <div class="navbar-extra">
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="cart.php" id="shopping-cart"><i data-feather="shopping-cart"></i><span class="badge"><?php echo mysqli_num_rows($all_cart); ?></span></a>
        <a href="#" id="hamburg-menu"><i data-feather="menu"></i></a>
      </div>

      <!-- search form start -->
      <div class="search-form">
        <input type="search" id="search-box" placeholder="Search here...">
        <label for="serach-box">
          <i data-feather="search"></i>
        </label>
      </div>
      <!-- search form end -->

    </nav>
    <!-- navbar end -->

    <!-- hero section start -->
    <section class="hero" id="home">
        <main class="content">
            <h1>Let's change to a healthy lifestyle with</h1>
            <h1><span>Healthy</span>Food</h1>
            <!-- <p>Lorem ipsum dolor sit amet.</p>
            <a href="#" class="cta">Beli sekarang</a> -->
        </main>
    </section>
    <!-- hero section end -->

    <!-- menu section start -->
    <section id="menu" class="menu">
      <h2>Menu</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
      <?php
          while($row = mysqli_fetch_assoc($result)){
            ?>
      <div class="row">
        <div class="menu-card">
              <img src="<?php echo $row["menu_image"]; ?>" alt="menu" class="menu-card-img">
              <h3 class="menu-card-title" ><?php echo $row["menuname"]; ?></h3>
              <div class="star">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
              <p class="menu-card-price">IDR <?php echo $row["price"]; ?></p>
              <button class="cta" data-id="<?php echo $row["menu_id"]; ?>">Buy now</button>
            </div>
          </div>
          <?php
          }
          ?>
    </section>
    <!-- menu section end-->


    <!-- kontak section start -->
    <section id="contact" class="contact">
      <h2>Contact us</h2>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
      <div class="row">
        <p><img src="img/contact.jpg" alt="contact" class="image"></p>
        <form action="">
            <div class="input-group">
              <i data-feather="user"></i>
              <input type="text" placeholder="username">
              <label for="user"></i></label>
            </div>
            <div class="input-group">
              <i data-feather="mail"></i>
              <input type="text" placeholder="email">
            </div>
            <div class="input-group">
              <i data-feather="phone"></i>
              <input type="text" placeholder="No. Hp">
            </div>
            <div>
              <a href="#" type="submit" class="btn">Kirim Pesan</a>
            </div>
          </form>
        </div>

    </section>


    <!-- kontak section end -->

    <!-- fotter start -->
    <footer>
      <div class="socials">
        <a href="#"><i data-feather="instagram"></i></a>
        <a href="https://twitter.com/intent/tweet?url=[URL]&text=[TEXT]" target="_blank"><i data-feather="twitter"></i></a>
        <a href="https://www.facebook.com/sharer.php?u=https://www.healthyfood.com&t=Check%20out%20this%20awesome%20website" target="_blank"><i data-feather="facebook"></i></a>
      </div>

      <div class="links">
        <a href="#home">Home</a>
        <a href="#menu">Menu</a>
        <a href="#contact">Contact us</a>
        <a href="nama kel.html" target="_blank">About us</a>
      </div>
      
      <div class="credit">
        <p>Copyright &copy; 2023 - Pemrograman Web. All Rights Reserved.</p>
      </div>
    </footer>
    <!-- fotter end -->
    
    <!-- feather icons -->
    <script>
      feather.replace();
    </script>
    
    <!-- script -->
    <script src="javascript.js"></script>
    
    <script>
      var menu_id = document.getElementsByClassName("cta");
      for(var i = 0; i<menu_id.length; i++) {
        menu_id[i].addEventListener("click", function(event) {
          var target = event.target;
          var id = target.getAttribute("data-id");
          var xml = new XMLHttpRequest();
          xml.onreadystatechange = function() {
              if(this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                target.innerHTML = data.in_cart;
                document.getElementsByClassName("badge").innerHTML = data.num_cart + 1;
              }
          }
          xml.open("GET", "connection.php?id="+id, true);
          xml.send();
        })
      }
    </script>
  </body>
  
</html>
