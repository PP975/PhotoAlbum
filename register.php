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
                border-radius: 10%;
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
    <div class=container>
    <h2 style align="center">Register form</h2>
    <form name="form" action="register.php" method="POST">
    <label><b>Username:</b></label>
      <input type="text" placeholder="Enter Username" name="username" id="uname" required>
    <br><br>
      <label><b>Password:</b></label>
      <input type="password" placeholder="Enter Password" name="psw" id="psw1" required>
    <br><br>
    <label><b>FullName: </b></label>
      <input type="text" placeholder="Enter Full Name" name="fname" id="fname" required>
    <br><br>
    <label><b>Email Id: </b></label>
      <input type="email" placeholder="Enter Email Id" id="emailid" name="emailid" required>
      <br><br>
      <button type="submit" name="submit" class=pill-btn>Register</button>
        </form>
    </div>
    <?php
      if(isset($message))
      {
        echo'<label>'.$message.'</label>';
      }
      ?>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=album", "root" , "",array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST['submit'])){
            // do your insert
            $username= $_POST['username'];
            $sql1="SELECT * FROM users WHERE username=:username";
            $query = $pdo->prepare($sql1);
            $parameter =['username'=>$username];
            $query->execute($parameter);
            if($query->rowCount() == 0)
            {
                    $username= $_POST['username'];
                    $password= md5($_POST['psw']);
                    $fullName= $_POST['fname'];
                    $email= $_POST['emailid'];
                    $tmpfname = mkdir("./images/".$username, 0700);
                    $name= "./images/".$username;
                    $sql = "INSERT INTO users (username, password, fullname, email, image_dir)
                    VALUES ('$username' , '$password' , '$fullName', '$email', '$name')";
                    $pdo->exec($sql); 
                    session_start();
                    $_SESSION["username"]=$_POST["username"];
                    header("location: album.php");
                    exit();
                    
            } else{
                header("location: register.php");
            }
        }
?>
    </body>
</html>