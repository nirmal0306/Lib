<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.css">
    <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
    <link rel="stylesheet" type="text/css" href="flickity/flickity.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/sweetalert.css"> -->
    <!-- <script type="text/javascript" src="flickity/flickity.js"></script> -->
    <!-- <script type="text/javascript" src="sweetalert.min.js"></script> -->
    <title>Library Management</title>

    <script>
  function checkEmailAvailability() {
  
  jQuery.ajax({
    url: "check_availability.php",
    data:'email='+$("#email").val(),
    type: "POST",
    success:function(data){
      $("#email-availability-status").html(data);
    },
    error:function (){
      event.preventDefault();
    }
  });
  }


  function getdistrict(val) {
	$.ajax({
	type: "POST",
	url: "get_district.php",
	data:'state_id='+val,
	success: function(data){
		$("#select_district").html(data);
	}
	});
}
</script>


        </script>


    <style>
        body {
            background-image: url(book1.jpg);
            background-size: cover;
        }
        
        .errorpop{
            border: 2px solid red;
        }

        .okpop{ 
            border: 2px solid green;
        }

    </style>
</head>

<body>

    <div class="container">



        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">


                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example">
                        <span class="sr-only">:</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>


                    <a class="navbar-brand" href="http://localhost/lib/index.html">Library Management System</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example">
                    <ul class="nav navbar-nav">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://localhost/lib/index.html">Home</a></li>
                        </ul>
                </div>
            </div>
        </nav>
        <div class="container  col-lg-9 col-md-11 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-1 col-sm-offset-0 col-xs-offset-0  "
            style="margin-top: 20px">
            <div class="jumbotron login3 col-lg-10 col-md-11 col-sm-12 col-xs-12">


                <p class="page-header" style="text-align: center">Update Form</p>
                <!-- <button id="loadbutton" text="LoadData">Press For City</button>
                <button id="loadbutton1" text="LoadData1">Press For State</button>
                <br><br>     -->

                <div class="container">

                <?php
    session_start();
    include_once "database_connection.php";

    try {
        $database = new Database();
        $connection = $database->openConnection();
        // Get the userid
        $userid=intval($_SESSION['user_id']);
        
        $sql = "SELECT * from user where user_id=:user_id";
        //Prepare the query:
        $query_prepare = $connection->prepare($sql);
        //Bind the parameters using array
        $data =  [		
                    ':user_id'=>$userid    
        ];
        $query_prepare->execute($data);
        $results = $query_prepare->fetchAll(PDO::FETCH_ASSOC);	
        
        $cnt=1;
        
        if($query_prepare->rowCount() > 0)
        //In case that the query returned at least one record, we can echo the records within a foreach loop:
        foreach($results as $result)
        {
        ?>



                    <!-- <form id="registration_form" method="post" action="registration_handler.php" enctype="multipart/form-data" > -->
                    <form id="update_form" name="update_form" method="post" action="update_handler.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-2 control-label">FIRST NAME</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_first_name" name="user_first_name"
                                    placeholder="First name" onblur="chk(this.value);"  value="<?php echo $result['user_first_name'];?>" required>
                                    <span id="err1"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_middle_name" class="col-sm-2 control-label">MIDDLE NAME</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_middle_name" name="user_middle_name"
                                    placeholder="Middle name" value="<?php echo $result['user_middle_name'];?>" onblur="chk1(this.value);" required>
                                    <span id="err2"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="user_last_name" class="col-sm-2 control-label">lAST NAME</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_last_name" name="user_last_name"
                                    placeholder="Last name" value="<?php echo $result['user_last_name'];?>" onblur="chk2(this.value);" required>
                                    <span id="err3"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="gender" class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-10">
                                <br>
                                <input type="radio" name="gender" id="gender" value="1" onblur="chk3(this.value);" required>Male
                                <input type="radio" name="gender" id="gender" value="0" onblur="chk3(this.value);" required>Female
                                <input type="radio" name="gender" id="gender" value="2" onblur="chk3(this.value);" required>Other
                                <span id="err4"></span>
                                <!-- <input type="text" class="form-control" name="dept" placeholder="Department" id="Address" required> -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Password" class="col-sm-2 control-label">PHONE NUMBER</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone_no" name="phone_no"
                                    placeholder="phone" id="password" value="<?php echo $result['phone_no'];?>" onblur="chk4(this.value);" required>
                                    <span id="err5"></span>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="add" class="col-sm-2 control-label">ENTER ADDRESS:</label>
                            <div class="col-sm-10">
                                <br /> <input class="form-control" id="address" name="address" type="text"
                                    placeholder="enter address" value="<?php echo $result['address'];?>" onblur="chk5(this.value);" required/>
                                    <span id="err6"></span>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="select_state" class="col-sm-2 control-label">STATE:</label>
                            <div class="col-sm-10">
                                
                              <br>  <select onChange="getdistrict(this.value);" name="select_state" id="select_state" onblur="chk6(this.value);" required>
                                    <option value="">Select state</option>

                                    <?php
                                    $stmt = $connection->prepare('SELECT * FROM state');
                                    $stmt->execute();
                                    $states  = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($states as $state)
                                    {?>                                    
                                        <option value="<?php echo $state['StCode'];?>">
                                        <?php echo $state['StateName'];?></option>  
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span id="err7"></span>

                            </div>
                        </div>


                        

                        <div class="form-group">
                             
                        <label for="select_state" class="col-sm-2 control-label">District:</label>
                            <div class="col-sm-10">
                            <br> <select name="select_district" id="select_district" onblur="chk7(this.value);" required>
                                    <option value="">Select District</option>
                                </select>
                                
                                <span id="err8"></span>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="member" class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10">
                                <br>


                                <input type="radio" name="member" id="member" value="1" onblur="chk8(this.value);" required>Student
                                <input type="radio" name="member" id="member" value="0" onblur="chk8(this.value);" required>Non-student
                                <span id="err9"></span>
                                <br><br>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="Password" class="col-sm-2 control-label">EMAIL</label>
                            <div class="col-sm-10">
                            <br> <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    onBlur="checkEmailAvailability();" value="<?php echo $result['email'];?>" required><span id="email-availability-status"
                                    style="font-size:12px;"></span>
                                    <span id="err10"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="Password" class="col-sm-2 control-label">PASSWORD</label>
                            <div class="col-sm-10">
                            <br> <input type="password" class="form-control" id="password" name="password" required
                                    pattern="^\w{6,8}$" onblur="chk10(this.value);" placeholder="password length 6-8 characters">
                                <!-- <input type="password" class="form-control" name="password" placeholder="password" id="password" required> -->
                                <span id="err11"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="Password" class="col-sm-2 control-label">CONFRIM PASSWORD</label>
                            <div class="col-sm-10">
                            <br>   <input type="password" class="form-control" name="verify_password"
                                    placeholder="Confirm password" id="verify_password" required pattern="^\w{6,8}$" onblur="chk11(this.value);" required>
                                    <span id="err12"></span>
                            </div>
                        </div>

                        

                        <!-- <input type="hidden" class="form-control" name="num_books" placeholder="books" id="password" required value="null">

                     <input type="hidden" class="form-control" name="money_owed" placeholder="Money" id="password" required value="null"> -->

                        <div class="form-group">
                            <label for="dateBirthday" class="col-sm-2 control-label">Birthday</label>
                            <div class="col-sm-10">
                            <br><input type="date" class="form-control" id="date_of_birth" name="date_of_birth" onblur="chk12(this.value);" required>
                                <span id="err13"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">UPLOAD IMAGE:</label>
                            <div class="col-sm-10">
                            <br><input type="file" class="form-control" name="file" id="file" placeholder="Upload image"
                                    style="padding: 0" onblur="chk13(this.value);" required>
                                    <span id="err14"></span>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-sm-offset-4 col-sm-5">
                                <br><input type="submit" name="btn_update" value="REGISTER" id="btn_update"
                                    class="btn btn-info col-lg-12">&nbsp;
                                <br><input type="reset" value="RESET" id="btnReset" class="btn btn-info col-lg-12">&nbsp;


                                <!-- <button  class="btn btn-info col-lg-12" data-toggle="modal" data-target="#info" name="submit"> -->



                            </div>
                        </div>


                    </form>
                    <?php
        }
          } 
            catch (PDOException $e) 
            {
                $e->getMessage();
          } 
?>

                    
                    
                </div>
                <a href="http://localhost/lib/index.html"><p class="slide2"><button class="btn btn-success">Home</button></p></a>

            </div>

        </div>
    </div>




    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript">





    </script>
    <script>

       // if(confirm("You are sure you want to submit")){



        function chk(input) {
            var nmregx = /^[A-Za-z]+$/;
            var fnm = document.querySelector('#user_first_name').value;
            
            

            if (nmregx.test(fnm) == false) {
                //alert("Enter a valid first name");
                document.querySelector('#user_first_name').classList.add('errorpop');
                document.getElementById("err1").innerHTML = "Enter Valid First name";
                document.getElementById("err1").style.color = "red";
                
                
            }
            else {
                document.querySelector('#user_first_name').classList.add('okpop');

                document.getElementById("err1").innerHTML = "";

            }

            

        }

            function chk1(input) {
            var nmregx1 = /^[A-Za-z]+$/;
            var mnm = document.querySelector('#user_middle_name').value;

            if (nmregx1.test(mnm) == false) {
                document.querySelector('#user_middle_name').classList.add('errorpop');
                document.getElementById("err2").innerHTML = "Enter Valid Middle name";
                document.getElementById("err2").style.color = "red";
                
                //alert("Enter a valid middle name");                
            }
            else {
                document.querySelector('#user_middle_name').classList.add('okpop');
                document.getElementById("err2").innerHTML = "";

            }

        }

         function chk2(input) {
            var nmregx2 = /^[A-Za-z]+$/;

             var lnm = document.querySelector('#user_last_name').value;
              if (nmregx2.test(lnm) == false) {
                 // alert("Enter a valid last name");
                 document.querySelector('#user_last_name').classList.add('errorpop');
                 document.getElementById("err3").innerHTML = "Enter Valid Last name";
                 document.getElementById("err3").style.color = "red";
            }
            else {
                document.querySelector('#user_last_name').classList.add('okpop');
                document.getElementById("err3").innerHTML = "";

            }

         }

         
        function chk3(input) {

            if((registration_form.gender[0].checked==false) && (registration_form.gender[1].checked==false) && (registration_form.gender[2].checked==false))
            {       

                document.getElementById("err4").innerHTML = "Please select gender";
                document.getElementById("err4").style.color = "red";

            }
            
            else{

                document.getElementById("err4").innerHTML = "";

                }
         
         }
 


         function chk4(input) {

            var numregx = /^[0-9]+$/;

            var pn = document.querySelector("#phone_no").value;
              if (numregx.test(pn) == false || pn.length != 10) {
                 // alert("Enter a valid last name");
                 document.querySelector('#phone_no').classList.add('errorpop');
                 document.getElementById("err5").innerHTML = "Enter Valid Phone no";
                 document.getElementById("err5").style.color = "red";
            }
            else {
                document.querySelector('#phone_no').classList.add('okpop');
                document.getElementById("err5").innerHTML = "";

            }
        }

        function chk5(input) {
            var nmregx3 = /^[A-Za-z0-9\s_/,-]+$/;

             var addr = document.querySelector('#address').value;
              if (nmregx3.test(addr) == false) {
                 // alert("Enter a valid last name");
                 document.querySelector('#address').classList.add('errorpop');
                 document.getElementById("err6").innerHTML = "Enter Valid Address";
                 document.getElementById("err6").style.color = "red";
            }
            else {
                document.querySelector('#address').classList.add('okpop');
                document.getElementById("err6").innerHTML = "";

            }

         }

         function chk6(input) {
            if(registration_form.select_state.value==""){
                document.querySelector('#select_state').classList.add('errorpop');
                 document.getElementById("err7").innerHTML = "Please select state";
                 document.getElementById("err7").style.color = "red";
            }
            else {
                document.querySelector('#select_state').classList.add('okpop');
                document.getElementById("err7").innerHTML = "";


            }
         }

         function chk7(input) {
            if(registration_form.select_district.value==""){
                document.querySelector('#select_district').classList.add('errorpop');
                 document.getElementById("err8").innerHTML = "Please select Distict";
                 document.getElementById("err8").style.color = "red";
            }
            else {
                document.querySelector('#select_district').classList.add('okpop');
                document.getElementById("err8").innerHTML = "";


            }
         }

         function chk8(input) {

if((registration_form.member[0].checked==false) && (registration_form.member[1].checked==false) )
{       

    document.getElementById("err9").innerHTML = "Please select member";
    document.getElementById("err9").style.color = "red";

}

else{

    document.getElementById("err9").innerHTML = "";

    }

}


function chk10(input) {
    var passregx = /^[A-Za-z0-9_/$&*@!,-]+$/;

             var pass = document.querySelector('#password').value;
              if (passregx.test(pass) == false || pass == " ") {
                 // alert("Enter a valid last name");
                 document.querySelector('#password').classList.add('errorpop');
                 document.getElementById("err11").innerHTML = "Enter Valid Password";
                 document.getElementById("err11").style.color = "red";
            }
            else {
                document.querySelector('#password').classList.add('okpop');
                document.getElementById("err11").innerHTML = "";

            }
}

function chk11(input) {
    

             var pass = document.querySelector('#password').value;
             var pass1 = document.querySelector('#verify_password').value;
              if (pass != pass1) {
                 // alert("Enter a valid last name");
                 document.querySelector('#verify_password').classList.add('errorpop');
                 document.getElementById("err12").innerHTML = "Enter Same Password";
                 document.getElementById("err12").style.color = "red";
            }
            else {
                document.querySelector('#verify_password').classList.add('okpop');
                document.getElementById("err12").innerHTML = "";

            }
}


function chk12(input) {
    

    var dob = document.querySelector('#date_of_birth').value;
    
     if (dob == "") {
        // alert("Enter a valid last name");
        document.querySelector('#date_of_birth').classList.add('errorpop');
        document.getElementById("err13").innerHTML = "Select date proparly";
        document.getElementById("err13").style.color = "red";
   }
   else {
       document.querySelector('#date_of_birth').classList.add('okpop');
       document.getElementById("err13").innerHTML = "";

   }
}

function chk13(input) {
    

    var fl = document.querySelector('#file').value;
    
     if (fl == "") {
        // alert("Enter a valid last name");
        document.querySelector('#file').classList.add('errorpop');
        document.getElementById("err14").innerHTML = "Please upload a image";
        document.getElementById("err14").style.color = "red";
   }
   else {
       document.querySelector('#file').classList.add('okpop');
       document.getElementById("err14").innerHTML = "";

   }
}


         function checkEmailAvailability() {

var mailreg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mil = document.querySelector('#email').value;

if (mailreg.test(mil) == false) {
     // alert("Enter a valid last name");
     document.querySelector('#email').classList.add('errorpop');
     document.getElementById("err10").innerHTML = "Enter Valid Email Address";
     document.getElementById("err10").style.color = "red";
}
else {
    document.querySelector('#email').classList.add('okpop');
    document.getElementById("err10").innerHTML = "";

}




jQuery.ajax({
url: "check_availability.php",
data: 'email=' + $('#email').val(),
type: "POST",

success: function (data) {
$("#email-availability-status").html(data);
},

error: function () {
event.preventDefault();
}
});

}

//}
         


      




       
    </script>


</body>

</html>