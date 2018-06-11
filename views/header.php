<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>We Knect!</title>
        <link rel="shortcut icon" type="image/x-icon" href="https://images.vexels.com/media/users/3/142679/isolated/preview/1404b94cb84c9f989e9453559d81427b-k-isotipo-de-letra-origami-by-vexels.png">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
        <script>
        
         consoleText(['Hello World.', 'Console Text', 'Made with Love.'], 'text',['tomato','rebeccapurple','lightblue']);

function consoleText(words, id, colors) {
  if (colors === undefined) colors = ['#fff'];
  var visible = true;
  var con = document.getElementById('console');
  var letterCount = 1;
  var x = 1;
  var waiting = false;
  var target = document.getElementById(id);
  target.setAttribute('style', 'color:' + colors[0]);
  window.setInterval(function() {

    if (letterCount === 0 && waiting === false) {
      waiting = true;
      target.innerHTML = words[0].substring(0, letterCount);
      window.setTimeout(function() {
        var usedColor = colors.shift();
        colors.push(usedColor);
        var usedWord = words.shift();
        words.push(usedWord);
        x = 1;
        target.setAttribute('style', 'color:' + colors[0]);
        letterCount += x;
        waiting = false;
      }, 1000);
    } else if (letterCount === words[0].length + 1 && waiting === false) {
      waiting = true;
      window.setTimeout(function() {
        x = -1;
        letterCount += x;
        waiting = false;
      }, 1000);
    } else if (waiting === false) {
      target.innerHTML = words[0].substring(0, letterCount);
      letterCount += x;
    }
  }, 120);
  window.setInterval(function() {
    if (visible === true) {
      con.className = 'console-underscore hidden';
      visible = false;

    } else {
      con.className = 'console-underscore';

      visible = true;
    }
  }, 400);
}
        </script>
	<!-- css -->
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
        
        <style>
          
 
            .logo1 {
                width: 30%;
                display: block;
                margin-left: auto;
                margin-right: auto;

             

            }
                
            body {
                background-image: url(https://i.imgur.com/KKIhQt0.jpg);
                background-size: 2500px 1500px;

  background-repeat: no-repeat;


}

.panel-body, .form-group {
    color: black;
}



.tabla, h1, h4, p, label, h2, th, .help-block {
      color: white;
  text-shadow: 1px 1px 1px #000000;
}

.td1:hover {
    background-image: url(https://i.imgur.com/BFThu6q.jpg);
    background-repeat: no-repeat, repeat;
    background-size: 100% 100%;
}

.wekn {
     text-align: center;
}

.logreg {
     text-align: center;
}
.cf:before,
.cf:after {
  content: " ";
  display: table;
}

.cf:after {
  clear: both;
}

.cf {
  *zoom: 1;
}

/* Mini reset, no margins, paddings or bullets */
.menu, .submenu {
 
  margin: 0;
  padding: 0;
  list-style: none;
}

/* Main level */
.menu {			
  margin: 50px auto;
  width: 800px;
  /* http://www.red-team-design.com/horizontal-centering-using-css-fit-content-value */
  width: -moz-fit-content;
  width: -webkit-fit-content;
  width: fit-content;	
}

.menu > li {
  background: #34495e;
  float: left;
  position: relative;
  transform: skewX(25deg);
}

.menu a {
  display: block;
  color: #fff;
  text-transform: uppercase;
  text-decoration: none;
  font-family: Arial, Helvetica;
  font-size: 14px;
}		

.menu li:hover {
  background: #e74c3c;
}		

.menu > li > a {
  transform: skewX(-25deg);
  padding: 1em 2em;
}

/* Dropdown */
.submenu {
    text-align: center;
  position: absolute;
  width: 200px;
  left: 50%; margin-left: -100px;
  transform: skewX(-25deg);
  transform-origin: left top;
 
}

.submenu li {
  background-color: #34495e;
  position: relative;
  overflow: hidden;		
}						

.submenu > li > a {
  padding: 1em 2em;			
}

.submenu > li::after {
  content: '';
  position: absolute;
  top: -125%;
  height: 100%;
  width: 100%;			
  box-shadow: 0 0 50px rgba(0, 0, 0, .9);			
}		

/* Odd stuff */
.submenu > li:nth-child(odd){
  transform: skewX(-25deg) translateX(0);
}

.submenu > li:nth-child(odd) > a {
  transform: skewX(25deg);
}

.submenu > li:nth-child(odd)::after {
  right: -50%;
  transform: skewX(-25deg) rotate(3deg);
}				

/* Even stuff */
.submenu > li:nth-child(even){
  transform: skewX(25deg) translateX(0);
}

.submenu > li:nth-child(even) > a {
  transform: skewX(-25deg);
}

.submenu > li:nth-child(even)::after {
  left: -50%;
  transform: skewX(25deg) rotate(3deg);
}

/* Show dropdown */
.submenu,
.submenu li {
  opacity: 0;
  visibility: hidden;			
}

.submenu li {
  transition: .2s ease transform;
}

.menu > li:hover .submenu,
.menu > li:hover .submenu li {
  opacity: 1;
  visibility: visible;
}		

.menu > li:hover .submenu li:nth-child(even){
  transform: skewX(25deg) translateX(15px);			
}

.menu > li:hover .submenu li:nth-child(odd){
  transform: skewX(-25deg) translateX(-15px);			
}

.breadmiga {
    z-index: -11;
}

.tabla {
    z-index: 0 ;
}

<!--HELLOMOD-->

        </style>


</head>
<body>
   
 <img class="logo1" src="http://www.solidrockassembly.ca/wp-content/uploads/2018/02/Connect-Logo-top1.png">

 
 
 <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">


 
 
 
 
 <ul class="menu cf">
  <li><a href="<?= base_url() ?>">Home</a></li>
  <li>
      <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
  <a href="">Area Usuario</a>
                                 
    <ul class="submenu">
        <?php if ($_SESSION['is_admin'] === true) : ?>
      <li><a href="<?= base_url('index.php/admin') ?>">Administrar foro</a></li>
      <?php endif; ?>
           
      <li><a href="<?= base_url('index.php/user/' . $_SESSION['username']) ?>">Perfil</a></li>
       

    </ul>			
  </li>
  <li><a href="<?= base_url('index.php/logout') ?>">Logout</a></li>
  
           <?php else : ?>
  <li><a href="<?= base_url('index.php/login') ?>">Login</a></li>
  <li><a href="<?= base_url('index.php/register') ?>">Registrarse</a></li>
  <?php endif; ?>
</ul>



	<main id="site-content" role="main">
		
<!--		
		<?php if (isset($_SESSION)) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php var_dump($_SESSION); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
-->
		
