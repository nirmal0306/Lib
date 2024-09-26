    <?php
session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
echo $user_name;
if(!isset($user_id)){
   header('location:login_form.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
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


<!DOCTYPE html>
<html>
   <head>
    <style>
body{
    background-image: url(background.jpg);
			background-size: cover;
}        
        </style>
      <meta charset="utf-8">
      <title>Home</title>
      <link href="style1.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
   </head>
   <body>
        <header>
         <a href="update_user_form.php"><button class="btn btn-primary"> Update Profie</button></a>
        <a href="book_list.php?logout=yes"><button class="btn btn-primary"> Logout</button></a>
        <!-- <a href="http://localhost/lib/login_user_form_handler.php"><button class="btn btn-primary"> Your data</button></a> -->

            <div class="content-wrapper">
                <h1>Book Purchase</h1>
                <nav>
                    <a href="index.html">Home</a>
                    <a href="book_list.php?page=books">Books</a>
                </nav>
                <div class="link-icons">
                    <a href="index.php?page=cart">
                  <i class="fas fa-shopping-cart"></i>
               </a>
                </div>
            </div>
        </header>
        <main>


        <?php
// Get the  added products
$limit = 2;
if (isset($_GET["page"] )) 
{
    $page  = $_GET["page"]; 
} 
else 
{
    $page=1; 
};
$record_index= ($page-1) * $limit; 

$stmt = $connection->prepare("SELECT * FROM book LIMIT $record_index, $limit");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo $stmt->rowCount();
?>

<div class="recentlyadded content-wrapper">
    <h2>Recently Added Books</h2>
    <div class="books">
        
    
        <?php foreach ($books as $book) { 
             ?>  <tr  style="padding:10px;margin-top:10px;"> 
        <a href="book_display.php?book_id=<?=$book['book_id']?>" class="books" style="color:black;">
        <td><img src="<?=$book['book_image']?>" width="250" height="250" alt="<?=$book['book_name']?>"></td>
            <span class="name">Name :
                <?=$book['book_name']?>
        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ,
        <span class="price">Price : 
                &dollar;<?=$book['price']?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
        </a></td></tr>
        <?php } ?>
        

        </table>

        
    </div>
</div>

<?php

echo "<ul class='pagination'>";

echo "<li><a href='book_list.php?page=".($page-1)."' class='button'>Previous</a></li>"; 
echo "<li><a href='book_list.php?page=".$page."'>".$page."</a></li>";
echo "<li><a href='book_list.php?page=".($page+1)."' class='button'>NEXT</a></li>";

echo"</ul>";               
   
?>




         </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; <?=date('Y')?>, Book Purchase </p>
            </div>
        </footer>
    </body>
</html>





       