<!DOCTYPE html>
<html  lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
     
   <link rel="stylesheet"  type="text/css" href="css/flexstyle.css" >
 

</head>
<body class="default">
<nav class= "navbar navbar-inverse  navbar-fixed-top" role="navigation" style="background-color: #3d3634;">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div  class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           
            <a class="navbar-brand" href="#">

            </a>
        </div>
        
         <!-- Collect the nav links, forms, and other content for toggling -->
        <div  class="collapse navbar-collapse navbar-ex1-collapse">
            
            <ul  class="nav navbar-nav">
                
            
                   <li id="logo"><a href="index.php?route=payroll/home"><figure> <picture >

                            <source srcset="css/img/csi.jpg hd, css/img/CSC_430_Logo.png  299w" sizes="3.4vw"  media="(max-width: 1600px)">   <!-- laptop -->
                            <source srcset="css/img/csi.jpg hd,  css/img/orange.png  299w"  sizes="100vw" media="(max-width: 500px)"> <!-- galaxy phone -->
                                <!-- <figcaption><em>LOGO</em></figcaption> -->

                            <img src ="css/img/cat.jpg" alt="LOGO">

                        </picture> </figure></a></li>
		<li>   <!--	<li  class="active"><--><a href="index.php?route=payroll/home">Home</a></li>
                <li><a href="index.php?route=user/register">Register</a></li> 
			<!--	<li id="navRotate"><a href="index.php?route=user/view">View Users</a></li> -->
                <li><a href="index.php?route=payroll/divisions">Company Divisions</a></li>
                	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Check Functions<span class="caret"></span></a>
                <ul class="dropdown-menu">
    		    <li><a href="index.php?route=payroll/papercheck">Paper Check</a></li>
                 <li><a href="index.php?route=payroll/dispute_check">Dispute Check</a></li>
                 </ul>
                 </li>
			<!--  <li><a href = "index.php?route=payroll/clock_in_out">Clock In/Out</a></li> -->
			<li><a href = "index.php?route=payroll/notification">Notifications</a></li>
			
			    <li><a href = "index.php?route=payroll/clock_in_out">Clock In/Out</a></li>
			
				<?php if($loggedIn): ?>
				
					<?php if(($permissions <= 63) && ($permissions != 0)): ?>
					
					
			  	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">New Employee Functions<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?route=payroll/payroll_new_employee">New Employee Register</a></li>
			    <li><a href="index.php?route=payroll/deductions">Deductions</a></li>
				<li><a href="index.php?route=payroll/tax">Tax</a></li>
					<li><a href="index.php?route=payroll/gross">Gross</a></li>
                </ul>
            </li>
				
				
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Modify Employees<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    	<li><a href="index.php?route=payroll/employee_search">Employee Search</a></li> 
                    	<li><a href ="index.php?route=user/list">List of Registered Users</a></li>	
			            <li><a href ="index.php?route=payroll/retiree">Retiree</a></li>	
                </ul>
            </li>
				
				
				<li><a href="index.php?route=payroll/payroll_processing">Payroll Processing</a></li>
			
				<?php endif; ?>
				
				<li><a href="index.php?route=logout">Log Out</a></li>
				<li style="background-color:#000;" ><a href="index.php?route=payroll/home"><?=$_SESSION['username']?></a></li>
				<?php else: ?>
				<li><a href="index.php?route=login">Log In</a></li>
				<?php endif; ?>
               </ul> 
     
   
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet"  type="text/css" href="css/flexstyle.css" >


<script>

$(document).ready(function () {
        var url = window.location;
    // Will only work if string in href matches with location
        $('ul.nav a[href="' + url + '"]').parent().addClass('active');

    // Will also work for relative and absolute hrefs
        $('ul.nav a').filter(function () {
            return this.href == url;
        }).parent().addClass('active').parent().parent().addClass('active');
    });



</script>
<main>
    <?=$output?>
</main>

<footer class="footer">
    <div class="container">
        <p class="text-muted"><p>Copyright &copy; 2019</p>
    </div>
</footer>
</body>
</html>
