<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
   // header("location:login.php");
    exit;
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>booking</title>
<link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"
      rel="stylesheet"
    />


<style>
body {
  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 50px;
  text-align: center;
  background-color: #65b1ad;
  color: rgb(247, 243, 243);
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: rgb(173, 216, 18);
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}
/* Style The Dropdown Button */
.dropbtn {
              background-color: #4CAF50;
              color: white;
              padding: 16px;
              font-size: 16px;
              border: none;
              cursor: pointer;
            }
            
            /* The container <div> - needed to position the dropdown content */
            .dropdown {
              position: relative;
              display: inline-block;
            }
            
            /* Dropdown Content (Hidden by Default) */
            .dropdown-content {
              display: none;
              position: absolute;
              background-color: #f9f9f9;
              min-width: 160px;
              box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
              z-index: 1;
            }
            
            /* Links inside the dropdown */
            .dropdown-content a {
              color: black;
              padding: 12px 16px;
              text-decoration: none;
              display: block;
            }
            
            /* Change color of dropdown links on hover */
            .dropdown-content a:hover {background-color: #f1f1f1}
            
            /* Show the dropdown menu on hover */
            .dropdown:hover .dropdown-content {
              display: block;
            }
            
            /* Change the background color of the dropdown button when the dropdown content is shown */
            .dropdown:hover .dropbtn {
              background-color: #3e8e41;
            }
#dt{
    font-family:Verdana, Tahoma, sans-serif;
}
#parking{
  text-align: center;
  position: absolute ;
  left: 300px;
  border-collapse: separate;
  border-spacing: 20px 20px;
  
}
#abc {
    background: linear-gradient(to bottom, #cbcbcb 2%, #fff 100%);
    margin-top: 60px;
    margin-left: 140px;
    padding: 15px 30px;
    text-align: center;
    transition: .5s;
    border: none;
    outline: none;
    text-transform: uppercase;
    color: #1b1b1b;
    font-size: 20px;
    font-weight: 700;
    border-radius: 30px;
    box-shadow: 1px 4px 12px rgba(94,28,68,.15);
    position: absolute;
    left: 700px;
    top: 700px;
}
</style>
</head>
<body>

<div class="about-section">
  <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"> BOOK NOW SERGEANT </h1>
  <p>Here we go!!! Click and Book</p>
  <p> Just few simple steps</p>
</div>


    
  </div>
    <form action="booking2.php" method="post">
        <div class="column">
            <div class="card">
            
            <div class="container">
                <h1><p id="dt">Date : <span id="date" name="date" id="date"></span></p>

                    <script>
                    var dt = new Date();
                    document.getElementById("date").innerHTML = dt.toLocaleDateString();
                    </script></h1>
                    
                    
                
                
                
            </div>
            </div>
        </div>
        
    
        <label for="cars" >Select Time Slot</label>

        <select name="cars" id="cars">
        <option value="911">9-11</option>
        <option value="111">11-1</option>
        <option value="13">1-3</option>
        
        </select>
         <input type="submit" name="submit1" class="button" value="Submit" > 
    </form>
  
  <br><br><br><br><br>
<div id="hid" hidden>
    <table id="parking"></table>
        <script>
        var ida = "0";
        var time="";
        function func(){
            time=document.getElementById('cars').value;
                document.getElementById('tiime').value = time;
        }
        var table = document.getElementById("parking");
        for (let i = 0; i < 5; i++) {
            var row = table.insertRow(i);
            
            for (let j = 0; j < 20; j++) {
            var cell = row.insertCell(j);
            var button = document.createElement("button");
            let temp = i.toString() + j.toString();
            button.setAttribute("id", temp);
            button.setAttribute("class", "btn btn-success fa fa-light fa-car");
            button.innerHTML = "";
            cell.appendChild(button);
            button.setAttribute("onclick", "book(this.id)");
            
            
            
            }
        }

        function book (id) {
        
            var button = document.getElementById(id);
            button.setAttribute("class", "btn btn-danger fa fa-light fa-car");
            ida = this.id ;
            console.log("ffuvk");
            console.log(ida);
        }
        
    
                var acc = document.getElementsByClassName("btn btn-success fa fa-light fa-car");

                var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function() {
            var previous = document.querySelector(".btn-danger"); //select previous button
            if (previous) { // check because when first time no button has active class
                previous.classList.remove("btn-danger");
                previous.classList.add("btn-success");
                
            }
            this.classList.remove("btn-success");
            this.classList.add("btn-danger");
            
            ida=document.getElementsByClassName('btn btn-danger fa fa-light fa-car')[0].id;
            console.log(ida);
            document.getElementById('username').value = ida;
            
            };
        }
        
        
        </script>
    
    
    </div>
        <form action="booking2.php" method="post">
        <input id="username" name="username" type="text" hidden>
        <input id="tiime" name="tiime" type="text" hidden>
        <input id="submit" type="submit" name="submit"  value="BOOK" />
            
        </form> 
</div>
      
      


</body>
</html>
<?php 
 
  
    include 'db.php';
    if(isset($_POST['submit1'])==true){
        $password=$_POST["cars"];
        
        $sql="SELECT `number` FROM `data` WHERE `time` LIKE '{$password}'";
        $result=mysqli_query($conn,$sql);
        if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                
                ?>
                <script>document.getElementById('hid').hidden = false;
                
                document.getElementById('tiime').value =<?php echo $password ?>;
                document.getElementById(<?php echo $row['number'] ?>).disabled = true;</script>
                <?php

                


            }}
            else{
                ?> <script>document.getElementById('hid').hidden = false;
                document.getElementById('tiime').value =<?php echo $password ?>;
                </script> <?php
            }
        
        
    }
    
    if(isset($_POST['submit'])){
        $varid = "<script>document.writeln(func());</script>";
        $val = $_POST['username'];
        $vall = $_POST['tiime'];
        $username= $_SESSION['username']; 

        $sql="INSERT INTO `data` (`username`, `time`, `number`) VALUES ('{$username}', '{$vall}', '{$val}')";
        $result=mysqli_query($conn,$sql);
        if ($result){
            //header("location: successful.php");
            echo "SUCCESSFULL";
        }
        
        
        
        
      }
?>