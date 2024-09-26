<?php
    include_once "database_connection.php";


    try {

        $database = new Database();
    
    
        if($database == null) {
        echo " <br> Database failed<br>";
        }

        else{
            echo " <br> Database success <br>";
            }
    

        $connection = $database->openConnection();
     
        if($connection==null) {
            echo "<br> Database connection failed". $connection;
            exit;
        }

        else{
        echo "<br> Database connection success<br>";
        }

        $select_query = "select *from user WHERE email=:email AND password=:password";
        $select_parameters = [
            ':email'=> "nirmal067@gmail.com",
            ':password'=> "12345678"
        ];
        $query_prepare = $connection->prepare($select_query);
        $query_execute = $query_prepare->execute($select_parameters);
        
        if($query_execute == true) {
            echo "<br> Query execution Successful";
        }

        else{
            echo "<br> Query execution Failed";
        }

        echo"<br>Total No of user : ".$query_prepare->rowCount();
        echo "<br><br>";
        $users = $query_prepare->fetchall(PDO::FETCH_ASSOC);

        foreach($users as $user){
            echo "<br>Id of the user : ".$user['user_id'];
            echo "<br>Name of the user : ".$user['user_first_name'];
            echo "<br>Email of the user : ".$user['email'];
            echo "<br>password of the user : ".$user['password'];
            
        }
    }
    catch(PDOException $e) {
        echo "Error" . $e->getMessage();
    }
?>