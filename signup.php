<?php
$err=false;
$err1=false;
$err2=false;
if(isset($_POST['submit'])){
  include 'db.php';
    echo "hello";
    $username1=$_POST["uname"];
    $password1=$_POST["password"];
    $email=$_POST["email"];
    $name=$_POST["name"];
    $phonenumber=$_POST["phoneNumber"];
    $existSql="SELECT * FROM `user` WHERE username='$username1'";
    $result1=mysqli_query($conn,$existSql);
    $numexistRows=mysqli_num_rows($result1);
    if($numexistRows>0){
        ?>
        <script>
          alert("username already exist");
          </script>
      <?php
        
    }
    else{
        
            $sql="INSERT INTO `user` (`username`, `name`, `email`, `password`, `phone`) VALUES ('$username1', '$name', '$email', '$password1', '$phonenumber');";
            $result=mysqli_query($conn,$sql);
            
            if($result){
               header("location: login.php");
            }
            else{
              ?>
        <script>
          alert("ha exist");
          </script>
      <?php
            }
    
        
        
    }
    

}
?>
<style>
    * {
    margin: 0
  }
  
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh;
    background-color: #6699cc;
  }
  
  .container h1 {
    color: white;
    font-family: sans-serif;
    margin: 20px;
  }
  
  .registartion-form {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 600px;
    color: rgb(255, 255, 255);
    font-size: 18px;
    font-family: sans-serif;
    background-color: #154a68;
    padding: 20px;
  }
  
  .registartion-form input,
  .registartion-form select,
  .registartion-form textarea {
    border: none;
    padding: 5px;
    margin-top: 10px;
    font-family: sans-serif;
  }
  
  .registartion-form input:focus,
  .registartion-form textarea:focus {
    box-shadow: 3px 3px 10px rgb(228, 228, 228), -3px -3px 10px rgb(224, 224, 224);
  }
  
  .registartion-form .submit {
    width: 100%;
    padding: 8px 0;
    font-size: 20px;
    color: rgb(44, 44, 44);
    background-color: #ffffff;
    border-radius: 5px;
  }
  
  .registartion-form .submit:hover {
    box-shadow: 3px 3px 6px rgb(255, 214, 176);
  }
  </style>
  
  
  
  <!DOCTYPE html>
  <html lang="en" >
  <head>
  <meta charset="UTF-8">
  <title>Sign Up Signin Form Template Example</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  
  <script>
    // Select all input elements for varification
  
  
  
  // function for form varification
  function formValidation() {
    var Email = document.getElementById("email");
    var Password = document.getElementById("password");
    var PhoneNumber = document.getElementById("phoneNumber");
    var Gender = document.registration;
    var Language = document.getElementById("language");
    var Zipcode = document.getElementById("zipcode");
  // checking name length
  //   if (name.value.length < 2 || name.value.length > 20) {
  //     alert("Name length should be more than 2 and less than 21");
  //     name.focus();
  //     return false;
  //   }
  // checking email
  if (!Email.value.match(/^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/)) {
    alert("Please enter a valid email!");
    Email.focus();
    return false;
  }
  // checking password
  if (!Password.value.match(/^.{5,15}$/)) {
    alert("Password length must be between 5-15 characters!");
    Password.focus();
    return false;
  }
  // checking phone number
  if (!PhoneNumber.value.match(/^[1-9][0-9]{9}$/)) {
    alert("Phone number must be 10 characters long number and first digit can't be 0!");
    PhoneNumber.focus();
    return false;
  }
  // checking gender
  if (Gender.gender.value === "") {
    alert("Please select your gender!");
    return false;
  }
  // checking language
  if (Language.value === "") {
    alert("Please select your language!")
    return false;
  }
  // checking zip code
  if (!Zipcode.value.match(/^[0-9]{6}$/)) {
    alert("Zip code must be 6 characters long number!");
    Zipcode.focus();
    return false;
  }
  return true;
  }
  </script>
  
  </head>
  <body>
  <div class="container">
    <h1> Register Yourself to BOOK YOUR SLOT NOW</h1>
    <form name="registration" class="registartion-form" action="signup.php" method="post">
      <table>
      <tr>
          <td><label for="name">Username:</label></td>
          <td><input type="text" name="uname" id="uname" placeholder="please set username" required></td>
        </tr>
        <tr>
          <td><label for="name">Name:</label></td>
          <td><input type="text" name="name" id="name" placeholder="enter your name" required></td>
        </tr>
        <tr>
          <td><label for="email">Email:</label></td>
          <td><input type="text" name="email" id="email" placeholder="enetr your email" required></td>
        </tr>
        
        <tr>
          <td><label for="password">Password:</label></td>
          <td><input type="password" name="password" id="password" placeholder="enter your password" required></td>
        </tr>
        <tr>
          <td><label for="phoneNumber">Phone Number:</label></td>
          <td><input type="number" name="phoneNumber"  id="phoneNumber" placeholder="enter your email" required></td>
        </tr>
        
        
               
        <tr>
          <td colspan="2"><input type="submit" class="submit" name="submit" id="submit" value="Register" onclick="formValidation()"/></td>
        </tr>
        <tr>
          <td> <a href="login.php"> Already an existing member?</a> </td>
        </tr>
      </table>
    </form>
  </div>
  </body>
  </html>