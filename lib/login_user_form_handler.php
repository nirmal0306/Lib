
<?php

include_once "database_connection.php";


try {
    session_start();
  
           
    $database = new Database();
    $connection = $database->openConnection();

    
        if(isset($_POST['btn_login'])) {
            $select_query = "SELECT  *FROM user WHERE email=:email AND password=:password";
           
            $query_prepare = $connection->prepare($select_query);
            $data= [
                ':email'=> $_POST['email'],
                ':password'=> md5($_POST['password'])
            ];

            $query_run = $query_prepare->execute($data);
            
            
            
            
            // $state_query = "SELECT  *FROM state WHERE StCode=:state_id";
            // $st= $connection->prepare($state_query);
            // $data1= [
            //     ':StCode'=> $_POST['StCode'],
            //     ':StateName'=> $_POST['StateName']
            // ];

            // $state_run = $st->execute($data1);
            
            
            
            // $dist_query = "SELECT  *FROM district WHERE DistCode=:district_id";
            // $dist = $connection->prepare($dist_query);
            // $data2= [
            //     ':DistCode'=> $_POST['DistCode'],
            //     ':DistrictName'=> $_POST['DistrictName']
            // ];

            // $dist_run = $dist->execute($data2);
            
            if($query_run)
            {
                //echo "hi";
                $results = $query_prepare->fetchAll(PDO::FETCH_ASSOC);
        
            
                // echo "<br> <marquee> <h2>User Information</h2> </marquee><br>";
            foreach($results as $result){
                ?>

<!DOCTYPE html> 
    <html>
<style>
    body{
        
        background-image: url(pexels-pixabay-531880.jpg);
            background-size: cover;
            color:white;
        
    }



/* CSS */
.button-78 {
  align-items: center;
  appearance: none;
  background-clip: padding-box;
  background-color: initial;
  background-image: none;
  border-style: none;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  flex-direction: row;
  flex-shrink: 0;
  font-family: Eina01,sans-serif;
  font-size: 16px;
  font-weight: 800;
  justify-content: center;
  line-height: 24px;
  margin: 0;
  min-height: 64px;
  outline: none;
  overflow: visible;
  padding: 19px 26px;
  pointer-events: auto;
  position: relative;
  text-align: center;
  text-decoration: none;
  text-transform: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: middle;
  width: auto;
  word-break: keep-all;
  z-index: 0;
}

@media (min-width: 768px) {
  .button-78 {
    padding: 19px 32px;
  }
}

.button-78:before,
.button-78:after {
  border-radius: 80px;
}

.button-78:before {
  background-image: linear-gradient(92.83deg, #ff7426 0, #f93a13 100%);
  content: "";
  display: block;
  height: 100%;
  left: 0;
  overflow: hidden;
  position: absolute;
  top: 0;
  width: 100%;
  z-index: -2;
}

.button-78:after {
  background-color: initial;
  background-image: linear-gradient(#541a0f 0, #0c0d0d 100%);
  bottom: 4px;
  content: "";
  display: block;
  left: 4px;
  overflow: hidden;
  position: absolute;
  right: 4px;
  top: 4px;
  transition: all 100ms ease-out;
  z-index: -1;
}

.button-78:hover:not(:disabled):before {
  background: linear-gradient(92.83deg, rgb(255, 116, 38) 0%, rgb(249, 58, 19) 100%);
}

.button-78:hover:not(:disabled):after {
  bottom: 0;
  left: 0;
  right: 0;
  top: 0;
  transition-timing-function: ease-in;
  opacity: 0;
}

.button-78:active:not(:disabled) {
  color: #ccc;
}

.button-78:active:not(:disabled):before {
  background-image: linear-gradient(0deg, rgba(0, 0, 0, .2), rgba(0, 0, 0, .2)), linear-gradient(92.83deg, #ff7426 0, #f93a13 100%);
}

.button-78:active:not(:disabled):after {
  background-image: linear-gradient(#541a0f 0, #0c0d0d 100%);
  bottom: 4px;
  left: 4px;
  right: 4px;
  top: 4px;
}

.button-78:disabled {
  cursor: default;
  opacity: .24;
}

    </style>
    <body>

    <table style="margin-top :300px;margin-left:500px;">

        <tr>
            <td style="padding: 25px;margin-left:550px; ">    
    <a href="http://localhost/lib/book_list.php"><button class="button-78" role="button">Purchase Book</button></a>
    </td>
    
    <!-- <td style="padding: 25px;">
    <a href=http://localhost/lib/author.html><button class="button-78" role="button">Search Author</button></a>
    </td> -->

    <td style="padding: 25px;">
    <button class="button-78" value="Result" onclick="display()"/>Your Data</button>


    </td>

    </tr>
    </table>


                <?php $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['user_name'] = $result['user_first_name'];                    
                $_SESSION['email'] = $result['email'];
                $_SESSION['password'] = $result['password'];
        ?>
        <?php    

                
            }
           
        }
        }
        
    }
        catch(PDOException $e) {
            echo "Error" . $e->getMessage();
        }
   

        // echo $result['user_first_name'];    
?>
<br><br>
   
    
    

<script>
  var u1 =<?php echo $result['user_first_name'];?>;
  function display() {
  
  
    document.write('<?php  echo "<br>Id of the user : "?>                  <?php echo $result['user_id'];?>');
    document.write('<?php  echo "<br>First Name of the user : "?>          <?php echo $result['user_first_name'];?> ');
    document.write('<?php  echo "<br>Middle Name of the user : "?>         <?php echo $result['user_middle_name'];?> ');
    document.write('<?php  echo "<br>Last Name of the user : "?>           <?php echo $result['user_last_name'];?> ');
    document.write('<?php  echo "<br>Email of the user : "?>               <?php echo $result['email'];?>');
    document.write('<?php  echo "<br>gender of the user :  "?>             <?php echo $result['gender'];?>');
    document.write('<?php  echo "<br>User is student(1) or not(0) : "?>    <?php echo $result['member'];?>');
    document.write('<?php  echo "<br>Date of Birth of the user : "?>       <?php echo $result['date_of_birth'];?>');
    document.write('<?php  echo "<br>Phone no of the user : "?>            <?php echo $result['phone_no'];?>');
    document.write('<?php  echo "<br>Address of the user : "?>             <?php echo $result['address'];?> ');
    document.write('<?php  echo "<br>district of the user : "?>         <?php echo $result['district_id'];?> ');
    document.write('<?php  echo "<br>State of the user : "?>           <?php echo $result['state_id'];?> ');
    document.write('<?php echo "<br>Image that you have uploaded :<br>";?> <img src = <?php echo $result['image_upload'];?> style="width:60px;heigth:50px">');
    document.write('<a href=http://localhost/lib/login_user_form_handler.php><button class="button-78" role="button">Back</button></a>');
    document.write('<a href=http://localhost/lib/book_list.php><button class="button-78" role="button">Book Purchase</button></a>');
    document.write('<a href=http://localhost/lib/author.html><button class="button-78" role="button">Search Auther</button></a>');
// document.write(u1);

}
      </script>

    </body>

    
    </html>