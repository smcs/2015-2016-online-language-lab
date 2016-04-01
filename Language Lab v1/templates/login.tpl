*  this is a template for log in page*/


{extends file="page.tpl"}

{block name="content"}

<div class="container page-header"

<div class="row">
<div class="col-mg-12">

		<h3 class="text-center">Please sign in with your St. Mark's School email and password.</h3>
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #F0F8FF;
         }
         =
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
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
            border-bottom-right-radius: 100;
            border-bottom-left-radius: 100;
            border-color:#00008B;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 100;
            border-top-right-radius: 100;
            border-color:#00008B;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
	
   <body>
      
      <h2>Log-in to Your Account</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
               if ($_POST['username'] == studentusername && 
                  $_POST['password'] == studentpswrd) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'tutorialspoint';
                  
                  echo 'You have entered valid use name and password';
               }else {
                  $msg = 'Wrong username or password';
               }
               // store some data in the database
               +$sql->query("INSERT INTO `users` (`username`, `password`) VALUES ('" . time() . "', '" . md5(time()) . "')");
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "User ID" placeholder = "" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "Password" placeholder = "" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         Click here to <a href = "homepage.php" title = "Logout"> logout </a> .

         
      </div> 
{/block}