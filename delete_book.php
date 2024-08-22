<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        // If the delete operation was successful
        header("Location: index.php");
        exit(); // Ensure script execution stops after redirect
    } else {
        // If there was an error during deletion
        echo "Error deleting book: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid book ID.";
}
?>
