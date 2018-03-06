<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Book Review</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- custom -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
    <link rel="stylesheet" href="main.css">

</head>
<body>

<?php
// initialize variables
$book_id = null;
$book_title = null;
$book_genre = null;
$book_review = null;
$person_name = null;
$person_email = null;
$person_link = null;
$photo = null;

//check if we have a numeric book ID in the querystring
if ((!empty($_GET['book_id'])) && (is_numeric($_GET['book_id']))) {

    //if we do, store in a variable
    $book_id = $_GET['book_id'];

    //connect
    $conn = new PDO('mysql:host=localhost;dbname=books', 'root', '');

    //select all the data for the selected book
    $sql = "SELECT * FROM book_users WHERE book_id = :book_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd->execute();
    $books = $cmd->fetchAll();

    //store each value from the database into a variable
    foreach ($books as $book) {
        $book_title = $book['book_title'];
        $book_genre = $book['book_genre'];
        $book_review = $book['book_review'];
        $person_name = $book['person_name'];
		$person_email = $book['person_email'];
        $person_link = $book['person_link'];
        $photo = $book['photo'];
    }

    //disconnect
    $conn = null;
}
?>

<h1>Book Details</h1>

<a id="navigation" href="books.php" title="Book Listings">View Books</a>

<form enctype="multipart/form-data" action="save-book.php" method="post">
    <fieldset>
        <label for="book_title" class="col-sm-2 col-25">Title:</label>
        <input class="col-75" name="book_title" id="book_title" placeholder="Enter Book Here" 
               value="<?php echo $book_title; ?>" />
    </fieldset>
    <fieldset>
        <label for="book_genre" class="col-sm-2 col-25">Genre:</label>
        <input class="col-75" name="book_genre" id="book_genre" placeholder="Genre Here"
                type="text" 
               value="<?php echo $book_genre; ?>" />
    </fieldset>
    <fieldset>
        <label for="book_review" class="col-sm-2 col-25">Review:</label>
        <input class="col-75" name="book_review" id="book_review" placeholder="Review Here"
                type="text" 
               value="<?php echo $book_review; ?>" />
    </fieldset>
    <fieldset>
        <label for="person_name" class="col-sm-2 col-25">Your name:</label>
        <input class="col-75" name="person_name" id="person_name" placeholder="Name Here" 
               value="<?php echo $person_name; ?>" />
    </fieldset>
    <fieldset>
        <label for="person_email" class="col-sm-2 col-25">Your email:</label>
        <input class="col-75" name="person_email" id="person_email" placeholder="Email Here"  type="email"
               value="<?php echo $person_email; ?>" />
    </fieldset>
    <fieldset>
        <label for="person_link" class="col-sm-2 col-25">Where did you buy (URL):</label>
        <input class="col-75" name="person_link" id="person_link" placeholder="URL Here"  type="url"
               value="<?php echo $person_link; ?>" />
    </fieldset>
    <fieldset>
        <label for="photo" class="col-sm-2 col-25">Image:</label>
        <input class="col-75" name="photo" id="photo" placeholder="Photo Here"  type="file"
               value="<?php echo $photo; ?>" />
    </fieldset>
    <input name="book_id" id="book_id"
        type="hidden" value="<?php echo $book_id; ?>" />
        <div class="button_wrapper">
        <button  type='submit' name='submit' value='save' class="btn btn-primary col-sm-offset-2">Save</button>
</div>
</form>
</body>
</html>