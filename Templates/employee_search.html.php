<style>
    table th { border-bottom: 1px solid #ccc; padding: 0.5em; }
    table td { border-bottom: 2px solid #000; padding: 0.5em; }
</style>

<table
	<thead>
    <th></th>
	<th>Name</th>
	<th>Email</th>
	<th>Phone</th>
	<th>Rate</th>
	<th>Salary</th>
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
		
<?php foreach($users as $user) :?>  
<td style="text-align: left"> <a href = "index.php?route=payroll/employee_edit&amp;id=<?=$user->id?>">Edit</td>
 
    <td><?= $user->name ?></td>
    <td><?= $user->email ?? 'unregistered' ?></td>
    <td><?= $user->phone ?></td>
     <td><?= $user->getPayroll()->rate ?></td>
     <td><?php if($user->getPayroll()->income == "Regular Hourly Pay")
     { 
         echo number_format($user->getPayroll()->rate * 52 * 40, 2); 
     }
     else
     {
        echo "P.T. " . number_format($user->getPayroll()->rate * 52 * 20, 2); 
     }
     
     
     ?></td>
    <td><?= "                         " ?></td>
  <td><?= $user->address ?></td>
  <td><?= $user->note ?></td>
  <td><?php $arr = explode("\n",$user->payment_method); echo $arr[0]; ?></td>
  <td><?= $user->getPayroll()->federal_income_tax * 100 . '%' ?></td>
  <td><?= $user->getPayroll()->social_security * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->medicare * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->state_income_tax * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->city_income_tax * 100 . '%'; ?></td>
  <td><?= $user->getPayroll()->health_insurance ?? 'unregistered' ?></td>
  <td><?= $user->getPayroll()->dental_health_insurance ?? 'unregistered'  ?></td>
  <td><?= $user->getPayroll()->four01K ?? 'unregistered' ?></td>
  <td><?= $user->getPayroll()->division; ?></td>
     <td style="text-align: right">
				<form action="index.php?route=payroll/employee_delete" method="post">
					<input type="hidden" name="user[id]"
					value="<?=$user->id?>">
					<input type="submit" value="Delete">
					</form>
	</td>
    </tr>
   </tbody>
<?php endforeach; ?>   
</table>

	

