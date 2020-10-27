<?php

function autoloader($classname)
{
	$filename = str_replace('\\', '/', $classname) . '.php';
	
	$file = __DIR__  . '/../Classes/' . $filename;         //Autoload any classes in the Classes directory
	include $file; 
	
}
spl_autoload_register('autoloader');

define('LIVE', FALSE);
	
	
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars){
	    
	    
	    
	    $message = "An error occured in script '$e_file' on line $e_line: $e_message\n";
	    
	    
	    $message .= print_r ($_vars, 1);
	    
	    
	    if(!LIVE) { //Development
	        echo '<pre>' . $message . "\n";
	        debug_print_backtrace();
	        echo '</pre><br>';
	    } else { 
	        echo '<div class="error"> A system error occured. We apologize for the inconvenience. </div><br>';
	    }
	        
}
	    
//set_error_handler('my_error_handler');