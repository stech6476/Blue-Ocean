<?php 
if(!empty($errors)) :
	?>
	<div class = "errors">
		<p>Error Processing, please check the following: </p>
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
<form action="" method="post">
<?php if($reset == true) :?>


<p><label for="email"> Enter Your Email Address</label>
<input name="user[email]" id="email" type="text" value=""></p>
<input type="hidden" name="user[emailreset]"	value="<?=true?>">

<?php else: ?>
<p><label for="name">Your Username</label>
<?= $user->name ?></p>

<p><label for="password">Password</label>
<input name="user[password]" id="password" type="text" value=" "></p>

<!--<input type="hidden" name="user[id]"	value="<//?=$user->id?>"> !-->
<input type="hidden" name="user[name]"	value="<?=$user->name?>">
<input type="hidden" name="user[emailreset]"	value="<?=false?>">
<?php endif; ?>					
<input type="submit" name="Reset Passsword"  
	value="Reset Passsword">

</form>