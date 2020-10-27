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
<p>Payroll Processing Cycle is 2 checks per month. First cycle will start on the first day of the month. The last cycle will start on the last day of the month. </p>
<form method="post" action="">
<h1>
<label for="name">Name</label>
<input type="text" id="name" name="hours[name]"  value="<?= $hours['name'] ?? ''?>">


<label for="date">Start date:</label>

  Pay Date:  <input type="date" id="date" name="hours[date]"
      value="<?= $hours['date'] ?? '2019-01-01'?>"
       min="2019-01-01" max="2040-01-01">                                                                                           

<!-- <p><label for="quantity">Quantity</label>
<input type="text" id="quantity" name="hours[quantity]"   value="<//?=// $hours['quantity'] ?? ''?>"></p> -->
			
<input type="submit" name="process"
	value="Process"></h1>
	</form> 
	
