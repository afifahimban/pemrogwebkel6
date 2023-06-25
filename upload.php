<?php
    require_once "connection.php";

    if(isset($_POST["submit"])) {
        $menuname = $conn->real_escape_string($_POST["menuname"]);
        $price = $conn->real_escape_string($_POST["price"]);

        // for upload images
        $upload_dir = "uploads/"; //storage  
        $menu_image = $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_file = $upload_dir.basename($_FILES["imageUpload"]["name"]);
        $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION)); //used to detected the image format
        $check = $_FILES["imageUpload"]["size"]; //detect size
        $upload_ok = 0;

        if(file_exists($upload_file)) {
            echo '<script>alert("The file already exist")</script>';
            $upload_ok = 0;
        }else {
            $upload_ok = 1;
            if($check !== false) {
                $upload_ok = 1;
                if($imageType == 'jpg' || $imageType == 'png' || $imageType == 'jpeg' || $imageType == 'gif') {
                    $upload_ok = 1;
                }else {
                    echo '<script>alert("please change the image format")</script>';
                }
            }else {
                echo '<script>alert("The photo size is 0 please change the photo ")</script>';
                $upload_ok = 0;
            }
        }
        if($upload_ok == 0) {
            echo '<script>alert("sorry your file is doesn`t uploaded. Please try again")</script>';
        }else {
            if($menuname != "" && $price != "") {
                move_uploaded_file($_FILES["imageUpload"]["tmp_name"],$upload_file);
                
                $sql = "INSERT INTO menu_name (menuname, price, menu_image) VALUES ('$menuname', '$price', '$menu_image')";

                if($conn->query($sql) === TRUE) {
                    echo "<script>alert('your menu uploaded successfully')</script>";
                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
    <section id="upload_container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="menuname" id="menuname" placeholder="Menu" required>
            <input type="number" name="price" id="price" placeholder="Price" required>
            <input type="file" name="imageUpload" id="imageUpload" required hidden>
            <button id="choose" onclick="upload();">Choose Image</button>
            <input type="submit" value="Upload" name="submit">
        </form>
    </section>

    <script>
        var menuname = document.getElementById("menuname");
        var price = document.getElementById("price");
        var choose = document.getElementById("choose");
        var uploadImage = document.getElementById("imageUpload");

        function upload(){
            uploadImage.click();
        }
        uploadImage.addEventListener("change", function(){
            var file = this.files[0];
            if(menuname.value == ""){
                menuname.value = file.name;
            }
            choose.innerHTML = "You can change("+file.name+") picture";
        })
    </script>
</body>
</html>