<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin operations</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<style>
body{
    background-image: url(web.jpg);
			background-size: cover;
}        
        </style>
</head>
<body>
<?php    
    session_start();
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
<!-- Modal -->
 <div class="modal fade" id="demo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div> 
      
      <form action="code.php" method="POST" enctype="multipart/form-data">
     
      <div class="modal-body">

            <div lass="from-group">
                <label>Book Name:</label>
                <input type="text" name="book_name" class="form-control" required>
            </div>

            <div lass="from-group">
                <label>Auther Name:</label>
                <input type="text" name="author_name" class="form-control" required>
            </div>

            
            <div lass="from-group">
                <label>Book Price:</label>
                <input type="text" name="price" class="form-control" required>
            </div>

            <div lass="from-group">
                <label>Quantity:</label>
                <input type="text" name="quantity" class="form-control" required>
            </div>
            
            <div lass="from-group">
                <label>Image:</label>
                <input type="file" name="image" class="form-control">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Add Record</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="container-fluid" style="float:right;">

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#demo">
  Add Books
</button>
<a href="export_data.php"><button class="btn btn-primary"> Export Data</button></a>
<a href="http://localhost/lib/web.html">
  
<button class="btn btn-primary" data-bs-toggle="modal" >Home</button></a>

<!-- <a href="http://localhost/lib/index.html">
  
<button class="btn btn-primary" data-bs-toggle="modal" >User Interface</button></a> -->

</div>
<div class="table_responsive">

<?php
    // Get the  added products
    $stmt = $con->prepare('SELECT * FROM book');
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
?>
<table class="table" id="datatable" >
  <thead>
  <tr>
      <th>
          ID
      </th>
      <th>
          Book Name
      </th>
      <th>
          Auther Name
      </th>
      <th>
          Book Price
      </th>
      <th>
          Quantity
      </th>      
      
      <th>
          Image
      </th>
      <th>
          Action
      </th>
  </tr>
</thead>
<tbody>
  <?php
    foreach ($books as $book) {     
  ?>
    <tr>
        <td><?php echo $book['book_id'] ?></td>
        <td> <?php echo $book['book_name'] ?></td>
        <td> <?php echo $book['author_name'] ?></td>
        <td><?php echo $book['price'] ?> </td>
        <td><?php echo $book['quantity'] ?> </td>
        
        <!-- <td>  <img src="
    
        class="rounded float-start img-thumbnail rounded mx-auto d-block" width="100px",height="100px" > </td> -->
        <td><img src="<?php echo $book['book_image']?>" width="100" height="100" alt="<?=$book['book_image']?>"></td>
        <td>
         <form action="edit.php" method="POST">
            <input type="hidden" name="editid" value="<?php echo  $book['book_id'] ?>"/>
            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
         </form>
      </td>
      <td>
         <form action="code.php" method="POST">
            <input type="hidden" name="deleteid" value="<?php echo  $book['book_id'] ?>"/>
            <button type="submit" name="delete" class="btn btn-success">Delete</button>
         </form>
        </td>
      
  </tr>
  <?php
      
    }
    ?>
</tbody>
</table>
</div>
</body>
</html>