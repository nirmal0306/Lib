<?php
session_start();
    include_once "database_connection.php";

	
    try {
        $database = new Database();
        $connection = $database->openConnection();
	
		
        if(isset($_POST['btn_login'])) {
			$query = "SELECT * FROM user WHERE email=:email AND 
			password=:password";
			$query_prepare = $connection->prepare($query);
			
			$data =  [		
			':email'=>$_POST['email'],
			':password'=>md5($_POST['password'])     
			];
			echo "heyyy";
			$query_run = $query_prepare->execute($data);			
			
			
			if($query_run)
			{	
				$results = $query_prepare->fetchAll(PDO::FETCH_ASSOC);				
				//In case that the query returned at least one record, we can echo the records within a foreach loop:
				
					foreach($results as $result)
					{
						echo $result['user_id'];
						echo $result['user_first_name'];
						// Get the userid AND name				
						$_SESSION['user_id'] = $result['user_id'];
						$_SESSION['user_name'] = $result['user_first_name'];                    
						$_SESSION['email'] = $result['email'];
						$_SESSION['password'] = $result['password'];
						header('location:book_list.php');
					}
                    if(isset($_POST['remember'])){
                        // Set a cookie that expires in 24 hours
                        setcookie("email",$_POST['email'], time()+60*60*24);
                        setcookie("password",$_POST['password'], time()*60*60*24);
                    }
				}
        $database->closeConnection();
		}
		} 
		catch (PDOException $e) 
		{
			$e->getMessage();
		}
    
?>
