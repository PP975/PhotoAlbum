<html>
    <head>
    <meta charset="utf-8"/>
        <style>
            .container{
                width:40%;
                text-align: center;
                border-style: solid;
                border-radius: 5%;
                margin: 5% auto 15% auto;
                border-radius: 5%;
            }
            .pill-btn {
                padding: 0.5rem 1rem;
                border-radius: 1rem;
                border: none;
                color: white;
                background-color: #0072d5;
                margin: 0.5rem;
            }
        </style>
    </head>
    <body>
      <?php
      if(isset($echo))
      {
        echo'<label>'.$echo.'</label>';
      }
      ?>
    <div class=container>
    <h2 style align="center">Login form</h2>
    <form action="login.php" method="POST" enctype="multipart/form-data">
    <label><b>Username:</b></label>
      <input type="text" placeholder="Enter Username" name="username" id="uname" required>
    <br><br>
      <label><b>Password:</b></label>
      <input type="password" placeholder="Enter Password" name="password" id="psw" required>
    <br><br>
      <button type="submit" id="submit" name="submit" class=pill-btn>Login</button>
      <label>
        <input type="checkbox" name="remember"> Remember me
      </label>
      <br><br>
      <label>New User? 
          <button type="button" onclick="window.location.href='register.php'" class=pill-btn>Register Here</button>
        </label>
        </form>
    </div>
    <?php
    session_start(); 
    $pdo = new PDO("mysql:host=localhost;dbname=album", "root" , "",array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['submit']))
    {
      if(empty($_POST["username"]) || (empty($_POST["password"])))
      {
        $echo= '<label>All fields required</label>';
      }
      else{
        $sql= "SELECT * FROM users WHERE username=:username AND password=:password";
        $query= $pdo -> prepare($sql);
        $query-> execute(
          array(
            'username' => $_POST["username"],
            'password' => md5($_POST["password"])
          )
        );
        $count= $query->rowCount();
        if($count>0)
        {
          $_SESSION['username']= $_POST["username"];
          header("location:http://localhost/project5/album.php");
        }
        else{
          header("Not Successful");
          $echo='<label>Please enter valid credentials</label>';
        }
      }
    }
    
?>
    </body>
</html>