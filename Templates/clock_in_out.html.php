<?php

date_default_timezone_set('America/New_York');
$t = time();
$current_time = date('h:i:s', $t);

?>
<?php if(isset($done)) :?>
<h1>The time has been processed.</h1>
<?php endif; ?>	

<form action = "" method = "post">
<?php if(isset($clock) && ($clock->clock_in == NULL)) :?>
<h1> Please clock in your time. </h1>
<p>The time now is: <?= $current_time ?> </p>

<input type="hidden" name="CLOCK[in]"	value=<?= $current_time ?>>

<input type = "submit" name = "submit" value ="Clock In">

<?php elseif(isset($clock) && ($clock->clock_out == NULL) && ($done == false)) :?>

<input type="hidden" name="CLOCK[out]"	value=<?= $current_time ?>>
<p>The time now is: <?= $current_time ?> Do you want to clock out now? </p>
<p>Your start time was : <?= $clock->clock_in ?> </p>
<input type = "submit" name = "submit" value = "Clock Out">
<?php endif; ?>	

    


</form>