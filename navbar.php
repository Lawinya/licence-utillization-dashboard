<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 250px;
  background-color: #333;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: white;
  padding: 16px;
  text-decoration: none;
  background-color: #222; 
  
}
.sidebar{
  padding-top: 20px;
}

.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555; /* Background color on hover */
  color: white;
 
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

.logo {
  padding: 16px;
  text-align: center;
}

.logo img {
  width: 80%; 
  /* border-radius: 50%;  */
}


@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}

  .logo{
    display: none;
  }
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
</style>
</head>
<body>

<div class="sidebar">
  <div class="logo">
    <img src="./img/logo.png" alt="Logo">
  </div>
  <a href="./"><i class="fa fa-plus" style="font-size:24px; padding-right:10px"></i>Add colleges-courses</a>
  <a href="./display.php"><i class="fa fa-list" style="font-size:20px; padding-right:10px"></i>List of colleges</a>
  <a href="./charts.php"><i class="fa fa-bar-chart-o" style="font-size:20px; padding-right:10px"></i>visual data </a>
  
</div>

</body>
</html>
