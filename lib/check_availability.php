<?php
include_once "database_connection.php";

try{
    $database = new Database();
    $connection = $database->openConnection();

    $stst = $connection->prepare("SELECT  *FROM user WHERE email=:email");
    $stst->execute(['email' => $_POST['email']]);

    if($stst->rowCount() > 0)
    {
        echo "<span style='color:red'>Email-id already exist.</span>";
    }
    else{
        echo "<span style='color:green'>Email-id available for Registration.</span>";
    }

    $database->closeConnection();

}

catch(PDOException $e) {
    echo "Error" . $e->getMessage();
}

?>