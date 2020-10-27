<?php if($valid == false) :?>

    <div class = "errors"><p> <?= $_SESSION['username'] ?>  did not work on that day. Are you sure that day is correct? </p> </div>

<?php endif; ?>

<form method="post" action="">
<div class= "whiteback" align="justify">
    
    
    
    
     Pay Date:  <input type="date" id="start" name="date"
       value=<?php if(isset($check->date))
       {
           echo $check->date;
       }
       elseif(isset($date))
       {
           echo $date;
       }
       else
       {
           echo "2019-01-01";
       }
       
      ?> 
       min="2019-01-01" max="2040-01-01">                                                                                             End Date:
       
<input type="submit" name="submit"
	value="Submit Date For PayCheck Information"></div>
</form>