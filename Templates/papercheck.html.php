<?php if($recalculate == false) : ?> 
<form action="index.php?route=payroll/printer" method="post">
      <input type="hidden" name="date" value="<?=$date?>">
        <input type="submit" value="Print PDF">
         </form>
<?php endif; ?>                                                                                

         
	<div style="text-align: right">
<form action="index.php?route=payroll/recalculate" method="post">
    	Begin Date:	
       <input type="date" id="start" name="start_date"
       value=<?= $start_date ?? "2019-01-01"?> 
       min="2019-01-01" max="2040-01-01">
         End Date:  <input type="date" id="end" name="end_date"
        value=<?= $end_date ?? "2019-01-01"?> 
          min="2019-01-01" max="2040-01-01">
        <input type="submit" value="Recalculate">
         </form></div>
         
  
<form  method="post" action="">
<div  class = "whiteback" align="justify">
     <?php if($recalculate == false) : ?>
    <input type="submit" name="enter"
	value="Submit Date For PayCheck Information">
Pay Date:  <input type="date" id="start" name="date"
       value=<?= $date ?? "2019-01-01"?> 
       min="2019-01-01" max="2040-01-01">
 <?php endif; ?> 
 
<?php if($valid) : ?>

 <?php 
 /*                                            //This code worked out the overtime but then it was found, that after a dispute, the overtime fields will not work; so I added a new overtime field in check table to avoid all this code
 if(isset($check->quantity))
 {
      $time = explode(':', $check->quantity);
 }
 else
{
      $time = explode(':', $rcheck['quantity']);
}

   $hoursworked = $time[0];   $minutes = $time[1];    $quantity = $hoursworked + ($minutes/60);
    
    $amount = $quantity * $payroll->rate;
    
    
     if(isset($check->amount))
 {
      $checkamount = $check->amount;
 }
 else
{
      $checkamount = $rcheck['amount'];
}

    
    
    if($amount < $checkamount)
    {
        $decrement = $checkamount - $amount;
        
       $weight  = $decrement * 1.5 * $payroll->rate;
       
       $decrement = $checkamount - $weight;
       
       if($decrement > $weight)
       {
    
       
         $decrement = $decrement - $weight;
         
          $decrement = $checkamount - $decrement;
         
       
       $overtime = $decrement/$payroll->rate;
       
       }
       else
       {
       
           $decrement = $weight - $decrement;
         
            $decrement = $checkamount + $decrement;
                $overtime = $decrement/$payroll->rate;
            
           
       }

    }
    else
    {
          $overtime = 0;
    }
    */
     ?>

	
<pre>
<fieldset>
<legend>
General Information                                          Pay Frequency Weekly (24 Pay Periods)</legend>
Employee: <?= ucwords($_SESSION['username']) ?> 
                                                                                                                                                          
Check # <?= $check->id ?? ''?>     <?php if($recalculate == false) : ?> 
       <?php else :?>
       <?= 'Check dates found: ' ?>
	<?php foreach($dates as $date) :?>
	    <?=$date?>
		<?php endforeach; ?>
    <?php endif; ?>                                                                                

<fieldset>
<legend>
Income Details
Income:<?= $payroll->income ?? ''?>         Rate:<?= $payroll->rate ?? ''?>         Type:<?= $payroll->income ?? ''?>        Quantity: <?= $check->quantity ?? ''?><?= $rcheck['quantity'] ?? ''?>       Amount:<?= $check->amount ?? ''?><?= $rcheck['amount'] ?? ''?>  Gross Pay: <?php $grosstotalincome = isset($gross->total_income) ? number_format($gross->total_income,2) : ' '; echo $grosstotalincome ?>


</legend>
</fieldset>
Overtime: <?= $check->overtime ?? ' ' ?><?= $rcheck['overtime'] ?? ''?>
<fieldset>
<legend>
Tax Details                                                                                 Deduction Details</legend>
<legend>Tax:                            Amount:               Gross:                        Deduction:         Amount:       Gross:      Cap: </legend> 
 
<p>Federal Income Tax                 <?= $tax_deduction->federal_income_tax ?? '    '?>                  <?= $gross_federal_income_tax ?? ''?>                      Health Insurance         <?= $tax_deduction->health_insurance ?? ' '?>         <?= $gross_health_insurance ?? ''?></p>
<p>Social Security                    <?= $tax_deduction->social_security ?? '     '?>                <?= $gross_social_security ?? ''?>                         401K            <?= $tax_deduction->four01K ?? '    '?>             <?= $gross_four01K ?? ''?>      $9,500</p>
<p>Medicare                           <?= $tax_deduction->medicare ?? '       '?>               <?= $gross_medicare ?? ''?>                         401K Employer   <?= $tax_deduction->four01K ?? '    '?>                 <?= $gross_four01K ?? ''?>     $9,500</p>
<p><?= trim(explode(',', $payroll->division)[0]) ?> State Income Tax        <?= $tax_deduction->state_income_tax ?? '    '?>              <?= $gross_state_income_tax ?? ''?>                     Health Insurance Employer <?= $tax_deduction->health_insurance ?? ' '?>        <?= $gross_health_insurance ?? ''?>       </p>
<p><?= trim(explode(',', $payroll->division)[1]) ?> Local Income Tax       <?= $tax_deduction->city_income_tax ?? '     '?>             <?= $gross_city_income_tax ?? ''?>                 Dental Health Insurance   <?= $tax_deduction->dental_health_insurance ?? ' '?>           <?= $gross_dental_health_insurance ?? ''?>        </p>
<p>                                                                           Employer Dental Health Insurance      <?= $tax_deduction->dental_health_insurance ?? ' '?>          <?= $gross_dental_health_insurance ?? ''?> </p>

</fieldset>





<fieldset>
    <legend>Check Summary</legend>
            <legend>                  Total Incomes:                   Total Taxes:                        Total Deduction:                 Net Pay: </legend>
<p>This Check:              <?= $check->amount ?? ''?><?= $rcheck['amount'] ?? ''?>                          <?= $net_tax ?? ''?>                                     <?= $net_deduction ?? ''?>                      <?= $net_pay ?? ''?></p>

<p>Gross:                   <?= $gross->total_income ?? ''?>                       <?= $gross->gross_tax ?? ''?>                                     <?= $gross->gross_deduction ?? ''?>                    <?= $net_total_income ?? ''?></p>
</fieldset>



<?php else :?>
	<div class = "errors"><p> <?= $_SESSION['username'] ?>  did not work on that day. Are you sure that day is correct? </p>

<?php endif; ?>


</pre>
</div>


</form>


