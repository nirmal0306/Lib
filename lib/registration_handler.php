<?php

include_once "database_connection.php";


try {
           
    $database = new Database();
    $connection = $database->openConnection();
    $targetDir = "upload/";
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $fileName;
    $filetype = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    strtoupper($filetype);

    
    if(isset($_POST['btn_register'])) {

        if(!empty($_FILES['file']['name'])){
            echo "<br> In File upload";

            $allowTypes = array('jpg','png','jpeg','gif','pdf','JPG','PNG','JPEG','GIF','PDF');
            if(in_array($filetype,$allowTypes)){
                echo $targetFilePath;
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    echo "<br>File uploaded on server";
                }
                else{
                    echo "<br>File uploaded failed";
                }
            }
        }

        $insert_query = "INSERT INTO user(user_first_name,user_middle_name,user_last_name,member,email,password,
        gender,date_of_birth,phone_no,address,district_id,state_id,image_upload)
        VALUES
        (:user_first_name,:user_middle_name,:user_last_name,:member,:email,:password,
        :gender,:date_of_birth,:phone_no,:address,:district_id,:state_id,:image_upload)";
        
        $query_prepare = $connection->prepare($insert_query);

        //echo $_POST['name']."<br>";             
        $data= [
            ':user_first_name'=> $_POST['user_first_name'],
            ':user_middle_name'=> $_POST['user_middle_name'],
            ':user_last_name'=> $_POST['user_last_name'],
            ':member'=> $_POST['member'],
            ':email'=> $_POST['email'],
            ':password'=> md5($_POST['password']),
            ':gender'=> $_POST['gender'],
            ':date_of_birth'=> $_POST['date_of_birth'],
            ':phone_no'=> $_POST['phone_no'],
            ':address'=> $_POST['address'],
            ':district_id'=>$_POST['select_district'],           
            ':state_id'=> $_POST['select_state'],
            ':image_upload' => $targetFilePath
            
        ];
        
        $query_run = $query_prepare->execute($data);

        if($query_run)
        {
            header('location:user_login_form.php');
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