<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
?>
<! DOCTYPE html>
    <html>
    <head>
        <title></title>
        <style>
            .col-9 {
                width: 74.5%;
                display: inline-block;
            }
            .col-3 {
                width: 24.5%;
                display: inline-block;
            }

            .heading{
                padding: 2rem auto
            }

            .container {
                width: 100%;
            }

            .scroll{
                height: 80vh;
                overflow: auto;
            }

            .pill-btn {
                padding: 0.5rem 1rem;
                border-radius: 1rem;
                border: none;
                color: white;
                background-color: #0072d5;
                margin: 0.5rem;
                display: block;
            }
            .b1 {
                padding: 0.5rem 1rem;
                border-radius: 1rem;
                border: none;
                color: white;
                background-color: #0072d5;
                margin: 0.5rem;
            }
            .b2 {
                padding: 0.5rem 1rem;
                border-radius: 1rem;
                border: none;
                color: white;
                background-color: #0072d5;
                margin: 0.5rem;
                height: 30px;
                text-align: right;
                right: 40px;
                position: fixed;
            }
        </style>
    </head>
    <body>
        <div class="Container1" align="center">
            <button type="button" name="logout" id="logout" class="B2" onclick="window.location.href='logout.php?logout=true'">Log Out</button>
            <br><br><br>
            <h2 class="heading" align="center">Insert and Display the Link of Images which has been inserted by user</h2>
            <h3>Welcome to your dashboard<p id=uname><?php echo ucfirst($_SESSION["username"]); ?><p></h3>
            <form action="album.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" id="imageFile">
                <br><br>
                <button type="button" name="submit" id="insert" value="Insert" class="B1" onclick="uploadFile()">Upload Image</button>
            </form>
        </div>
        <div class="container">
            <div class="col-3 scroll" id="display">
            </div>
            <div class="col-9 scroll">
                <img src="" alt="" id="Image">
            </div>
        </div>
        <?php
        $session_user=$_SESSION["username"];
        $dir = "./images/".$session_user;
        $list = scandir($dir);
        $files1 = array_diff($list, array('.', '..'));
        ?>
        <script type="text/javascript">
            var listofImage = <?php echo json_encode($files1); ?>;
            var count= Object.values(listofImage);
            for (var m=0; m <count.length; m++){
                //debugger;
                var btn1 = document.createElement('button');
                btn1.setAttribute('class', 'pill-btn');
                var i2=document.getElementById("uname").innerHTML;
                btn1.setAttribute('onclick', "showImage('./images/"+i2+"/"+count[m]+"')");
                btn1.innerHTML = count[m];
                document.getElementById("display").appendChild(btn1);
            }
            function uploadFile() {
                var files = document.getElementById("imageFile").files;
                var dataToPass = new FormData();
                dataToPass.append("file", files[0]);
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "upload.php", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        data = this.responseText.split("__");
                        var btn = document.createElement('button');
                        btn.setAttribute('class', 'pill-btn');
                        btn.setAttribute('onclick', "showImage('" + data[1] + "')");
                        btn.innerHTML = data[0];
                        document.getElementById("display").appendChild(btn);
                        
                    }
                };

                xhttp.send(dataToPass);
            }

            function showImage(data){
                var image = document.getElementById("Image");
                image.setAttribute("src", data);
                image.setAttribute("alt", data.split("/")[1] + "  Image unable to load");
            }
        </script>
    </body>
</html>