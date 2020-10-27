<style>
    table {display: table-cell; width: 100%; border-bottom: 1px solid #ccc; padding: 0.5em; }
    table td { display: table-cell; width: 50%; border-bottom: 2px solid #000; padding: 0.5em; }
</style>

<h4>
<table>
	<thead>
	<th>Name</th>
	<th>Email</th>
	<th>Edit</th>
	</thead>
	
	<tbody>
	<?php foreach($users as $user): ?>
	<tr>
		<td><?= $user->name?></td>
		<td><?= $user->email?></td>
		<td>
	<a href="index.php?route=user/permissions&amp;id=<?=$user->id;?>">Edit Permissions</a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</h4>
