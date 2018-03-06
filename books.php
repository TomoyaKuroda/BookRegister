<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Book Listings</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
    <link rel="stylesheet" href="main2.css">
</head>
<body>

<h1>Book</h1>

<a href="book.php" title="Add a Game">Add a New Book</a>

<?php
require_once('appvars.php');
// connect
$conn = new PDO('mysql:host=localhost;dbname=books', 'root', '');
$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// write the query to fetch the book data
$sql = "SELECT * FROM book_users ORDER BY book_title";

// run the query and store the results into memory
$cmd = $conn->prepare($sql);
$cmd -> execute();
$books = $cmd->fetchAll();

// start the table and add the headings
echo '<table class="table table-striped"><thead><th>Title</th><th>Genre</th>
    <th>Review</th><th>Reviewer\'s Name</th><th>Email</th><th>Link</th><th>Image</th></th><th>Edit</th><th>Delete</th></thead><tbody>';


/* loop through the data, creating a new table row for each book
and putting each value in a new column */
foreach($books as $book) {
    echo '<tr><td>' . $book['book_title'] . '</td>
        <td>' . $book['book_genre'] . '</td>
        <td>' . $book['book_review'] . '</td>
        <td>' . $book['person_name'] . '</td>
        <td>' . $book['person_email'] . '</td>
        <td>' . $book['person_link'] . '</td>
        <td><img src="' . GW_UPLOADPATH . $book['photo'] . '" alt="Book image" /></td>
        
		              
        <td><a href="book.php?book_id=' . $book['book_id'] . '">Edit</a></td>
        <td>
        <a href="delete-book.php?book_id=' . $book['book_id'] .
            '" onclick="return confirm(\'Are you sure?\');">
            Delete</a></td></tr>';
}

// close the table
echo '</tbody></table>';

// disconnect
$conn = null;
?>
</body>
</html>