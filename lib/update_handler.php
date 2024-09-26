<?php

include_once "database_connection.php";
session_start();

try {
           
    $database = new Database();
    $connection = $database->openConnection();
    $targetDir = "upload/";
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $fileName;
    $filetype = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    strtoupper($filetype);

       if(isset($_POST['btn_update'])) {

        $id = $_SESSION['user_id'];
        $image =$_FILES['file']['name'];
        $stmt = $connection->prepare("SELECT * FROM user
        where user_id='$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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


        if($stmt->rowCount()>0)
            {
            foreach ($result as $row) 
            {    
                if($image==NULL)
                {
                    $image_path=$row['image_upload'];
                }
                else
                { 
                    
                    unlink($row['image_upload']);
                    $image_path="upload/".$image;
                    
                }
            }
        

        
        }

            
        // $insert_query = "INSERT INTO user(user_first_name,user_middle_name,user_last_name,member,email,password,
        // gender,date_of_birth,phone_no,address,district_id,state_id,image_upload)
        // VALUES
        // (:user_first_name,:user_middle_name,:user_last_name,:member,:email,:password,
        // :gender,:date_of_birth,:phone_no,:address,:district_id,:state_id,:image_upload)";

        $upd = "UPDATE user SET user_first_name=:user_first_name,user_middle_name=:user_middle_name,
        user_last_name=:user_last_name,member=:member,email=:email,password=:password,
        gender=:gender,date_of_birth=:date_of_birth,phone_no=:phone_no,address=:address,
        district_id=:district_id,state_id=:state_id,image_upload=:image_upload  WHERE user_id=:id";
        
        $query_prepare = $connection->prepare($upd);

        //echo $_POST['name']."<br>";             
        $data= [
            ':user_first_name'=> $_POST['user_first_name'],
            ':user_middle_name'=> $_POST['user_middle_name'],
            ':user_last_name'=> $_POST['user_last_name'],
            ':member'=> $_POST['member'],
            ':email'=> $_POST['email'],
            ':password'=> $_POST['password'],
            ':gender'=> $_POST['gender'],
            ':date_of_birth'=> $_POST['date_of_birth'],
            ':phone_no'=> $_POST['phone_no'],
            ':address'=> $_POST['address'],
            ':district_id'=>$_POST['select_district'],           
            ':state_id'=> $_POST['select_state'],
            ':image_upload' => $targetFilePath,
            ':id'=>$_SESSION['user_id']
            
        ];
        
        $query_run = $query_prepare->execute($data);

        if($query_run)
        {
            header('location:index.html');
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