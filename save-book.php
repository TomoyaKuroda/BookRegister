<!DOCTYPE html>
<html>
<head>
    <title>Saving your Book...</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main3.css">
</head>
<body>


<?php
require_once('appvars.php');
// store the form inputs in variables
if (isset($_POST['submit'])) {
$book_title = $_POST['book_title'];
$book_genre = $_POST['book_genre'];
$book_review = $_POST['book_review'];
$person_name = $_POST['person_name'];
$person_email = $_POST['person_email'];
$person_link = $_POST['person_link'];
$photo = $_FILES['photo']['name'];
$photo_type = $_FILES['photo']['type'];
$photo_size = $_FILES['photo']['size']; 
// add book_id in case we are editing
$book_id = $_POST['book_id'];

// create a flag to track the completion status of the form
$ok = true;

// do our form validation before saving
if (empty($book_title)) {
    echo 'Title is required<br />';
    $ok = false;
}

if (empty($book_genre)) {
    echo 'Genre is required<br />';
    $ok = false;
}

if (empty($book_review)) {
    echo 'Review is required<br />';
    $ok = false;
}

if (empty($person_name)) {
    echo 'Reviewer name is required<br />';
    $ok = false;
}

if (empty($person_email)) {
    echo 'Reviewer\'s email is required<br />';
    $ok = false;
}

if (empty($person_link)) {
    echo 'Link is required<br />';
    $ok = false;
}

if (empty($photo)) {
    echo 'Photo is required<br />';
    $ok = false;
}



if (!((($photo_type == 'image/gif') || ($photo_type == 'image/jpeg') || ($photo_type == 'image/pjpeg') || ($photo_type == 'image/png'))
          && ($photo_size > 0) && ($photo_size <= GW_MAXFILESIZE))){
    echo 'The photo must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.<br />';
    $ok = false;
          }

echo '<section>
<p><a href="book.php" title="Add a Game">Add a New Book</a></p>
<p><a href="books.php" title="Game Listings">View Books</a></p>
</section>
<br />';

if ($_FILES['photo']['error'] == 0){
	$target = GW_UPLOADPATH . $photo;
}
// save ONLY IF the form is complete
if ($ok&&move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {

    // connecting to the database
    $conn = new PDO('mysql:host=localhost;dbname=books', 'root', '');

    // if we have an existing book_id, run an update
    if (!empty($book_id)) {
        $sql = "UPDATE book_users SET book_title = :book_title, book_genre = :book_genre,
          book_review = :book_review, person_name = :person_name , person_email = :person_email 
          , person_link = :person_link , photo = :photo WHERE book_id = :book_id";
    }
    else {
        // set up an SQL command to save the new book
        $sql = "INSERT INTO book_users (book_title, book_genre, book_review, person_name, person_email, person_link, photo)
          VALUES (:book_title, :book_genre, :book_review, :person_name, :person_email, :person_link, :photo)";
    }

    // set up a command object
    $cmd = $conn->prepare($sql);

    // fill the placeholders with the input variables
    $cmd->bindParam(':book_title', $book_title);
    $cmd->bindParam(':book_genre', $book_genre);
    $cmd->bindParam(':book_review', $book_review);
    $cmd->bindParam(':person_name', $person_name);
    $cmd->bindParam(':person_email', $person_email);
    $cmd->bindParam(':person_link', $person_link);
    $cmd->bindParam(':photo', $photo);
    // add the book_id param if updating
    if (!empty($book_id)) {
        $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    }

    // execute the insert
    $cmd->execute();

    // show message
    
    //echo "Book Saved";
    echo '<script type="text/javascript">alert("Book Saved!");</script>';
    // disconnecting
    $conn = null;

    }
        // Try to delete the temporary screen shot image file
        @unlink($_FILES['screenshot']['tmp_name']);
}
?>
</body>
</html>