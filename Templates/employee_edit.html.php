<style>
    table th { border-bottom: 1px solid #ccc; padding: 0.5em; }
    table td { border-bottom: 2px solid #000; padding: 0.5em; }

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


<form action = " " method = "post">
<table
	<thead>
	<th>Name</th>
	<th>Email</th>
	<th>Phone</th>
	<th>Rate</th>
	<th>Social Security</th>
	<th>Address</th>
	<th>Note</th>
	<th>Payment Method</th>
	<th>Federal Income Tax</th>
	<th>Social Security Rate</th>
	<th>Medicare Rate</th>
	<th>State Income Tax Rate</th>
	<th>City Income Tax Rate</th>
	<th>Health Insurance Rate</th>
	<th>Dental Health Insurance Rate</th>
	<th>401K rate</th>
	<th>Division</th>
	</thead>
	<tbody>
    <tr>
	
   
<td><input id="name" pattern= "^[\s.]*([^\s.][\s.]*){1,30}$"  name="user[name]" value = "<?= $user->name ?>" ></input></td>
<td><input id="email"  name="user[email]" pattern = "(?![^@]{10})[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,10}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,3}[a-zA-Z0-9])?)*|unregistered" value = "<?= $user->email ?? 'unregistered' ?>" ></input></td>
<td><input name="user[phone]" id="phone" type="tel"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"  value="<?= $user->phone ?? ''?>"></td>
<td><input type="number" id="rate" name="payroll[rate]"	min="1" max="100" step="1" value="<?= $user->getPayroll()->rate ?? '15'?>" ></td>
<td><input name="user[social_security]" id="social_security" type="text" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}"  title="###-##-####" value="<?=''?>"></td>
<td><input name="user[address]" id="address" pattern= "^[\s.]*([^\s.][\s.]*){1,50}$" value="<?= $user->address ?? ''?>"></td>
<td><textarea id="note" name="user[note]" maxlength = "20" rows="9" cols="35"><?= $user->note ?></textarea></td>
<td> 				<input type="radio" id="payment_method" name="user[payment_method]" value="Check" <?php $arr = explode("\n",$user->payment_method); if($arr[0] == "Check")
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="payment_method">Check</label><br>
				
				
				<input type="radio" id="payment_method" name="user[payment_method]" value="direct_deposit"  <?php  $arr = explode("\n",$user->payment_method); if($arr[0] == "Direct Deposit")
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >
				<label for="payment_method">Direct Deposit</label><br>
			
					<label  for="routing number">
					Routing Number Number</label>
					<input type="text" id="routingnumber" name="user[routing number]"
						placeholder="Routing Number"
							size="50"   value="<?=''?>">
			
					<label for="check number">
					Check Number</label>
					<input type="text" id="checknumber" name="user[check number]"
						placeholder="Check Number"
							size="50"   value="<?=''?>">
			
</td>

  <td><?= $user->getPayroll()->federal_income_tax * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->social_security * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->medicare * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->state_income_tax * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->city_income_tax * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->health_insurance * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->dental_health_insurance * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->four01K * 100 . '%'; ?></td>
  
 <td><td><input type="radio" name="payroll[division]" id="division" value="New York, New York City" <?php if($payroll->division == "New York, New York City")
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >New York, New York City</td>
<td><input type="radio" name="payroll[division]" id="division" value="Pennsylvania, Scranton" <?php if($payroll->division == "Pennsylvania, Scranton")
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >Pennsylvania, Sranton</td>
<td><input type="radio" name="payroll[division]" id="division" value="New Jersey, Newark" <?php if($payroll->division == "New Jersey, Newark")
                                                                                            {
                                                                                                
                                                                                            echo 'checked="checked"';
                                                                                            
                                                                                            } ?> >New Jersey, Newark</td>
</td>
 <input type="hidden" name="payroll[id]" value="<?= $payroll->id ?>">
    </tr>
   </tbody>
</table>
<input type="hidden" name="user[id]" value="<?=$user->id?>">
<input  type="submit" name="submit" value="Add Edited Values">
</form>