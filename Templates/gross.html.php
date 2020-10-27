<h1>
Gross Total Income will be Updated after the new Payroll Cycle of Inputting Hours and any Disputes will be added 
    <?php foreach($users as $user) :?> 
    <fieldset>
        
<form method="post" action="">
    
  <div align="left" id="nametitle"><legend>Name: <?= $user->name ?></legend></div>

<!--<label for="gross_tax"> </label>
<!-- <input type="text" id="gross_tax" name="gross[gross_tax]"  value="-->
Gross Tax: <?= $user->getGross()->gross_tax ?? 0?></p> 

<!--<p><label for="gross_deduction"> </label>
 <input type="text" id="gross_deduction" name="gross[gross_deduction]"  value="-->
 Gross Deduction: <?= $user->getGross()->gross_deduction ?? 0?>
<br>
<!--<label for="total_income"></label>
 <input type="text" id="total_income" name="gross[total_income]"   value=" "></p> -->
Total Income: <?= $user->getGross()->total_income ?? 0?>

	
</form> 	
</fieldset>
<?php endforeach; ?>