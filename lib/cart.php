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
        $con = $database->openConnection();
    }  
    catch (PDOException $e) 
    {
        $e->getMessage();
    }
    ?>





<?php
  



if (isset($_POST['book_id'], $_POST['quantity'])) {
  
    $book_id = (int)$_POST['book_id'];
    $quantity = (int)$_POST['quantity'];
  
    $stmt = $con->prepare('SELECT* FROM book 
        WHERE book_id = :book_id');
    $stmt->execute([":book_id" => $_POST['book_id']]);
   
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if ($book && $quantity > 0) {
    
        if (!$_SESSION['cart']) {
            $_SESSION['cart'][$book_id] =0;
        }
        if(array_key_exists($book_id, $_SESSION['cart'])) {
        
            $_SESSION['cart'][$book_id] += $quantity;
        } else {
          
            $_SESSION['cart'][$book_id] = $quantity;
        }
    }
    
    header('location:cart.php');
    exit;
}






$books_in_cart = $_SESSION['cart'];
$keys = array_keys($books_in_cart);
$subtotal = 0.00;



if ($books_in_cart) {


    $array_to_question_marks = implode(',', array_fill(0, count($books_in_cart), '?'));
    
    echo "<br>". $array_to_question_marks;
    $stmt = $con->prepare('SELECT * FROM book WHERE 
    book_id IN (' . $array_to_question_marks . ')');
    $keys = array_keys($books_in_cart);



    $stmt->execute($keys);
    
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($books as $book) {
      
        $subtotal += (float)$book['price'] * (int)$books_in_cart[$book['book_id']];
    }
}

if (isset($_GET['remove']) && isset($_SESSION['cart']) 
        && isset($_SESSION['cart'][$_GET['remove']])) 
{
    echo $_SESSION['cart'][$_GET['remove']];
    
    unset($_SESSION['cart'][$_GET['remove']]);
    
    
    header('location: cart.php');
    exit;
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) 
        && !empty($_SESSION['cart'])) {
    
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}


?>







<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Place Order</title>
      <link href="style1.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootpxstrap.min.js"></script>

    <style>
        body{
            background-image: url(pexels-tirachard-kumtanom-733857.jpg);
            background-size: cover;
        }

        th,td {
            padding: 15px;
        }

        .content-wrapper{
            padding: 3px;
            margin:12px;
        }
    </style>
   </head>
   <body>
    <center>
   <div style="border:solid;color:black;padding:10px;width:40%;background-color:rgb(0,0,0,0.3);" >
        <header>
            <div class="content-wrapper" >
            
                <h1>Book Cart System</h1>
                <nav>
                    <a href="http://localhost/lib/book_list.php" style="color:lightyellow;">Home</a>&nbsp;&nbsp;&nbsp;
                    <a href="http://localhost/lib/book_list.php" style="color:lightyellow">Books</a><br>
                </nav>
                <div class="link-icons">
                    <a href="cart.php?" style="color:lightyellow">
                  <i class="fas fa-shopping-cart"></i>
                  <span><?php echo count($_SESSION['cart'])?></span>
               </a>
                </div>
            </div>
        </header>
        <main>


        



<div class="cart content-wrapper">
    
    <h1>Book purchase Cart</h1>
    <form action="feedback.php" method="post">
        <table style="color:black;">
            <thead>
                <tr>
                    <td style="padding:10px;">Book</td>
                    <td >Book Name</td>

                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($books)) { ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no Books added in your Purchase List</td>
                </tr>
                <?php } else { ?>
                <?php foreach ($books as $book) { ?>
                <tr>
                    &nbsp;<td class="img">
                        <a href="book_display.php?book_id=<?php echo $book['book_id']?>">
                        <img src="<?php echo $book['book_image']?>" width="100" height="100" 
                        alt="<?php echo $book['book_name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="book_display.php?book_id=<?php echo $book['book_id']?>" style="color:black;">
                            <?php echo $book['book_name']?></a>
                        <br>
                        
                        
                    </td>
                    </td>
                    <td class="price">&dollar;<?php echo $book['price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?php $book['book_id']?>" value="<?php echo $books_in_cart[$book['book_id']]?>" min="1" max="<?php $book['quantity']?>" style="width:40px;font-size:15px" placeholder="Quantity" disabled>
                    </td></br>
                    
                    <td class="price">&dollar;<?php echo $book['price'] * $books_in_cart[$book['book_id']]?></td>
                </tr>
                <tr>
                        <td>
                        <a href="cart.php?remove=<?php echo $book['book_id']?>" class="remove" style="color:red;">Remove</a>
                </td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?php echo $subtotal?></span>
        </div>
        <div class="buttons">
            
            <input type="submit" value="Place Order" naFme="placeorder">
        </div>
    </form>
</div>

            




         </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; <?=date('Y')?>, Book Purchase</p>
            </div>
        </footer>
                </div> 
                </center>  
    </body>
</html>





       