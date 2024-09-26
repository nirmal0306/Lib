<?php
    session_start();
    
    include_once "database_connection.php";
    try {
        $database = new Database();
        $connection = $database->openConnection();
    }
    catch (PDOException $e) 
    {
        $e->getMessage();
    }



    if(isset($_POST['submit']))
    {

        $book_name=$_POST["book_name"];
        $author_name=$_POST["author_name"];
        $price=$_POST["price"];
        $quantity=$_POST["quantity"];
        $image=$_FILES['image']['name'];
        $image_path="images/".$image;
        
        $insert="insert into book(           
            book_name,
            author_name,
            price,
            quantity,
            book_image) 
            values (
                
            '$book_name',
            '$author_name',        
            '$price',
            '$quantity',
            '$image_path')";
        $query_prepare = $connection->prepare($insert);
        $query_run = $query_prepare->execute();
		
        if($query_run)
        {
            move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$_FILES["image"]["name"]);
            header('location:admin.php');
        }
        else
        {
            $SESSION['success']="Data not inserted";
            
        }
    }

    if(isset($_POST['update']))
    {
        $id=$_POST["editid"];
        $book_name=$_POST["book_name"];
        $author_name=$_POST["author_name"];
        $price=$_POST["price"];
        $quantity=$_POST["quantity"];
        $image=$_FILES['image']['name'];
        
        
        $stmt = $connection->prepare("SELECT * FROM book
        where book_id='$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($stmt->rowCount()>0)
            {
            foreach ($result as $row) 
            {    
                if($image==NULL)
                {
                    $image_path=$row['book_image'];
                }
                else
                { 
                    
                    unlink($row['book_image']);
                    $image_path="images/".$image;
                    
                }
            }
        }
        $update="UPDATE book SET 
        book_name='$book_name',
        author_name='$author_name',
        price='$price',
        quantity='$quantity',
        book_image='$image_path'
         where book_id='$id'";
         $prepare = $connection->prepare($update);
        $prepare->execute();
        
        
        if($prepare->rowCount() >0)
        {
	        move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$_FILES["image"]["name"]);
            header('location:admin.php');
          
        }
        else
        {
            
           header('location:admin.php');
        }

    }
    if(isset($_POST['delete']))
    {
        $id=$_POST["deleteid"];
    
        $stmt = $connection->prepare("SELECT * FROM book 
        where book_id='$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($stmt->rowCount()>0)
            {
            foreach ($result as $row) 
            {    
                if($row['book_image'])
                {
                    unlink($row['book_image']);
                    $delete="delete from book 
                    where book_id='$id'";
                    $prepare= $connection->prepare($delete);
                    $result=$prepare->execute();
                    if($result)
                    {
                        header('location:admin.php');
                    }
                    else
                    {
                        header('location:admin.php');
                    }
                }
                
            }
        }

       
       
    }
?>
        