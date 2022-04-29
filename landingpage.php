<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit;
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Landing Page Design Using HTML & CSS</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
}
.container {
    height: 100vh;
    width: 100%;
    background-image: url(img/img3.jpg);
    background-position: center;
    background-size: cover;
    padding-right: 3%;
    padding-left: 5%;
    box-sizing: border-box;
    position: relative;
}
#am{

}
.header {
    width: 100%;
    height: 15vh;
    margin: auto;
    display: flex;
    align-items: center;
}
.logo {
    width: 80px;
    margin-top: 10px;
    cursor: pointer;
}
nav {
    flex: 1;
    padding-left: 450px;
}
nav ul li {
    display: inline-block;
    list-style: none;
    margin: 0 15px;
}
nav ul li a {
    text-decoration: none;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    text-transform: uppercase;
    font-size: 15px;
    font-weight: 600;
}
#btn1 {
    text-transform: uppercase;
    background: linear-gradient(to bottom, #378de5 3%, #48789b 100%);
    border-radius: 30px;
    border: 1px solid #5e97d1;
    cursor: pointer;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 17px;
    font-weight: 700;
    padding: 12px 20px;
    margin: 10px;
    text-decoration: none;
    box-shadow: 1px 4px 12px rgba(94,28,68,.15);
    text-shadow: 0px 1px 0px #528ecc;
}
#btn2 {
    text-transform: uppercase;
    background: linear-gradient(to bottom, #cbcbcb 2%, #fff 100%);
    border-radius: 30px;
    border: 1px solid #cbcbcb;
    cursor: pointer;
    color: #5e97d1;
    font-family: 'Poppins', sans-serif;
    font-size: 17px;
    font-weight: 700;
    padding: 12px 20px;
    margin: 10px;
    text-decoration: none;
    box-shadow: 1px 4px 12px rgba(94,28,68,.15);
    text-shadow: 0px 1px 0px #cbcbcb;
}
.btn:hover {
    box-shadow: 3px 8px 22px rgba(94,28,68,.15);
    transform: scale(1.1);
    transition: .2s ease-in-out;
}
.content {
    position: relative;
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between;
}
.content .text {
    position: relative;
    max-width: 600px;
}
.content .text h1 {
    font-family: 'Poppins', sans-serif;
    text-transform: uppercase;
    font-weight: 800;
    margin-top: 80px;
    line-height: 1.5em;
    letter-spacing: .1em;
    font-size: 40px;
    color: #fff;
}
.content .text h1 span {
    font-size: 50px;
}
.content .text p {
    font-size: 17px;
    font-weight: 600;
    letter-spacing: .1em;
    margin-top: 40px;
    color: #e7e3e3;
 }
.btn3 {
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
}
.pepsi {
    display: flex;
    height: 100%;
    position: absolute;
    width: 600px;
    margin-top: 80px;
    padding-left: 440px;
    justify-content: flex-end;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!--img id = "am" src="img/img1.jpg" class="logo" alt="img"-->
            <nav>
                <ul>
                    <li><a href="landingpage.php">Home</a></li>
                    <li><a href="booking2.php">Booking</a></li>
                    
                    <li><a href="aboutus.html">About Us</a></li>
                </ul>
            </nav>
            
        </div>
        <div class="content">
            <div class="text">
            <h1>Be Smart, Relax,<br> <span>PARK NOW</span></h1>
            <p>No need to worry about parking places <br> View the slots, park on your desired place<br>Hassle Free and Safety of your vechile is all on us.
            </p>
            <form action="booking.html" method="get">
            <button class="btn3" type="submit">BOOK NOW</button>
            </form> 
           </div>
        <div class="pepsi">
        <img src="images/pepsi.png" alt="">
        </div>
       </div>
   </div>
</body>
</html>