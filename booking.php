<?php 
  include'db.php';
  if(isset($_POST['submit'])){
    $varid = "<script>document.writeln(ida);</script>";
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
    <link rel="stylesheet" href="stylebooking.css">



</head>
<body>

<div class="about-section">
  <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"> BOOK NOW SERGEANT </h1>
  <p>Here we go!!! Click and Book</p>
  <p> Just few simple steps</p>
</div>
   
  </div>

  <div class="column">
    <div class="card">
      
      <div class="container">
        <h1><p id="dt">Date : <span id="date"></span></p>

            <script>
            var dt = new Date();
            document.getElementById("date").innerHTML = dt.toLocaleDateString();
            </script></h1>               
        
        
         </div>
    </div>
  </div>
  
  <select id="sele"  style="width:200px;">
    <option value="0">Select Time Slot</option>
    <option value="1">9-11 am</option>
    <option value="2">11-1 am</option>
    <option value="3">1-3 pm</option>
    <option value="4">3-5 pm</option>
    <option value="5">5-7 pm</option>
    
  </select>

  <br><br><br><br><br><br><br>
  <form>
        <button id="abcd" type="submit" name="submit">Submit</button>
        
      </form> 
  <table id="parking"></table>
    <script>
      var ida = "0";
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
      }
      
    </script>
    <script>
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
          
          
        };
      }
      function fun(){
        var acc = document.getElementsByClassName("btn btn-danger fa fa-light fa-car");


      }
      
    </script>
   
  
</div>
      <form>
        <button id="abc" type="submit" name="submit">BOOK</button>
        
      </form> 
      


</body>
</html>

