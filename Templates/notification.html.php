

<?php if(($notifications != null) || ($healthinsurance != null)) : ?>


<?php foreach($notifications as $notification) : ?> 
<?php if(($admin)) : ?> 
<p><?= $notification ?></p> 

 <td style="text-align: right">
				<form action="index.php?route=payroll/notification" method="post">
					<input type="hidden" name="notification"
					value="<?= $notification ?>">
					<input type="submit" value="Process">
					</form>

 
    <?php else : ?>
     <p><?= $notification ?> </p>
   
   <?php endif; ?> 
<?php endforeach; ?>  

<?php if(!empty($healthinsurance)) : ?>


  <p><?= $healthinsurance ?></p>
				<form action="index.php?route=payroll/health_notification" method="post">
				
					
					<input type="submit" value="Health Insurance Process">
					</form>
	
  
 
<?php endif; ?> 


<?php else : ?>
<h1>No Notification at the moment. </h1>
<?php endif; ?> 