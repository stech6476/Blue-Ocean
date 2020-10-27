<?php

try {
	

include __DIR__ .'/../Safe/autoload.php';                                   //Autoload php saves code from using include "---" this file 


	$tab = $_GET['route'] ?? 'payroll/home';         //Route or tab will be either default payroll/home or whatever the user clicks that gets sends to the $_GET array

		
	$entryPoint = new \Framework\EntryPoint($tab, $_SERVER['REQUEST_METHOD'] ,new \Payroll\PayrollRoutes());
	//Notice we didn't "include _DIR__ . '../Classes/Framework/EntryPoint" because we don't need to, autoload.php autoloads any classes in the Classes Directory
	
	//_SERVER['REQUEST_METHOD'] is only two options $_GET or $_POST, at first it will be $_GET because the user didn't submit anything
	
		$entryPoint->run();    
	

}
catch (PDOException $e) {
		$title = 'An error occured';
		
		$output = 'Database error: ' .$e->getMessage() . 'in '     //If exception occurs it means database is offline
		. $e->getFile() . ':' . $e->getLine();
		echo $output;
}

?>