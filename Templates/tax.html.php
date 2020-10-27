<style>
    .parent = {
         text-align:center;
      
    }
    .block {
       
        display: inline-block;
        font-size: 25px;
        text-align:left;
      
    }
    

</style>

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
<p>Go to https://www.nysac.org/files/NYSACTaxWhitePaper(1).pdf for New York taxes info.
<br>Go to https://smartasset.com/taxes/pennsylvania-tax-calculator  for Pennsylvania taxes info.
<br>Go to  https://smartasset.com/taxes/new-jersey-paycheck-calculator and https://taxfoundation.org/local-income-taxes-2019/ for New Jersey info.
</p>	

<h1>
    <?php foreach($users as $user) :?> 
    <fieldset>
      
<form method="post" action="">
  
  <div align="left" id="nametitle"><legend   >Name: <?= $user->name ?></legend></div>  
  <div class= "block" >
<label for="federal_income_tax">Federal Income Tax: </label>
<input type="number" id="federal_income_tax" name="tax[federal_income_tax]" min="0" max="0.9" step="0.00000001" value="<?= $user->getPayroll()->federal_income_tax ?? .10?>" >


<label for="social_security">Social Security: </label>
<input type="number" id="social_security" name="tax[social_security]" min="0" max="0.9" step="0.00000001" value="<?= $user->getPayroll()->social_security ?? .062?>">
</div>


<p style="font-size: 25px";>
<label for="medicare">Medicare: </label>
<input type="number" id="medicare" name="tax[medicare]"  min="0" max="0.9" step="0.00000001" value="<?= $user->getPayroll()->medicare ?? .0145?>">
</p>


<div class= "block" >
<label for="state_income_tax"><?= explode(',', $user->getPayroll()->division)[0] ?? ' '?> State Tax: </label>
<input type="number" id="state_income_tax" name="tax[state_income_tax]"  	min="0" max="0.9" step="0.00000001" value="<?= $user->getPayroll()->state_income_tax ?? 0?>">

<label for="city_income_tax"><?= explode(',', $user->getPayroll()->division)[1] ?? ' '?> Local Tax: </label>
<input type="number" id="city_income_tax" name="tax[city_income_tax]"
					min="0" max="0.9" step="0.00000001" value="<?= $user->getPayroll()->city_income_tax ?? 0?>" >
</div>

<input type="hidden" name="tax[id]" value="<?= $user->id ?>">


<br><input type="submit" name="process"
	value="Process" <?php if(isset($name) && ($name == $user->name)){ echo 'autofocus';} ?>>
	
</form> 	
</fieldset>
<?php endforeach; ?>
			
</h1>
	
	
