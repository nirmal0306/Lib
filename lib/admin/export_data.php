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


    // Fetch records from database 
    $stmt = $con->prepare("SELECT * FROM book 
        ORDER BY book_id DESC");
    $stmt->execute();
    // Fetch the product from the database and return the result 
    //as an Array
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 
 
if($stmt->rowCount() > 0){ 
    $delimiter = ","; 
    $filename = "books-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('book_id', 'book_name','author_name', 'price', 'quantity', 'book_image'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, 
    // format line as csv and write to file pointer 
    foreach ($books as $book) {
        //echo $book['id'];
        $lineData = array($book['book_id'], $book['book_name'], $book['author_name'],
            $book['price'], 
            $book['quantity'], $book['book_image']); 
        fputcsv($f, $lineData, $delimiter); 
    }
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 

?>