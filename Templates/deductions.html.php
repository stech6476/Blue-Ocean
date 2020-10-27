<style>
    .parent = {
         text-align:center;
      
    }
    .block {
       
        display: inline-block;
        font-size: 25px;
        text-align:center;
      
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
<p>For info, go to https://www.democratandchronicle.com/story/news/politics/albany/2019/08/12/health-insurance-rates-new-york-how-much-theyll-rise-2020/1984137001/</p>
<p>Our Excellus Health Insurance Premium will be $440 per month. 50% will be matched by employer. </p>

<p>Our 401K package is matched by employer at the same amount. Capping at $19,000 for 2019. (Employee Matches Duplicate Rate)</p> 
<h1>
    <?php foreach($users as $user) :?> 
   
    <fieldset>
        
<form method="post" action="">
    
  <div align="left" id="nametitle"><legend>Name: <?= $user->name ?></legend></div>
 

     <?php if($user->getPayroll()->health_insurance == null) :?>  
     Not Eligible Currently
     <?php else : ?>
     <div class= "block" >
<label for="package"><span>Choose The Health Insurance Package</span></label>
				
				<select id="package" name="deduction[health_insurance]" size="4" multiple>
					<optgroup label="Gold">
						<option value= 0.20     <?php if($user->getPayroll()->health_insurance == 0.20)
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>  >20%</option>
					</optgroup>
					<optgroup label="Bronze">
						<option value= 0.40      <?php if($user->getPayroll()->health_insurance == 0.40)
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >40%</option>
					</optgroup>
					<optgroup label="Silver">
						<option value= 0.30    <?php if($user->getPayroll()->health_insurance == 0.30)
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >30%
						 </option>
					</optgroup>
				
					<optgroup label="None">
						<option value= 0.0    <?php if($user->getPayroll()->health_insurance == 0.0)
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >0%
						 </option>
					</optgroup>
					
				</select>
				


<label for="four01K">401K: </label>
<!-- <input type="text" id="four01K" name="deduction[four01K]"   value="<//?=// $user->getPayroll()->four01K ?? .00?>"></p> -->

<?php //$rateMax = (19000/2)/($user->getPayroll()->rate * 52 * 40); $rateMax = bcdiv($rateMax, 1, 10);  $maxRate = intval($rateMax*10000000000); $maxRate = $maxRate/100000000; $ratemax = intval($rateMax * 100); $rate = range(1, $ratemax); ?>

<?php  if($user->getPayroll()->income == "Regular Hourly Pay")
     { 
        $rateMax = (19000/2)/($user->getPayroll()->rate * 52 * 40);
     }
     else
     {
       $rateMax = (19000/2)/($user->getPayroll()->rate * 52 * 20);
     } 
     
     $rateMax = bcdiv($rateMax, 1, 10);  $rateMax = intval($rateMax*10000000000); $rateMax = $rateMax/100000000;  $rate = range(1, $rateMax); ?>
<select name= "deduction[four01K]">
   
     <option value = 0.0  <?php if(($user->getPayroll()->four01K <= 0.0000000000))
                                                                                            {
                                                                                                
                                                                                            echo 'selected="selected"';
                                                                                            
                                                                                            } ?>  >0%</option>;
                                                                                            
                                                                                            
   <?php foreach($rate as $value) {
      if($user->getPayroll()->four01K *100 == $value)
      {
          echo "<option value=\"$value\" selected> $value%    </option>\n";  
      }
      else
      {
           echo "<option value=\"$value\"> $value%    </option>\n";  
      }
                                                                         
    } ?>
    <option value= <?= $rateMax ?>   <?php if(($user->getPayroll()->four01K * 100) == $rateMax)
                                                                                            {
                                                                                                
                                                                                            echo 'selected="selected"';
                                                                                            
                                                                                            } ?>>
           <?= $rateMax . '%' ?></option>;
</select>
  
	<label for="dental_health_insurance"><span>Choose The Dental Plan</span></label>
				
				<select id="dental_health_insurance" name="deduction[dental_health_insurance]" size="4" multiple>
					<optgroup label="High">
						<option value= 0.06     <?php if($user->getPayroll()->dental_health_insurance == 0.06 )
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>  >6%</option>
					</optgroup>
					<optgroup label="Low">
						<option value= 0.03      <?php if($user->getPayroll()->dental_health_insurance == 0.03)
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >3%</option>
					</optgroup>
					
				</select>

<input type="hidden" name="deduction[id]" value="<?= $user->id ?>">
</div>

<input type="submit" name="process"
	value="Process" <?php if(isset($name) && ($name == $user->name)){ echo 'autofocus';} ?>>
	
</form> 	
</fieldset>
<?php endif; ?>
<?php endforeach; ?>
			
</h1>