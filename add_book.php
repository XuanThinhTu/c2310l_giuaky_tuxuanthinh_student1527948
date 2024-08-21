<?php include 'db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
</head>
<body>
    <h1>Add New Book</h1>
    <form action="add_book.php" method="POST">
        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Author:</label>
        <input type="text" name="author_name" required><br><br>

        <label>Category:</label>
        <select name="category_name" required>
            <option value="">Select a category</option>
            <?php
            // Fetching categories from the database
            $sql = "SELECT category_name FROM categories";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                }
            } else {
                echo "<option value=''>No categories available</option>";
            }
            ?>
        </select>
        <br><br>

        <label>Publisher:</label>
        <input type="text" name="publisher" required><br><br>

        <label>Publish Year:</label>
        <input type="number" name="publish_year" required><br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" required><br><br>

        <button type="submit">Add Book</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $author_name = $_POST['author_name'];
        $category_name = $_POST['category_name'];
        $publisher = $_POST['publisher'];
        $publish_year = $_POST['publish_year'];
        $quantity = $_POST['quantity'];

        // Insert author if not exists
        $author_check = "SELECT id FROM authors WHERE author_name = ?";
        $stmt = $conn->prepare($author_check);
        $stmt->bind_param("s", $author_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $insert_author = "INSERT INTO authors (author_name) VALUES (?)";
            $stmt = $conn->prepare($insert_author);
            $stmt->bind_param("s", $author_name);
            $stmt->execute();
            $author_id = $stmt->insert_id;
        } else {
            $author_row = $result->fetch_assoc();
            $author_id = $author_row['id'];
        }

        // Insert book data
        $insert_book = "INSERT INTO books (title, author_id, category_name, publisher, publish_year, quantity) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_book);
        $stmt->bind_param("sisssi", $title, $author_id, $category_name, $publisher, $publish_year, $quantity);

        if ($stmt->execute()) {
            echo "New book added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
    ?>

</body>
</html>
