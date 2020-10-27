<link rel="stylesheet"  type="text/css" href="css/employee.css" >

<style>
    .parent = {
         text-align:center;
      
    }
    .block {
       
        display: inline-block;
        padding-left: 150px;
    }
    
    
</style>

<div class = "default">
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

<?php if(isset($standard_page)) : ?>
<form  action="" method="post">
    
<fieldset>
				<legend>Person Information</legend>
<p><label for="name">Your Name</label>
<input name="user[name]" pattern= "\w{1,30}" id="name" type="text" placeholder="Enter your full name."
							  value="<?= $user['name'] ?? ''?>"></p>

<p><label  for="phone">Your Phone</label>
<input name="user[phone]" id="phone" type="tel"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required value="<?= $user['phone'] ?? ''?>"><small> Format: 123-456-7890</small></p>


<p><label  for="social_security">Your S.S</label>
<input name="user[social_security]" id="social_security" type="text" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" required  title="###-##-####" value="<?= $user['social_security'] ?? ''?>"></p>

<p>
					<label  for="street">
					Address</label>
					<input type="text" pattern= "\w{1,30}" id="street" name="address[street]"
						placeholder="214 Holden Blvd"
							size="50"  value="<?= $address['street'] ?? ''?>">
				</p>
				<p>
					<label  for="city">
					City</label>
					<input type="text" pattern= "\w{1,10}" id="city" name="address[city]"
						placeholder="Staten Island"
							size="50"  value="<?= $address['city'] ?? ''?>">
				</p>
				<p>
					<label  for="state">
					State</label>
					<input type="text" pattern= "\w{1,10}" id="state" name="address[state]"
						placeholder="New York"
							size="50" value="<?= $address['state'] ?? ''?>">
				</p>
				<p>
					<label  for="zip">
					Zip Code</label>
					<input type="text" pattern= "\w{1,7}" id="zip" name="address[zip]"
						placeholder="10314"
							size="50" value="<?= $address['zip'] ?? ''?>">
				</p>
				</fieldset>
				
				
		<fieldset>
				<legend>Particulars</legend>
				<p>
					<span>Please check all that apply:</span><br>
					
						<p>
				<label for="choose_scale"><span>Please Enter Rate </span></label>
				<input type="number" id="rate" name="employee[rate]"
					min="1" max="100" step="1" value="<?= $employee['rate'] ?? '15'?>" >
			</p>
			
					<p><label for="income">Your Job Standard</label>
 <input type="radio" name="employee[income]" id="income" value="Regular Hourly Pay" <?php if((isset($employee['income'])) && ($employee['income'] == "Regular Hourly Pay") || !isset($submit))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >Regular Hourly Pay
                                                                                            
 <input type="radio" name="employee[income]" id="income" value="Part Time"  <?php if(isset($employee['income']) && ($employee['income'] == "Part Time"))
                                                                                    {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> > Part Time
</p>



<p>
				<span >Please choose the Division Where The Employee Will Work </span><br>
				<input type="radio" id="division" name="employee[division]" value="New York, New York City"  <?php if((isset($employee['division'])) && ($employee['division'] == "New York, New York City") ||                                                                                                                                                                              !isset($submit))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="division">New York, New York City</label><br>
				
				<input type="radio" id="division" name="employee[division]" value="Pennsylvania, Scranton"  <?php if((isset($employee['division'])) && ($employee['division'] == "Pennsylvania, Scranton"))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="division">Pennsylvania, Scranton</label><br>
				
				<input type="radio" id="division" name="employee[division]" value="New Jersey, Newark"  <?php if((isset($employee['division'])) && ($employee['division'] == "New Jersey, Newark"))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="divisions">New Jersey, Newark </label><br>
				

              


<fieldset>
				<legend>Checking</legend>
			<p>
				<span>Checking Information</span><br>
				<p>
				<span>Please choose the deposit type </span><br>
				
				
				<input type="radio" id="payment_method" name="user[payment_method]" value="check" <?php if((isset($user['payment_method'])) && ($user['payment_method'] == "check")  ||                                                                                                                                                                              !isset($submit))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="payment_method">Check</label><br>
				
				
				<input type="radio" id="payment_method" name="user[payment_method]" value="direct_deposit"  <?php if((isset($user['payment_method'])) && ($user['payment_method'] == "direct_deposit"))
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="payment_method">Direct Deposit</label><br>
				
				
				
				
				<p>
				<p>
					<label  for="routing number">
					Routing Number Number</label>
					<input type="text" id="routing number" name="user[routing number]"
						placeholder="Routing Number"
							size="30"   pattern= "\w{1,30}" value="<?= $user['routing number'] ?? ''?>">
				</p>
				<p>
					<label for="check number">
					Check Number</label>
					<input type="text" id="check number" name="user[check number]"
						placeholder="Check Number"
							size="30"  pattern= "\w{1,30}" value="<?= $user['check number'] ?? ''?>">
				</p>
			
			</fieldset>
			
				<fieldset><legend>
				<label for="note"><span>
					Indicate additional comments If Any
				</span></label><br>
				<textarea id="note" name="user[note]" maxlength = "30" rows="1" cols="55"><?= $user['note'] ?? ''?></textarea>
				</p></legend></fieldset>
</p>	


			
<input type="submit" name="submit"
 value="Submit New Employee Information">
</form>
<?php endif; ?>	



	<?php if(isset($deduction_page)) :?>


	<form  action="index.php?route=payroll/health_insurance_processing" method="post">
    
    <fieldset>
				<legend>Deduction Information</legend>
	
			<input type="checkbox" id="four01K" name="hemployee[four01K]"
					value="yes"   <?php if(isset($hemployee['four01K']) || !isset($submit))
                                                                                    {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?>>
					
					
			<label for="four01K">401K accepted or not accepted </label><br>
			
			<div class ="parent">
			<input type="checkbox" id="health_insurance" name="hemployee[health_insurance]"
					value="Yes"  <?php if(isset($hemployee['health_insurance']) || !isset($submit))
                                                                                    {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
					
					
			
			<label for="dental_health_insurance">Health insurance accepted or not accepted </label>
			
				
		
			<div class="block">
			<input type="checkbox" id="dental_health_insurance" name="hemployee[dental_health_insurance]"
					value="Yes"  <?php if(isset($hemployee['dental_health_insurance']) || !isset($submit))
                                                                                    {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
					
					
					
			<label for="dental_health_insurance">Dental health insurance accepted or not accepted </label>
			
		
			
			</div></div>
			
			<p>
				<label for="choose_scale"><span><?= $name ?> : Rate Is <?= $rate ?></span></label>
			
			</p>
			
			
<?php if(isset($salary)) :?>
<div class = "errors">
The Estimated Salary for is <?= $salary ?> <br>
The Estimated 24 period salary is: <?= $periodic_salary ?>
</div>
<?php endif; ?>
</span></p>


	<?php if(isset($salary)) :?>
 <?php $rateMax = (19000/2)/$salary;  $maxRate = intval($rateMax*10000000000); $maxRate = $maxRate/100000000; $ratemax = intval($rateMax * 100); $rate = range(1, $ratemax); ?>
 
Choose Your 401K Match: 
<select name="hemployee[four01KRate]" autofocus>
   
     <option value = NULL  <?php if((isset($hemployee['four01KRate'])) && ($hemployee['four01KRate'] == "NULL"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected="selected"';
                                                                                            
                                                                                            } ?>  ></option>;
                                                                                            
                                                                                            
   <?php foreach($rate as $value) {
      if((isset($hemployee['four01KRate'])) && ($hemployee['four01KRate'] == $value))
      {
          echo "<option value=\"$value\" selected> $value%    </option>\n";  
      }
      else
      {
           echo "<option value=\"$value\"> $value%    </option>\n";  
      }
                                                                         
    } ?>
    <option value= <?= $maxRate ?>   <?php if((isset($hemployee['four01KRate'])) && ($hemployee['four01KRate'] == $maxRate))
                                                                                            {
                                                                                                
                                                                                            echo 'selected="selected"';
                                                                                            
                                                                                            } ?>>
           <?= $maxRate . '%' ?></option>;
</select>	
<?php endif; ?>	


  <div = "parent">
				<label for="package"><span>Choose The Health Insurance Package</span></label><br>
				
				<select id="package" name="hemployee[package]" size="4" multiple>
					<optgroup label="Gold">
						<option value="Gold"     <?php if((isset($employee['package'])) && ($hemployee['package'] == "Gold"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>  >20%</option>
					</optgroup>
					<optgroup label="Bronze">
						<option value="Bronze"      <?php if((isset($hemployee['package'])) && ($hemployee['package'] == "Bronze"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >40%</option>
					</optgroup>
					<optgroup label="Silver">
						<option value="Silver"    <?php if((isset($hemployee['package'])) && ($hemployee['package'] == "Silver"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >30%
						 </option>
					</optgroup>
				</select>
				
				
				<div class="block">
				<label for="dentalpackage"><span>Choose The Dental Plan</span></label><br>
				
				<select id="dentalpackage" name="hemployee[dentalpackage]" size="4" multiple>
					<optgroup label="High">
						<option value="High"     <?php if((isset($hemployee['dentalpackage'])) && ($hemployee['dentalpackage'] == "High"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>  >6%</option>
					</optgroup>
					<optgroup label="Low">
						<option value="Low"      <?php if((isset($hemployee['dentalpackage'])) && ($hemployee['dentalpackage'] == "Low"))
                                                                                            {
                                                                                                
                                                                                            echo 'selected';
                                                                                            
                                                                                            } ?>   >3%</option>
					</optgroup>
					
				</select>
				
				<input type="submit" name="submit"
 value="Submit New Employee Deduction Information">
				</fieldset>
				</form>
				</div></div>

<?php endif; ?>	
