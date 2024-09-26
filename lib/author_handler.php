<?php

include_once "database_connection.php";


try {
           
    $database = new Database();
    $connection = $database->openConnection();

    

    
    if(isset($_POST['btn_author'])) {
        $select_query = "SELECT *FROM author WHERE author_first_name=:author_first_name";
        $query_prepare = $connection->prepare($select_query);
        $data= [
            ':author_first_name'=> $_POST['author_fname']
        ];
     //echo "hi";
        $query_run = $query_prepare->execute($data);
        //echo "hi";
    
            //echo "hi";
        

        if($query_run)
        {
            //echo "hi";
            $results = $query_prepare->fetchAll(PDO::FETCH_ASSOC);
    
        
            echo "<br> <marquee> <h2>Auther Information</h2> </marquee><br>";

           
        foreach($results as $result){
            
            // echo "<br><br>";
            echo "<br>Id of the book :                     ".$result['author_id'];
            echo "<br>First Name of the author :           ".$result['author_first_name'];
            echo "<br>First Name of the author :           ".$result['author_middle_name'];
            echo "<br>First Name of the author :           ".$result['author_last_name'];
            echo "<br>Most popular book of author :        ".$result['pop_book'];
            
            
            //echo "<br>Uploaded Image path : ".;
            // echo "<br>password of the user : ".;
            
        }
   
    }

}

else{
    echo "book not found..!!!";

    }
    
}
    
        catch(PDOException $e) {
    
            echo "Error" . $e->getMessage();
        }
     
?>



