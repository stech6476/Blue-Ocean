<link rel="stylesheet"  type="text/css" href="css/employee.css" >
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
<div class="default" >
<form method="post" action="">
<h1>What amount from net pay do you want to negotiate?</h1>
<h1>Your disputed amount will be reviewed by HR soon.</h1>

<label for="amount"><span>Please Enter Amount </span></label>
				<input type="number" id="amount" name="dispute[amount]"
					min="1" max="1000000" step="1" value="<?= $dispute['amount'] ?? 0?>">  
					
<label for="check_number"><span>Please Check Number </span></label>
				<input type="number" id="check_number" name="dispute[check_number]"
					min="1" max="1000000" step="1" value="<?= $dispute['check_number'] ?? 0 ?>"> 				
					
					
				<p><label for="method">Add or Subtract</label>
 <input type="radio" name="dispute[method]" id="method" value="Add" <?php if((isset($dispute['method'])) && ($dispute['method'] == "Add") ||                                                                                                                                                                              !isset($submit))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?>>Add
 <input type="radio" name="dispute[method]" id="method" value="Subtract"  <?php if((isset($dispute['method'])) && ($dispute['method'] == "Subtract"))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?>>Subtract
</p>

	<fieldset><legend>
				<label for="note">
					Indicate your dispute followed by date of check number/check date.
				</label><br>
				<textarea id="note" name="dispute[note]" rows="1" cols="55"><?= $dispute['note'] ?? '' ?></textarea>
				</p></legend></fieldset>


<input type="submit" name="submit"
 value="Submit Disputed Amount">
</form>
</div>

