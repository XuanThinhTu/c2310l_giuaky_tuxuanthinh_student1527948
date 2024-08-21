<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Delete the book
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "Book deleted successfully.";
    } else {
        echo "Error deleting book: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the book list
    header("Location: index.php");
} else {
    echo "Invalid book ID.";
}
?>
