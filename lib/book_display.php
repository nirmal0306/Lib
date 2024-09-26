<?php

session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
echo $user_name;
if(!isset($user_id)){
   header('location:login_form_with_cookies.php');
};

if(isset($_GET['logout'])){
   unset($_SESSION['user_id']);
   unset($_SESSION['user_name']);
   session_destroy();
   header('location:login_form_with_cookies.php');
};

include_once "database_connection.php";

try {
        $database = new Database();
        $connection = $database->openConnection();
    } 
    catch (PDOException $e) 
    {
        $e->getMessage();
    }
?>



<?php
// Check to make sure the id parameter is specified in the URL
//echo $_GET['id'];
if (isset($_GET['book_id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $connection->prepare('SELECT * FROM book 
        WHERE book_id = :book_id');
    $stmt->execute([":book_id" => $_GET['book_id']]);
    // Fetch the product from the database and return the result as an Array
    
    
    // Fetch the product from the database and return the result as an Array
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $stmt->rowCount();
    // Check if the product exists (array is not empty)
    if (!$book) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Book does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Book does not exist!');
}
?>




<!DOCTYPE html>
<html>
   <head>


<style>
body{
    background-image:url(pexels-huỳnh-đạt-2177482.jpg);
    background-size:cover;
}
</style>
      <meta charset="utf-8">
      <title>book</title>
      <link href="style1.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
   </head>
   <body>
   <center>
   <div style="border:solid;color:black;padding:10px;width:40%;background-color:rgb(0,0,0,0.6);" >
        <header>
            <div class="content-wrapper">
                <h1>Book Purchase</h1>
                <nav>
                    <a href="index.html">Home</a>
                    <a href="book_list.php?page=books">Books</a>
                </nav>
                <div class="link-icons">
                    <a href="">
                  <i class="fas fa-shopping-cart"></i>
               </a>
                </div>
            </div>
        </header>
        <main>


        
   <div class="product content-wrapper" style="color:grey;"><b>
    <img src="<?php echo $book['book_image']?>" width="150" height="150" alt="<?php echo $book['book_image']?>">
    <div>
        <h4 class="name">Book Name : <?php echo $book['book_name']?></h4>
        <h4 class="author">By <?php echo $book['author_name']?></h4?>
        <span class="price"><br>Price :
            &dollar;<?php echo $book['price']?>
            
        </span>
        <form action="cart.php" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$book['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="book_id" value="<?=$book['book_id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        
    </div></b>
</div>





         </main>
        <footer>
            <div class="content-wrapper" style="color:grey;">
                <p>&copy; <?=date('Y')?>, Book Purchase</p>
            </div>
        </footer>
</div>
</center>
    </body>
</html>





       