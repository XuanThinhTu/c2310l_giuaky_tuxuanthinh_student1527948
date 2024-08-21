<?php include 'db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
</head>
<body>
    <h1>Book List</h1>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Publisher</th>
            <th>Publish Year</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php
        // Cập nhật truy vấn SQL để lấy tên danh mục từ bảng categories
        $sql = "SELECT books.id, books.title, authors.author_name, categories.category_name, books.publisher, books.publish_year, books.quantity
                FROM books
                JOIN authors ON books.author_id = authors.id
                JOIN categories ON books.category_id = categories.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['author_name']}</td>
                        <td>{$row['category_name']}</td>
                        <td>{$row['publisher']}</td>
                        <td>{$row['publish_year']}</td>
                        <td>{$row['quantity']}</td>
                        <td>
                            <a href='edit_book.php?id={$row['id']}'>Edit</a> |
                            <a href='delete_book.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this book?');\">Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No books found</td></tr>";
        }
        ?>
    </table>

    <br><a href="add_book.php">Add New Book</a>

    <?php $conn->close(); ?>
</body>
</html>
