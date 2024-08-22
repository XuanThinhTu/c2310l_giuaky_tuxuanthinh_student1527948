<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author_name = $_POST['author_name'];
    $category_name = $_POST['category_name'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $quantity = $_POST['quantity'];

    // Update author if exists
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

    // Update book data
    $update_book = "UPDATE books SET title = ?, author_id = ?, category_name = ?, publisher = ?, publish_year = ?, quantity = ?
                    WHERE id = ?";
    $stmt = $conn->prepare($update_book);
    $stmt->bind_param("sisssii", $title, $author_id, $category_name, $publisher, $publish_year, $quantity, $id);

    if ($stmt->execute()) {
        echo "Book updated successfully.";
    } else {
        echo "Error updating book: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the book list
    header("Location: index.php");
} else {
    echo "Invalid request method.";
}
?>
