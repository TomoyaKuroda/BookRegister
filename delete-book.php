<?php ob_start();  // start the output buffer

// read the selected book_id from the url's querystring using GET
$book_id = $_GET['book_id'];

// if book_id is a number
if (is_numeric($book_id)) {

    // connect
    $conn = new PDO('mysql:host=localhost;dbname=books', 'root', '');

    // write and run the delete query
    $sql = "DELETE FROM book_users WHERE book_id = :book_id";

    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd->execute();

    // disconnect
    $conn = null;

    // redirect back to books.php
    header('location:books.php');
}

// clear the output buffer
ob_flush();
?>