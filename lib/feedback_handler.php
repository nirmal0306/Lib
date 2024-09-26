<?php

include_once "database_connection.php";


try {
           
    $database = new Database();
    $connection = $database->openConnection();
    

    
    if(isset($_POST['btn_feed'])) {

    

        $insert_query = "INSERT INTO feedback(name,email,feedback) VALUES (:name,:email,:feedback)";
        $query_prepare = $connection->prepare($insert_query);
        //echo $_POST['name']."<br>";           
          
        $data= [
            ':name' => $_POST['name'], 
            ':email'=> $_POST['email'],
            ':feedback'=> $_POST['feedback']
            
        ];
        
        $query_run = $query_prepare->execute($data);

        if($query_run)
        {
            header('location:feedback.php');
            //$results = $query_prepare->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            echo "<br> error in insertion";
        }

    
    }

}
        catch(PDOException $e) {
            echo "Error" . $e->getMessage();
        }
   

      
?>