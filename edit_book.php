<?php include 'db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>
    <?php
    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];

        // Fetch book details
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $book = $result->fetch_assoc();
        } else {
            echo "Book not found.";
            exit;
        }
    } else {
        echo "Invalid book ID.";
        exit;
    }
    ?>

    <form action="update_book.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br><br>

        <label>Author:</label>
        <input type="text" name="author_name" value="<?php echo $book['author_name']; ?>" required><br><br>

        <label>Category:</label>
        <select name="category_id" required>
            <option value="">Select a category</option>
            <?php
            // Fetch categories from the database
            $sql = "SELECT id, category_name FROM categories";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = $row['id'] == $book['category_id'] ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['category_name']}</option>";
                }
            } else {
                echo "<option value=''>No categories available</option>";
            }
            ?>
        </select>
        <br><br>

        <label>Publisher:</label>
        <input type="text" name="publisher" value="<?php echo $book['publisher']; ?>" required><br><br>

        <label>Publish Year:</label>
        <input type="number" name="publish_year" value="<?php echo $book['publish_year']; ?>" required><br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $book['quantity']; ?>" required><br><br>

        <button type="submit">Update Book</button>
    </form>
</body>
</html>
