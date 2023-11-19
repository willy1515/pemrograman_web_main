<?php
require './config/db.php';

if(isset($_POST['submit'])){
    if(!isset($_POST['id'])) {
        die('ID produk tidak ditemukan.');
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];

    $randomFilename = time().'-'.md5(rand()).'-'.$image;

    $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/pemweb/upload/'.$randomFilename;

    $upload = move_uploaded_file($tempImage,$uploadPath);

    if($upload) {
        mysqli_query($db_connect,"UPDATE products SET name='$name', price='$price', image='/upload/$randomFilename' WHERE id=$id");
        echo "berhasil upload";
        header('location:show.php'); // Pindahkan baris ini ke sini
    } else {
        echo "gagal upload";
    }
}

if(!isset($_GET['id'])) {
    die('ID produk tidak ditemukan.');
}

$id = $_GET['id'];
$result = mysqli_query($db_connect, "SELECT * FROM products WHERE id=$id");

if(!$result) {
    die('Query gagal: ' . mysqli_error($db_connect));
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <form action="edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$product['id'];?>">
        <label>Nama produk:</label><br>
        <input type="text" name="name" value="<?=$product['name'];?>"><br>
        <label>Harga:</label><br>
        <input type="text" name="price" value="<?=$product['price'];?>"><br>
        <label>Gambar produk:</label><br>
        <input type="file" name="image"><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
