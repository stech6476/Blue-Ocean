<style>
  form { display: table-cell; width: 100%; }
  
  label {display: table-cell; width: 50%; border-bottom: 1px solid #ccc; padding: 0.5em; }
  
</style>
    


<?php 
if(!empty($errors)) :
	?>
	<div class = "errors">
		<p>Your account could not be created, please check the following: </p>
		<ul>
		<?php 
		foreach($errors as $error) :
		?>
		<li><?= $error ?></li>
		<?php 
		endforeach; ?>
		</ul>
	</div>
<?php
endif;
?>

<h3>
<form action="" method="post">
<p><label for="email">Your Email Address</label>
<input name="users[email]" id="email" type="text"  pattern="\w{1,30}" value="<?= $user['email'] ?? ' '?>"></p>

<p><label for="name">Your Username</label>
<input name="users[name]" id="name" type="text" pattern="\w{1,30}" value="<?= $user['name'] ?? ' '?>"></p>

<p></p><label for="password">Password</label>
<input name="users[password]" id="password" type="text"  pattern="\w{1,30}" value="<?= $user['password'] ?? ' '?>"></p>


<input type="submit" name="submit"  
	value="Register account"></h3> 
	
</form>
					
					