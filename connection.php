<?php 
 
	$conn = mysqli_connect("localhost","root","","menu_product", 4306);
 
	// Check connection
	// if (mysqli_connect_errno()){
	// 	echo "Koneksi database gagal : " . mysqli_connect_error();
	// }else {
	// 	echo "koneksi berhasil";
	// }

	if(isset($_GET["id"])) {
		$menu_id = $_GET["id"];
		$sql ="SELECT * FROM cart WHERE menu_id = $menu_id";
		$result = $conn->query($sql);
		$total_cart = "SELECT * FROM cart";
		$total_cart_result = $conn->query($total_cart);
		$cart_num = mysqli_num_rows($total_cart_result);

			if(mysqli_num_rows($result) > 0) {
				$in_cart = "already in cart";

				echo json_encode(["num_cart" => $cart_num, "in_cart" => $in_cart]);
			}else {
				$insert = "INSERT INTO cart (menu_id) VALUES ($menu_id)";
				if($conn->query($insert) === true) {
					$in_cart = "added into cart";
					echo json_encode(["num_cart" => $cart_num, "in_cart" => $in_cart]);
				}else {
					echo "<script>alert('It doesn't insert')</script>";
		}
	}
}

if(isset($_GET["cart_id"])) {
	$menu_id = $_GET["cart_id"];
	$sql = "DELETE FROM cart WHERE menu_id=" .$menu_id;

	if($conn->query($sql) === TRUE) {
		echo "Removed from cart";
	}
}

?>