<?php
 ini_set("display_errors", 1);
   include("config.php");
   session_start();
   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $username = mysqli_real_escape_string($db,$_POST['username']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "select username from user where username = '$username' and password = '".md5($password)."' AND status = 'A'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         //session_register("username");
         $_SESSION['login_user'] = $username;
         
         header("location: admin");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<html lang = "en">
   
   <head>
      <title>Login - Thili Creation</title>
      
    <!-- Bootstrap  -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #111;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 8px;
            margin: 0 auto;
            color: #fac81a;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#fac81a;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
         }
         
         h2{
            text-align: center;
            color: #fac81a;
         }
		 h3{
            text-align: center;
            color: #fac81a;
         }
      </style>
      
   </head>
	
   <body>
      
      <!--<h2>THILI CREATION</h2> -->
	  <h2><img src="./img/logos.png" /></h2>
	  <h3>Admin Login</h3>
      <div class = "container form-signin">
         
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "" method = "post">
            <h5 class = "form-signin-heading"><?php echo $error; ?></h5>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "username" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         Click here to clean <a href = "logout.php" tite = "Logout">Session.
         
      </div> 
   </body>
</html>