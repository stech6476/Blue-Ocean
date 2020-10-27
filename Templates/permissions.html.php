 <style>
    table {display: table-cell; width: 100%; border-bottom: 1px solid #ccc; padding: 0.5em; }
    table td { display: table-cell; width: 50%; border-bottom: 2px solid #000; padding: 0.5em; }
</style>




<h3>
    <form action =" " method="post">
<table>
	<thead>
	<th>Edit <?=$user->name?>'s Permissions </th>
	
	</thead>
	
	<tbody>
	<?php foreach($permissions as $name => $value) :?>
	<tr>
		<td><div>
<input name="permissions[]" type="checkbox" value="<?=$value?>"
<?php if($user->hasPermission($value)):                   //entity class is helping here with the hasPermissions function to check box the constants priveleges that the user already has priveleges to
   echo 'checked'; endif; ?> />
   <label><?=$name?>
   </div></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	  
  
    </form>
</table> <input type="submit" value="Submit" />
</h3>
