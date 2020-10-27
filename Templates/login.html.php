
<?php if(isset($error)){ ?>
<div class ="errors"> <?= $error ?> </div>
<?php } ?>

<form method="post" action="">
<div style="text-align:center"><h1>
<label for="name">Your name</label>
<input type="text" id="name" pattern= "\w{1,30}" name="user[name]"  value="<?= $user['name'] ?? ''?>">

<label for="password">Password</label>
<input type="text" id="password" pattern= "\w{1,30}" name="user[password]"   value="<?= $user['password'] ?? ''?>">
			
<input type="submit" name="login"
	value="Log in"></div></h1>
	</form> 
	
<h2><p style="text-align:center"> DON'T have an account?...Please register in our Great Website...Subscribers are needed...<a href = "index.php?route=user/register"> You can always register one?...</a></p></h1>
  <div style="text-align: right"> <a href = "index.php?route=user/password_reset&amp;id=<?= $user['id'] ?>">Forgot Password</a></div>