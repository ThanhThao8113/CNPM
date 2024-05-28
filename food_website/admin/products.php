<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Món đã có!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, description, image) VALUES(?,?,?,?,?)");
            $insert_product->execute([$name, $category, $price, $description, $image]);

            $message[] = 'Đã thêm món mới!';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:products.php');
}

$search_query = "";
$filter_category = "";

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $search_query = filter_var($search_query, FILTER_SANITIZE_STRING);
    $filter_category = $_POST['filter_category'];
    $filter_category = filter_var($filter_category, FILTER_SANITIZE_STRING);

    $query = "SELECT * FROM `products` WHERE name LIKE ?";
    $params = ['%' . $search_query . '%'];

    if (!empty($filter_category)) {
        $query .= " AND category = ?";
        $params[] = $filter_category;
    }

    $show_products = $conn->prepare($query);
    $show_products->execute($params);
} else {
    $show_products = $conn->prepare("SELECT * FROM `products`");
    $show_products->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Món</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        .product-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: center;
            border: 1px solid #ddd;
        }
        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 18px;
        }
        .product-table th {
            background-color: #f4f4f4;
        }
        .product-table img {
            max-width: 150px;
            height: auto;
        }
        .search-form {
            text-align: center;
            margin: 20px 0;
        }
        .search-form form {
            display: inline-block;
        }
        .search-form input[type="text"], .search-form select {
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .search-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Thêm món</h3>
        <input type="text" required placeholder="Nhập tên món" name="name" maxlength="100" class="box">
        <input type="number" min="0" max="9999999999" required placeholder="Nhập giá (VNĐ)" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
        <select name="category" class="box" required>
            <option value="" disabled selected>Loại đồ ăn--</option>
            <option value="Món chính">Món chính</option>
            <option value="Đồ ăn nhanh">Đồ ăn nhanh</option>
            <option value="Đồ uống">Đồ uống</option>
            <option value="Tráng miệng">Tráng miệng</option>
        </select>
        <textarea name="description" class="box" required placeholder="Nhập mô tả món" maxlength="500"></textarea>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="Thêm món" name="add_product" class="btn">
    </form>
</section>

<!-- add products section ends -->


<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">
    <table class="product-table">
      <!-- search products section starts -->

        <section class="search-form">
            <form action="" method="POST">
                <input type="text" name="search_query" placeholder="Tìm kiếm sản phẩm" value="<?= $search_query; ?>">
                <select name="filter_category">
                    <option value="" disabled selected>Loại đồ ăn --</option>
                    <option value="Món chính" <?= $filter_category == 'Món chính' ? 'selected' : ''; ?>>Món chính</option>
                    <option value="Đồ ăn nhanh" <?= $filter_category == 'Đồ ăn nhanh' ? 'selected' : ''; ?>>Đồ ăn nhanh</option>
                    <option value="Đồ uống" <?= $filter_category == 'Đồ uống' ? 'selected' : ''; ?>>Đồ uống</option>
                    <option value="Tráng miệng" <?= $filter_category == 'Tráng miệng' ? 'selected' : ''; ?>>Tráng miệng</option>
                </select>
                <input type="submit" name="search" value="Tìm kiếm">
            </form>
        </section>

<!-- search products section ends -->
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên món</th>
                <th>Loại</th>
                <th>Giá (VNĐ)</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" style="width: 100px;"></td>
                    <td><?= $fetch_products['name']; ?></td>
                    <td><?= $fetch_products['category']; ?></td>
                    <td><?= number_format($fetch_products['price']); ?> VNĐ</td>
                    <td><?= $fetch_products['description']; ?></td>
                    <td>
                        <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Cập nhật</a>
                        <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Xác nhận xóa món?');">Xóa</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="6" class="empty" style="border: 1px solid #ddd; padding: 8px;">Chưa có món được thêm!</td></tr>';
        }
        ?>
        </tbody>
    </table>
</section>

<!-- show products section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
