<?php 
    require_once "connection.php";

    $sql_cart = "SELECT * FROM cart";
    $all_cart = $conn-> query($sql_cart);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In cart produtcs</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <main>
        <h1><?php echo mysqli_num_rows($all_cart); ?> Items</h1>
        <hr>
        <?php
            $totalPrice = 0;
            while($row_cart = mysqli_fetch_assoc($all_cart)) {
                $sql = "SELECT * FROM menu_name WHERE menu_id=" .$row_cart["menu_id"];
                $all_menu = $conn->query($sql);
                while($row = mysqli_fetch_assoc($all_menu)) {
                    $totalPrice += $row["price"];
        ?>  
        <div class="card">
            <div class="images">
                <img src="<?php echo $row["menu_image"]; ?>" alt="">
            </div>
            
            <div class="caption">
                <p class="menu_name"><?php echo $row["menuname"]; ?></p>
                <p class="rate">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                </p>
                <p class="price">IDR <?php echo $row["price"]; ?></p>
                <button class="remove" data-id="<?php echo $row["menu_id"] ?>">Remove from Cart</button>

            </div>
        </div>
        <?php
            }
        }
        ?>
        <div class="total">
            <p class="price">IDR <?php echo $totalPrice; ?></p>
            <button class="print-struk" onclick="printStruk()">Print Struk</button>
        </div>
    </main>

    
    <!-- feather icons -->
    <script>
      feather.replace();
    </script>
    

    <script>
        var remove = document.getElementsByClassName("remove");
        for(var i = 0; i<remove.length; i++) {
            remove[i].addEventListener("click", function(event) {
                var target = event.target;
                var cart_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status === 200) {
                        target.innerHTML = this.responseText;
                        target.style.opacity = .3;  
                    }
                }
                xml.open("GET", "connection.php?cart_id="+cart_id, true);
                xml.send();
            })
        }

        function updateTotalPrice() {
            var totalPriceElement = document.getElementById("totalPrice");
            var totalPrice = parseInt(totalPriceElement.innerText);
            var removedPrice = // Harga item yang dihapus (sesuaikan sesuai kebutuhan)
            totalPrice -= removedPrice;
            totalPriceElement.innerText = totalPrice;
        }

        // function printStruk() {
        // // Kode untuk mencetak struk
        //     window.print();
        // }


        function printStruk() {
            // Mengambil elemen-elemen yang ingin dicetak
            var items = document.querySelectorAll(".card");
            var totalPriceElement = document.querySelector(".total .price");

            // Membuat tampilan cetak
            var printContent = "<h2>Struk Pembelian</h2>";
            printContent += "<hr>";
            printContent += "<h3>Item yang Dibeli:</h3>";

            // Menambahkan setiap item ke tampilan cetak
            for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    var menuName = item.querySelector(".menu_name").innerText;
                    var price = item.querySelector(".price").innerText;
                    printContent += "<p>" + menuName + " - " + price + "</p>";
            }

            // Menambahkan total harga ke tampilan cetak
            var totalPrice = totalPriceElement.innerText;
            printContent += "<h3>Total Harga:</h3>";
            printContent += "<p>" + totalPrice + "</p>";

            // Membuka jendela baru untuk tampilan cetak
            var printWindow = window.open("", "_blank");
            printWindow.document.open();
            printWindow.document.write("<html><head><title>Struk Pembelian</title></head><body>" + printContent + "</body></html>");
            printWindow.document.close();
}
    </script>
</body>
</html>