<?php
namespace Payroll\Controllers;

use \Framework\DatabaseTable;     //must import right namespace for DatabaseTable, otherwise PHP will look for Payroll/DatabaseTable
use \Framework\Authentication; 

class PayrollController {                  //Controller for all payroll functions
	
	private $payrollTable;                 //Will use two database tables
	private $usersTable;
    private $checkTable;
	private $tax_deductionTable;
	private $grossTable;
	private $retireeTable;
    private $clock_in_clock_outTable;
    
    
	public function __construct(DatabaseTable $payrollTable, DatabaseTable $usersTable,  DatabaseTable $checksTable, DatabaseTable $tax_deductionTable, DatabaseTable $grossTable, DatabaseTable $retireeTable, DatabaseTable $clock_in_clock_outTable, Authentication $authentication) {
		
		$this->payrollTable = $payrollTable;
				
		$this->usersTable = $usersTable;
		
		$this->checksTable = $checksTable;
		
		$this->tax_deductionTable = $tax_deductionTable;
		
		$this->grossTable = $grossTable;
		
		$this->retireeTable = $retireeTable;
		
		$this->authentication = $authentication;
		
		$this->clock_in_clock_outTable = $clock_in_clock_outTable;
	
		
	}
	


public function home() {
	

	$title = 'Our Payroll';
		
		
		return ['template' => 'home.html.php', 'title' => $title];               //Simple function that returns 'template' variable that tells what HTML file to render for home page, and what its title will be all to the $page variable in EntryPoint.php
}

public function divisions() {
	

	$title = 'Our Divisions';
		
		
		return ['template' => 'divisions.html.php', 'title' => $title];
}

public function papercheck() {
	

	$title = 'Input Date';
    
    $valid = true;
    
	
		return ['template' => 'papercheck_getdate.html.php', 'title' => $title,
		'variables' =>
	       	[
		    'valid' => $valid,
		
	    	] ];
}


public function health_process_notification()
{
    $title = "Health Notification";
    
    $deduction_page = true;
    
    header('location: index.php?route=payroll/health_insurance_processing');
 
 
}

public function health_insurance()
{
    
    $deduction_page = true;
    
      $user = 	$this->authentication->getUser();
      
 
    $rate = $user->getPayroll()->rate;
    
    if($user->getPayroll()->income == "Regular Hourly Pay")
    {
     $salary = $rate * 40 * 52;                  //At the moment full time employee
          
         $periodic_salary = $salary / 24;                         //Get period installment value
    }
    else
    {
          $salary = $rate * 20 * 52;                  //At the moment part time employee
          
         $periodic_salary = $salary / 24;                         //Get period installment value
    }
    
    return ['template'=> 'new_employee.html.php', 'title'
		=> 'Add New Employee',
		'variables' =>
		[   	'rate' => $rate,
					'name' => $user->name,
					'salary' => $salary,
					'periodic_salary' => $periodic_salary,
		   'deduction_page' => $deduction_page
		    ]];
    
}




public function health_insurance_process()
{
    

       
     $hemployee = $_POST['hemployee'];             //Get information from new_employee.html.php
     
     $hemployee = array_map('trim', $hemployee);
        
        
      
      $user = 	$this->authentication->getUser();
        
         $rate = $user->getPayroll()->rate;
         
         
        $submit = $_POST['submit'];
      
    
        	 
       	$valid = true;
       	
        
       	$array = array_merge($hemployee);
      
      
        
        	 $errors = $this->checkForBlanks($valid, $array);
        	 
        	 
       
		if(isset($hemployee['four01K']))
		{
		    
			    if($hemployee['four01KRate'] == 'NULL')
			    {
			      
			        $valid = false;
             
                     $errors[] = "401K Rate is blank";
			    }
			    
			    if(!isset($hemployee['four01KRate']))
			    {
			         $valid = false;
             
                     $errors[] = "Never clicked Calculate Button to find the Rate.  ";
			    }
			   
		}
		
		
		
		if(isset($hemployee['health_insurance']))
		{
		
		 if(!isset($hemployee['package']))
		{
		     $valid = false;
             
                     $errors[] = "Never clicked an Insurance Package Plan. ";
		}
	
	
		}
		
		if(isset($hemployee['package']))
		{
		    if(!isset($hemployee['health_insurance']))
		{
		     $valid = false;
             
                     $errors[] = "Never accepted Health Insurance Check Box ";
		}
		
		}
		
		if(isset($hemployee['dentalpackage']))
		{
		    if(!isset($hemployee['dental_health_insurance']))
		{
		     $valid = false;
             
                     $errors[] = "Never accepted Dental Insurance Check Box ";
		}
		
		}
		
		if(isset($hemployee['dental_health_insurance']))
		{
		    
		    if(!isset($hemployee['dentalpackage']))
		{
		     $valid = false;
             
                     $errors[] = "Never clicked an Dental Health Insurance Package Plan.";
		}
		   
		}
		
    
    
      
		
		if($valid == true) {
		  
		   	 
    
		
		if(isset($hemployee['four01K']))
		{ 
		
		$hemployee['four01K'] = $hemployee['four01KRate'] * .01;
		    unset($hemployee['four01KRate']);
		    
		}
		else
		{
		   $hemployee['four01K'] = 0.0;
		      unset($hemployee['four01KRate']);
		}
		
		if(isset($hemployee['health_insurance']))
		{
		    
		      $package = $hemployee['package'];
		      unset($hemployee['package']);
		    
		         if($package == 'Gold')
                	{
	                     $hemployee['health_insurance'] = 0.20;
                	}
            	else if($package == 'Silver')
                	{
	                  $hemployee['health_insurance'] = 0.30;
                	}
	            else if($package == 'Bronze')
	                {
	                   $hemployee['health_insurance'] = 0.40;
	                }
	                
		
		}
		else
		{
		    $hemployee['health_insurance'] = 0.0;
		}
		
		
			if(isset($hemployee['dental_health_insurance']))
		{
		    
		      $package = $hemployee['dentalpackage'];
		      unset($hemployee['dentalpackage']);
		    
		         if($package == 'High')
                	{
	                     $hemployee['dental_health_insurance'] = 0.06;
                	}
            	else if($package == 'Low')
                	{
	                  $hemployee['dental_health_insurance'] = 0.03;
                	}
	                
		
		}
		else
		{
		    $hemployee['dental_health_insurance'] = 0.0;
		}
		
	
		$hemployee['id'] = $user->id;
		
	//var_dump($hemployee);
		$payrollEntity = $this->payrollTable->save($hemployee);      //Save $employee info into payrollTable database              
		
			 $notifications =   $user->notification;
  

      $notifications = explode("\n", $notifications);
     
  
      
      $len = count($notifications);
      
      for($counter = 0; $counter < $len; $counter++)
      {
        
           if(preg_match('/Health-Insurance/', $notifications[$counter]) === 1)
         {
          //  echo'matched for counter ' . $counter . 'in' . $notifications[$counter]."<br>";
             unset($notifications[$counter]);
         }
         else
         {
            //  echo' not matched for counter ' . $counter . 'in' . $notifications[$counter]. "<br>";
          
         }
         
         
      } 
      
     // "notifications now is " . var_dump($notifications) . "<br>";
      
    
      
$notifications = implode("\n", $notifications);     



$huser['id'] =  $user->id;
$huser['notification'] = $notifications;

$this->usersTable->save($huser);

			
		}
		else {      
		    
		   if($user->getPayroll()->income == "Regular Hourly Pay")
    {
     $salary = $rate * 40 * 52;                  //At the moment full time employee
          
         $periodic_salary = $salary / 24;                         //Get period installment value
    }
    else
    {
          $salary = $rate * 20 * 52;                  //At the moment part time employee
          
         $periodic_salary = $salary / 24;                         //Get period installment value
    }
		  
			
			return ['template' => 'new_employee.html.php',                   //Refresh page with sticky variables,
					'title' => 'Missing Values. Try Again',     //along with $errors variable
					'variables' => [
					'hemployee' => $hemployee,
					'rate' => $rate,
					'name' => $user->name,
					'salary' => $salary,
					'periodic_salary' => $periodic_salary,
					 'deduction_page' => true,
					'submit' => $submit,
					'errors' => $errors
					]
			];
		}
	
      
       
}

public function notification()
{
    $title = 'Notifications';
    
       $user =	$this->authentication->getUser();
 

            
    $users = $this->usersTable->findAll();
    
     date_default_timezone_set('America/New_York');

  $date = date('Y-m-d');
  
 $date = strtotime($date);
 
    $notificationUsers = [];
    
    

    
   foreach($users as $user)
    {
        if(isset($user->getClock()->difference)){
        if(($user->getPayroll()->health_insurance == NULL) && (preg_match('/Health-Insurance/', $user->notification) !== 1) && ($user->getClock()->difference > "24:0:0"))
        {
          
        
               $checks = $this->checksTable->find('userid', $user->id);
               
                foreach($checks as $check)
            {
           
           $checkdate=  strtotime($check->date);
            $interval = ($date - $checkdate)/60/60/24; 
            if($interval >= 21)                                                                             //Greater than 3 weeks
           
             $notificationUsers[] = $check->userid;
               break; 
            }
               
        }
       }
    }

//$notificationUsers[] = 7;                                              // --> this is the part where you can uncomment this line to get a user to point to its userid to be eligible for health insurance instead of waiting 3 weeks 
     foreach($notificationUsers as $user => $value)
       {
          $user = $this->usersTable->findById($value);
          
    $string =  $user->notification . "\n" . "Health-Insurance: You are eligible for Health Insurance."; 
         
         $string = trim($string);
         
                $user->notification = $string;
         
        
          $huser['id'] = $user->id;
          $huser['notification'] = $user->notification;
           $this->usersTable->save($huser);
       }

  
       $user =	$this->authentication->getUser();
         
         $notifications =   $user->notification;
   
   
      $notifications = explode("\n", $notifications);
     
    
       $healthInsurance = [];
      
      $len = count($notifications);
      
      for($counter = 0; $counter < $len; $counter++)
      {
        // if(strpos($notifications[$counter], "Health-") !== false)
        if(preg_match('/Health-Insurance/', $notifications[$counter]) === 1)
         {
           //  echo 'match in counter ' . $counter . "<br>";
             $healthInsurance = $notifications[$counter];
             unset($notifications[$counter]);
             
            // array_splice($notifications, $counter,1);
         }
         
         
      } 
 

$notifications = array_values($notifications);


    
    $isnull = false;
    
     if((count($notifications) == 1))
    {
        foreach($notifications as $note)
        {
            if(empty($note))
            {
                 $isnull = true;
            }
        }
      

    }
    
    if($isnull)
    {
        $notifications = null;
    }
    
   
    
     if($user->name == 'admin')
        {
            $admin = true;
        }
        else
        {
            $admin = false;
        }
  
 
  	return ['template' => 'notification.html.php', 'title' => $title,
		'variables' =>
	       	[
		        'admin' => $admin,
		        'notifications' => $notifications,
		          'healthinsurance'=> $healthInsurance 
	    	] ];
  
    
}


private function getBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}


public function process_notification()
{
     $title = 'Notification Processed';
     
     $notification = $_POST['notification'];
     
 
 $check_number = $this->getBetween($notification, '#', ' Amount:');
 
 $method = $this->getBetween($notification, 'Method: ', ' is');
 
  $amount = $this->getBetween($notification, 'Amount: ', ' Method');

 
 $check = $this->checksTable->findById($check_number);
   
   $oldAmount = $check->amount;
  
   
  $check_arr = [];
 
 if($method == 'Add')                                          //Clear disputer's amount
    {
       
    $check_arr['amount'] = $check->amount + $amount;
    
    }
    else
    {
       
         $check_arr['amount'] =  $check->amount - $amount;
        
    }
 
 
  
  $check_arr['id'] = $check->id;
    
    $this->checksTable->save($check_arr);
    
 $check = $this->checksTable->findById($check_number); 

 
       $admin =	$this->authentication->getUser();            //Clear admin's notifications
       
  
  $adminNotifications =   $admin->notification;
  
   $c_number = $this->getBetween($notification, '#', ' Amount:');
  
  $adminNotifications = explode("\n", $adminNotifications);     
  
// echo'Adminnotifications is' . var_dump($adminNotifications) . "<br>";
//echo 'notification is ' . $notification;


 $len = count($adminNotifications);
      
      for($counter = 0; $counter < $len; $counter++)
      {
        // if(strpos($notifications[$counter], "Health-") !== false)
        $number = $this->getBetween($adminNotifications[$counter], '#', 'Amount');
    //   echo 'number is ' . $number . "<br>";
        if(trim($number) == trim($c_number))
          {
       //    echo 'same';
             unset($adminNotifications[$counter]);
          }
         else
         {
         //   echo 'no match';
         }
         
      } 


$adminNotifications = implode("\n", $adminNotifications);     


$adminArray['id'] =  $admin->id;
$adminArray['notification'] = $adminNotifications;

$this->usersTable->save($adminArray);
                                                            //Clear disputer's notification
                                                            

     $disputeUser =  $this->usersTable->findById($check->userid);
     
    $disputeNotifications = $disputeUser->notification;
    
     $disputeNotifications = explode("\n", $disputeNotifications); 
     

     $count = count($disputeNotifications);
 
     $counter_tr = 0;
     $flag = true; //echo 'check numbers is ' . $check_number;
     for($counter_tr; (($counter_tr < $count) && ($flag == true)) ; $counter_tr++)
     {
          $number = $this->getBetween($disputeNotifications[$counter_tr], '#', 'filler');
         // echo 'number is ' . $number . "<br>";
          if(trim($number) == trim($check_number))
          {
           //   echo 'same';
              $flag  = false;
          }
     }
     
 
     unset($disputeNotifications[intval($counter_tr - 1)]);
     
    
     $disputeNotifications = implode("\n", $disputeNotifications); 
     
     
     $disputeArray['id'] =  $disputeUser->id;
     
$disputeArray['notification'] = $disputeNotifications;

$disputeArray['note'] = $disputeUser->note . "\n" .  "Dispute resolved for check number# " . $check_number;

$this->usersTable->save($disputeArray);


     
    	return ['template' => 'shortcheck.html.php', 'title' => $title,
		'variables' =>
	       	[
		      'check' => $check,
		      'user' => $disputeUser,
		      'oldAmount' => $oldAmount
	    	] ];
}


public function dispute_check()
{	
    $title = 'Dispute Check';
    

    
    	return ['template' => 'dispute_check.html.php', 'title' => $title];
    
}


public function process_dispute_check()
{
   
   
     $dispute = $_POST['dispute'];
     
     
        $submit = $_POST['submit'];
        
        
     $valid = true;
     
   
      $dispute = array_map('trim', $dispute);  
      
      $errors = $this->checkForBlanks($valid, $dispute);
    
    $amount = $dispute['amount'];
    
    $check_number = $dispute['check_number'];
    
    $note = $dispute['note'];

    
    $method = $dispute['method'];
    
   

    $disputeUser =	$this->authentication->getUser();
  
    $check = $this->checksTable->findById($check_number);
    
    
    if(empty($check))
    {
        $valid = false;
        $errors[] = "Invalid Check Number";
    }
    else
    {
        
  
    $date = $check->date;
    
    $check_arr = [];
    
    $user_arr = [];
   
   
   
    if($method == 'Add')
    {
        if($amount > 10000)
        {
          
            $valid = false;
             $errors[]= 'Here take this gold also. That amount is too high?';
        }
        

    
    }
    else
    {
        if(($check->amount - $amount) < 0)
        {
             $valid = false;
             $errors[] = 'you really want -$ net pay?. That amount is too low?';
        }

        
    }
    
    
       $disputeUser =  $this->usersTable->findById($check->userid);
      
      
      $disputeNotifications = $disputeUser->notification;
      
     
     $disputeNotifications = explode("\n", $disputeNotifications); 
     

     $count = count($disputeNotifications);
    // echo 'count is ' . $count;
     $counter_tr = 0;
     $flag = true; //echo 'check numbers is ' . $check_number;
     for($counter_tr; (($counter_tr < $count) && ($flag == true)) ; $counter_tr++)
     {
          $number = $this->getBetween($disputeNotifications[$counter_tr], '#:', 'filler');
         // echo 'number is ' . $number . "<br>";
          if(trim($number) == trim($check_number))
          {
           //   echo 'same';
              $flag  = false;
          }
     }
    
    if($flag == false)
    {
          $valid = false;
             $errors[]= 'That check has already been in dispute';
    }
    
    
    
     } 
   
   
    
    if($valid){
    $check_arr['id'] = $check->id;
    
    $this->checksTable->save($check_arr);
    
    $user_arr['note'] = $disputeUser->note . "\n" . $note;
    $user_arr['id'] = $disputeUser->id;
    
    
  if($disputeUser->name !='admin'){  
    if($disputeUser->notification != NULL)
    
    { 
        $string = $disputeUser->notification  . "\n" . "Your Dispute is in Progress for check #" . $check->id;
        $string = trim($string); 
    
        $user_arr['notification'] = $string;
    }
    else
    {
          $user_arr['notification'] = "Your Dispute is in Progress for check #" . $check->id;
    }
  }
    
    $this->usersTable->save($user_arr);
    
    $admin =  $this->usersTable->find('name', 'admin')[0];
      
      $administrator['id'] = $admin->id;
      
    
       if($admin->notification != NULL){
           
       $administrator['notification'] = $admin->notification . "\n" . "Dispute Check for Check #" . $check->id . " Amount: $amount Method: $method is pending to be reviewed";
      
       }
       else
       {
               $administrator['notification']  = "Dispute Check for Check #" . $check->id . "  Amount: $amount Method: $method is pending to be reviewed.";
       }
       
        
    $this->usersTable->save($administrator);
    
    
    return ['template'=> 'disputecheckPost.html.php',                      
			'title'	=> 'Check Your New Check',                     
		'variables' => [
		'date' => $date,
		'check' => $check,
		'user' => $disputeUser
		]
	];

    
    }
    else
    {
        return ['template'=> 'dispute_check.html.php',                      
			'title'	=> 'Error in Fields',                     
		'variables' => [
		'errors' => $errors,
		'dispute' => $dispute,
		'submit' => $submit
		]
	];
	
	
	
    }

    
}

public function printer()
{
    
    $title = 'PDF Printer';
    
   $date = $_POST['date'];
   
   $valid = true;
     
     $recalculate = false;
     
    $user =	$this->authentication->getUser();
    
    $check = $user->getCheckByDate($date);
      
  if(empty($check))
  {
      $valid = false;
      $errors = 'Invalid dates';
  }

   
if($valid){
     $net_tax =  $check->getTax_deduction()->federal_income_tax +  $check->getTax_deduction()->social_security +  $check->getTax_deduction()->medicare
     +  $check->getTax_deduction()->state_income_tax +  $check->getTax_deduction()->city_income_tax;
     
    
    $net_deduction =  $check->getTax_deduction()->health_insurance +  $check->getTax_deduction()->four01K + $check->getTax_deduction()->dental_health_insurance ;
    
    
       $gross = $this->grossTable->findById($user->id);
    
    $net_pay = $check->amount - ($net_tax + $net_deduction);
    
    
    
    $net_total_income = $gross->total_income - ($gross->gross_tax + $gross->gross_deduction);
    
   $payroll = $this->payrollTable->findById($user->id);
   
   
   $tax_deduction = $this->tax_deductionTable->findById($check->id);
   

   
    $checks = $this->checksTable->find('userid', $user->id);
    
    $gross_federal_income_tax = 0;
    
    $gross_social_security = 0;
    
    $gross_medicare = 0;
    
    $gross_state_income_tax = 0;
    
    $gross_city_income_tax = 0;
    
    $gross_health_insurance = 0;
    
    $gross_dental_health_insurance = 0;
    
    $gross_four01K = 0;

    
   foreach($checks as $check_paper)
   {
      
       $gross_federal_income_tax +=  $check_paper->getTax_deduction()->federal_income_tax;
       
      $gross_social_security  += $check_paper->getTax_deduction()->social_security;
      
      $gross_medicare +=  $check_paper->getTax_deduction()->medicare;
      
      $gross_state_income_tax += $check_paper->getTax_deduction()->state_income_tax;
      
       $gross_city_income_tax += $check_paper->getTax_deduction()->city_income_tax;
       
       $gross_health_insurance += $check_paper->getTax_deduction()->health_insurance;
       
        $gross_dental_health_insurance  += $check_paper->getTax_deduction()->dental_health_insurance;
       
       $gross_four01K += $check_paper->getTax_deduction()->four01K;
     
   }
   
   
  
     if($gross_four01K >= 19000)
    {
        
    $gross_four01K = 19000;

        
    }
    
    
    	return ['template' => 'printer.html.php', 'title' => $title, 
		'variables' =>
		[
		    'date' => $date,
		    'user' => $user,
		    'check' => $check,
		    'payroll' => $payroll,
		    'tax_deduction' => $tax_deduction,
		    'gross' => $gross,
		     'gross_federal_income_tax' => $gross_federal_income_tax,
		     'gross_social_security' => $gross_social_security ,
            'gross_medicare' => $gross_medicare,
            'gross_state_income_tax' => $gross_state_income_tax,
            'gross_city_income_tax' => $gross_city_income_tax,
            'gross_health_insurance' => $gross_health_insurance,
            'gross_dental_health_insurance'  => $gross_dental_health_insurance,
            'gross_four01K' => $gross_four01K,
            'net_tax' => $net_tax,
            'net_deduction' => $net_deduction,
            'net_pay' => $net_pay,
            'net_total_income' => $net_total_income,
             'recalculate' => $recalculate,
             'valid' => $valid,
		    ]
		 ];
 }
 else
 {
      $title = 'Invalid dates';
      return ['template' => 'papercheck_getdate.html.php', 'title' => $title,
      'variables'=>
      [ 
          'date' => $date,
         
            'valid' => $valid
         ]
      ];
 }
 


}




public function employee_calculate_salary()
{
   $employee =  $_GET['rate'];
   
}

public function employee_search()
{
    	$title = 'Employee Search';
    	
    	$var = '`users`.`name` DESC';
    	
       $users = $this->usersTable->findAll($var);
       
       
    	
    		return ['template' => 'employee_search.html.php', 'title' => $title,
    		'variables' =>
	       	[
		    'users' => $users,
		
	    	]
		];
}

public function employee_delete()
{
    	$title = 'Employee Deleted';
    	
    $user =	$_POST['user'];
        
        
        $User  = $this->usersTable->findById($user['id']);              
 
       $userString = $User->serialize();                             //Serialize User object via entity class
       
      $payroll  = $this->payrollTable->findById($user['id']);
       
       $payrollString = $payroll->serialize();                       //Serialize payroll object via entity class
       
       $gross  = $this->grossTable->findById($user['id']);
       
       
       
       if(empty($gross))
       {
           $grossString = "Gross: Never had a paycheck";
       }
       else{
             $grossString = $gross->serialize();                      //Serialize gross object via entity class
       }
     
       
        
        
       $text = "$userString . <p> . $payrollString . <p> $grossString";          //Concatenate
       
         $retiree['id'] = $user['id'];                                                   //id must be null for autoincrement to trigger insert in DatabaseTable save() function
        
        $retiree['info'] = $text;                                               
         	$this->retireeTable->save($retiree);                                 //Save retiree database
   	
    	
   	
    	
    	$this->usersTable->delete($user['id']);
    	
    	$this->payrollTable->delete($user['id']);
    	
    	 $clock  = $this->clock_in_clock_outTable->findById($user['id']);
    	
    	if(!empty($clock))
    	{
    	    
    	$this->clock_in_clock_outTable->delete($user['id']);
    	
    	}
    	
    	
    	if(!empty($gross))
    	{
    	    $this->grossTable->delete($user['id']);
    	}
    
    	 $users = $this->usersTable->findAll();
    	 
    	return ['template' => 'employee_search.html.php', 'title' => $title,
    		'variables' =>
	       	[
		    'users' => $users
		
	    	]
		];
}

public function retiree()
{
    	$title = 'Retired Employees';
    	
    		 $retiree = $this->retireeTable->findAll();
    		 
    		 
		return ['template' => 'retiree.html.php', 'title' => $title,
		'variables' =>
		[
		   'retiree' => $retiree 
	     ]
	     
    	];
}


public function employee_edit()
{
    	$title = 'Employee Edit';
    	
    	$userid = $_GET['id'];
    	
    	$user = $this->usersTable->findById($userid);
    	
    $payroll =	$user->getPayroll();
    
    
    
    
    
    	return ['template' => 'employee_edit.html.php', 'title' => $title,
    		'variables' =>
	       	[
	       	    'user' => $user,
	       	    'payroll' => $payroll
	    	]
		];
}


public function employee_edit_process()
{
  	$title = 'Employee Search';
    	$user = $_POST['user'];
    	
    	 	 $user = array_map('trim', $user); 
    	 	 
        $payroll = $_POST['payroll'];
        
         	 $payroll = array_map('trim', $payroll); 
         	 
         	 
         	 
        
         $finduser = $this->usersTable->findById($user['id']);
        
        $valid = true;
        $errors = [];
    
    if($user['email'] != 'unregistered'){
        
    if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$errors[] = 'Invalid email address';
		}
		
		if(strlen($user['email']) > 40)
		{
		    	$valid = false;
			$errors[] = 'Maximum characters reached for email address';
		}
		
		
		if($valid)
		{
		      $checkuser = $this->usersTable->find('email', $user['email']);
		      
		      if(!empty($checkuser))
		    {
		    $checkuser = $checkuser[0];
		     if(($checkuser->id != $finduser->id))
		         {
		             	$valid = false;
		        	$errors[] = 'This email is already registered';
		         }
		    }
		      
		}
    }
    
     $checkuser = $this->usersTable->find('name', $user['name']);
		      
		      if(!empty($checkuser))
		    {
		        
		    $checkuser = $checkuser[0];
		     if(($checkuser->id != $finduser->id))
		         {
		             	$valid = false;
		        	$errors[] = 'This name is already registered';
		         }
		    }
    
 
    
   
         if($user['payment_method'] == 'direct_deposit'){
	       
        if(!empty($user['check number']) && !is_numeric(str_replace(" ","",$user['check number'])))
        {
           
            
            $valid = false;
            
            $errors[] = "Check # is not numbers. ";
            
           
        }
        
   
        
        if(!empty($user['routing number']) && !is_numeric(str_replace(" ","",$user['routing number'])))
        {  
           
            
             $valid = false;
         
                  $errors[] = "Routing is not numbers";
     
          
        }
        
        if($valid)
        {
             $user['check number'] = password_hash($user['check number'], PASSWORD_DEFAULT);
        
        $user['routing number'] = password_hash($user['routing number'], PASSWORD_DEFAULT);   
        
        $user['payment_method'] = "Direct Deposit\n Routing #: " . $user['routing number'] . "\n Check #:" . $user['check number'];
          
	
        }
        
        
         }
         
       
         
         if($user['note'] == '')
         {
              unset($user['note']);
         }
         
         	unset($user['routing number']);
		unset($user['check number']);
		
         
        if($valid){
            
            	unset($user['routing number']);
		unset($user['check number']);
		
		
    	if($payroll['division'] == 'New York, New York City')
	    {
	        $payroll['state_income_tax'] = 0.04;
	        $payroll['city_income_tax'] = 0.08;
	    }
	    else if($payroll['division'] == 'Pennsylvania, Scranton')
	    {
	         $payroll['state_income_tax'] = 0.0307;
	          $payroll['city_income_tax'] = 0.034;
	    }
	    else if($payroll['division'] == 'New Jersey, Newark')
		{
		    
		    $payroll['state_income_tax'] = 0.05525;
		     $payroll['city_income_tax'] = 0.01;
		}
		
		 $finduser->addDivision($payroll);
		 
		  $finduser->addTaxes($payroll);
		  
		  if($user['social_security'] == '')
         {
             unset($user['social_security']);
         }else
         {
            $user['social_security'] = password_hash($user['social_security'], PASSWORD_DEFAULT); 
             
         }
    	
    	
    	$this->usersTable->save($user);
    
    	
    		 $users = $this->usersTable->findAll();
    		 
    		 
    		return ['template' => 'employee_search.html.php', 'title' => $title,
    		'variables' =>
	       	[
		    'users' => $users,
		
	    	]
		];
        }
        else
        {
          	 $users = $this->usersTable->findAll();
            	  $finduser = $this->usersTable->findById($user['id']);
            	   $payroll =	$finduser->getPayroll();
            return ['template' => 'employee_edit.html.php', 'title' => $title,
    		'variables' =>
	       	[
		    'users' => $users,
		    'errors' => $errors,
		    'user' => $finduser,
		    'payroll' => $payroll
		    
		
	    	]
		];
       }
}



public function recalculate()
{
    $title = 'RECALCULATED';
   $start_date = $_POST['start_date'];
   $end_date = $_POST['end_date'];
   
    $valid = true;
    $recalculate = true;
    $errors = [];
    
    $dates = [];
    
    $user =	$this->authentication->getUser();
      $payroll = $this->payrollTable->findById($user->id);
    
   
   $rcheck = [];
   $rcheck['quantity'] = 0;
   $totalHours = "0:0:0";
   $rcheck['amount'] = 0;
   $rcheck['overtime'] = 0;

   
     $gross_federal_income_tax = 0;
    
    $gross_social_security = 0;
    
    $gross_medicare = 0;
    
    $gross_state_income_tax = 0;
    
    $gross_city_income_tax = 0;
    
    $gross_health_insurance = 0;
    
    $gross_dental_health_insurance = 0;
    
    $gross_four01K = 0;
     
   
  $checks = $this->checksTable->getRecordsBetweenDates('date', $start_date, $end_date, $user->id);
  
  if(empty($checks))
  {
      $valid = false;
  }
 
 if($valid){
 foreach($checks as $check_paper)
 {
       $totalHours = $this->addtimever2($check_paper->quantity, $totalHours);
     //$rcheck['quantity'] += $this->addtimever2($check_paper->quantity, $rcheck['quantity']);
     $rcheck['amount'] += $check_paper->amount;
     $rcheck['overtime'] += $check_paper->overtime;
     $dates[] = $check_paper->date;
       $gross_federal_income_tax +=   $check_paper->getTax_deduction()->federal_income_tax;
       
      $gross_social_security  +=  $check_paper->getTax_deduction()->social_security;
      
      $gross_medicare +=  $check_paper->getTax_deduction()->medicare;
      
      $gross_state_income_tax += $check_paper->getTax_deduction()->state_income_tax;
      
       $gross_city_income_tax += $check_paper->getTax_deduction()->city_income_tax;
       
       $gross_health_insurance += $check_paper->getTax_deduction()->health_insurance;
       
       $gross_dental_health_insurance += $check_paper->getTax_Deduction()->dental_health_insurance;
       
       $gross_four01K += $check_paper->getTax_deduction()->four01K; 
     
 }
 
 $rcheck['quantity'] = $totalHours;
 
    if($gross_four01K >= 19000)
    {
        
    $gross_four01K = 19000;

        
    }
 
 
   $net_tax =  $gross_federal_income_tax +  $gross_social_security +  $gross_medicare
     +  $gross_state_income_tax +  $gross_city_income_tax;
     
     $net_deduction = $gross_health_insurance + $gross_four01K + $gross_dental_health_insurance;
 
 $net_pay =  $rcheck['amount'] - ($net_tax + $net_deduction);


 return ['template' => 'papercheck.html.php', 'title' => $title, 
		'variables' =>
		[
		    'valid' => $valid,
		    'rcheck' => $rcheck,
		    'payroll' => $payroll,
		     'gross_federal_income_tax' => $gross_federal_income_tax,
		     'gross_social_security' => $gross_social_security ,
            'gross_medicare' => $gross_medicare,
            'gross_state_income_tax' => $gross_state_income_tax,
            'gross_city_income_tax' => $gross_city_income_tax,
            'gross_health_insurance' => $gross_health_insurance,
            'gross_dental_health_insurance' => $gross_dental_health_insurance,
            'gross_four01K' => $gross_four01K,
            'net_tax' => $net_tax,
            'net_deduction' => $net_deduction,
            'net_pay' => $net_pay,
            'recalculate' => $recalculate,
            'dates' => $dates,
            'start_date' => $start_date,
            'end_date' => $end_date
		    ]
		 ];
 }
 else
 {
     $title = 'Invalid dates';
      return ['template' => 'papercheck.html.php', 'title' => $title,
      'variables'=>
      [
            'valid' => $valid,
            'recalculate' => $recalculate,
          'start_date' => $start_date,
          'end_date' => $end_date
         ]
      ];
 }
 
 
}



public function process_papercheck($date = null)
{
    	$title = 'Check Details';
  	
        
     $date =	$_POST['date'];
     
     
     
     $valid = true;
     
     $recalculate = false;
     
    $user =	$this->authentication->getUser();
    
    $check = $user->getCheckByDate($date);
      
  if(empty($check))
  {
      $valid = false;
      $errors = 'Invalid dates';
  }

   
if($valid){
     $net_tax =  $check->getTax_deduction()->federal_income_tax +  $check->getTax_deduction()->social_security +  $check->getTax_deduction()->medicare
     +  $check->getTax_deduction()->state_income_tax +  $check->getTax_deduction()->city_income_tax;
     
    
    $net_deduction =  $check->getTax_deduction()->health_insurance +  $check->getTax_deduction()->four01K + $check->getTax_deduction()->dental_health_insurance;
    
    
       $gross = $this->grossTable->findById($user->id);
    
    $net_pay = $check->amount - ($net_tax + $net_deduction);
    
    
    
    $net_total_income = $gross->total_income - ($gross->gross_tax + $gross->gross_deduction);
    
   $payroll = $this->payrollTable->findById($user->id);
   
   
   $tax_deduction = $this->tax_deductionTable->findById($check->id);
   

   
    $checks = $this->checksTable->find('userid', $user->id);
    
    $gross_federal_income_tax = 0;
    
    $gross_social_security = 0;
    
    $gross_medicare = 0;
    
    $gross_state_income_tax = 0;
    
    $gross_city_income_tax = 0;
    
    $gross_health_insurance = 0;
    
    $gross_dental_health_insurance = 0;
    
    $gross_four01K = 0;

    
   foreach($checks as $check_paper)
   {
      
       $gross_federal_income_tax +=  $check_paper->getTax_deduction()->federal_income_tax;
       
      $gross_social_security  += $check_paper->getTax_deduction()->social_security;
      
      $gross_medicare +=  $check_paper->getTax_deduction()->medicare;
      
      $gross_state_income_tax += $check_paper->getTax_deduction()->state_income_tax;
      
       $gross_city_income_tax += $check_paper->getTax_deduction()->city_income_tax;
       
       $gross_health_insurance += $check_paper->getTax_deduction()->health_insurance;
       
      $gross_dental_health_insurance += $check_paper->getTax_deduction()->dental_health_insurance;
       
       $gross_four01K += $check_paper->getTax_deduction()->four01K;
     
   }
   
     if($gross_four01K >= 19000)
    {
        
    $gross_four01K = 19000;

        
    }
    
    
    	return ['template' => 'papercheck.html.php', 'title' => $title, 
		'variables' =>
		[
		    'date' => $date,
		    'check' => $check,
		    'payroll' => $payroll,
		    'tax_deduction' => $tax_deduction,
		    'gross' => $gross,
		     'gross_federal_income_tax' => $gross_federal_income_tax,
		     'gross_social_security' => $gross_social_security ,
            'gross_medicare' => $gross_medicare,
            'gross_state_income_tax' => $gross_state_income_tax,
            'gross_city_income_tax' => $gross_city_income_tax,
            'gross_health_insurance' => $gross_health_insurance,
            'gross_dental_health_insurance' => $gross_dental_health_insurance,
            'gross_four01K' => $gross_four01K,
            'net_tax' => $net_tax,
            'net_deduction' => $net_deduction,
            'net_pay' => $net_pay,
            'net_total_income' => $net_total_income,
             'recalculate' => $recalculate,
             'valid' => $valid,
		    ]
		 ];
 }
 else
 {
      $title = 'Invalid dates';
      return ['template' => 'papercheck_getdate.html.php', 'title' => $title,
      'variables'=>
      [ 
          'date' => $date,
          // 'recalculate' => $recalculate,
            'valid' => $valid
         ]
      ];
 }
 
 
}

public function clock_in_out(){
    $title = 'Clock In/Out';
    
     $user =	$this->authentication->getUser();
     
   
  $clock = $user->getClock();

    $done = false;
    return ['template' => 'clock_in_out.html.php', 'title' => $title,
     'variables' => [
					'clock' => $clock,
					'done' => $done
					]];
}



public function process_clock_in_out()
{
    
     $user = $this->authentication->getUser();
     
       $CLOCK = $_POST['CLOCK'];
       
    $CLOCK = array_map('trim', $CLOCK); 
   

     if(isset($CLOCK['in'])){

     date_default_timezone_set('America/New_York');

  
   $t = time();
   
$current_time = date('h:i:s', $t);

$addclock = [];

     $addclock['clock_in'] = $current_time ;
     
    $user->addClockIn($addclock);
    
    //insert current time into the table
   /* $query = 'Insert Into clock_in_clock_out (Clock In) Values(?)';
    $stmt = $pdo -> prepare($query);
    $stmt -> bind_param("s", $current_time);
    $stmt -> execute();
    $stmt -> store_result();
    $start = $current_time;*/
    
     $clock = $user->getClock();
     
    

   $title = 'CLOCK OUT WHEN READY';
   
  $done = false;

  return ['template' => 'clock_in_out.html.php', 'title' => $title,
  'variables' => [
					'clock' => $clock,
					'done' => $done
					]];
					
}
elseif(isset($CLOCK['out']))
{
     date_default_timezone_set('America/New_York');
     
    $t = time();
   
$current_time = date('h:i:s', $t);
    
   
    
      $clock = $user->getClock();
    
    $end = $current_time;
   
   //$start = '12:0:0';
    //    $end = '9:0:0'; 
       $end = date('H:i:s',strtotime($end)); 
       
    
      $start = $clock->clock_in;
      
       $start =date('H:i:s',strtotime($start)); 
      
     
      
      
   $difference =  $this->date_getFullTimeDifference($start, $end);
   
    //   $difference = '09:55:00';                                 // ---> this is the part where you can uncomment this line to get the user to work 9 hours and 55 minutes after clicking clock-out
      
 
      
      
 $difference =date('H:i:s',strtotime($difference));
      
 
   
 
      $type = $user->getPayroll()->income;
       
        $addclock = [];
   
      if($type == 'Regular Hourly Pay')
     {
         
         $time = '8:0:0';
          $time = date('H:i:s',strtotime($time)); 
          
          if($difference > $time)
          {
              echo 'inside if';
               $overtime =  $this->date_getFullTimeDifference($time, $difference); 
               $overtime =date('H:i:s',strtotime($overtime)); 
               
                             $difference =   $this->date_getFullTimeDifference($overtime, $difference); 
                                
                 $overtime = $this->addtimever2($overtime, $clock->overtime); 
                 $addclock['overtime'] = $overtime;
                 

            }
          
         
          
           
       
     }
     elseif($type == 'Part Time')
     {
      
           $time = '4:0:0';
          $time = date('H:i:s',strtotime($time)); 
          
           if($difference > $time)
          {
             //  echo 'inside else if';
             
               $overtime =  $this->date_getFullTimeDifference($time, $difference);  
               $overtime =date('H:i:s',strtotime($overtime)); 
               
               $difference =   $this->date_getFullTimeDifference($overtime, $difference); 
               
               $overtime = $this->addtimever2($overtime, $clock->overtime);
                $addclock['overtime'] = $overtime;
          }
      
        
     }
     

    
      $difference = $this->addtimever2($difference, $clock->difference);
      

      
    $addclock['difference'] = $difference;
     
     $user->addDifference($addclock);
    
   
     $title = 'PROCESSED FOR THIS DAY';
     
     $done = true;



  return ['template' => 'clock_in_out.html.php', 'title' => $title,
  'variables' => [
					'done' => $done
					]];
    
    
}


}

private function sum_the_time($time1, $time2) {
      $times = array($time1, $time2);
      $seconds = 0;
      foreach ($times as $time)
      {
        list($hour,$minute,$second) = explode(':', $time);
        $seconds += $hour*3600;
        $seconds += $minute*60;
        $seconds += $second;
      }
      $hours = floor($seconds/3600);
      $seconds -= $hours*3600;
      $minutes  = floor($seconds/60);
      $seconds -= $minutes*60;
      if($seconds < 9)
      {
      $seconds = "0".$seconds;
      }
      if($minutes < 9)
      {
      $minutes = "0".$minutes;
      }
        if($hours < 9)
      {
      $hours = "0".$hours;
      }
      return "{$hours}:{$minutes}:{$seconds}";
    }

private function addtime($time1,$time2)
{
    $x = new \DateTime($time1);
    $y = new \DateTime($time2);

    $interval1 = $x->diff(new \DateTime('00:00:00')) ;
    $interval2 = $y->diff(new \DateTime('00:00:00')) ;

    $e = new \DateTime('00:00');
    $f = clone $e;
    $e->add($interval1);
    $e->add($interval2);
    $total = $f->diff($e)->format("%H:%I:%S");
    return $total;
}


private function addtimever2($time1, $time2)
{ 
    $total = $this->sum_the_time($time1, $time2);

return $total;
    //  $sum = date('H:i:s',strtotime($total));
  //return $sum;
     
 /* $time1 = explode(":", $time1);  $time2 = explode(":", $time2);
  
    echo 'difference is  ' . var_dump($time1) . '<br>';
echo 'clock_difference is ' . var_dump($time2) . '<br>';
       
      
     //  $past = $hours;
   $hours = $time1[0] + $time2[0];
   
   $minutes = $time1[1] + $time2[1];
   
   $seconds = $time1[2] + $time2[2];
   
   
 
      $sum = $hours . ":" . $minutes . ":" . $seconds;  */

   // ;
   

    
     
}

private function date_getFullTimeDifference( $start, $end )
{
$uts['start']      =    strtotime( $start );
        $uts['end']        =    strtotime( $end );
        
        
        $twel = '12:0:0';
          // $twel = date('H:i:s',strtotime($twel)); 
//echo 'twel is' . $twel;
     //   echo 'start is' . $uts['start'];
         $twelve['end'] = strtotime($twel); 
        
        if( $uts['start']!==-1 && $uts['end']!==-1 )
        {
            if( $uts['end'] > $uts['start'] )
            {
              //  echo 'inside if';
                $diff    =    $uts['end'] - $uts['start'];
                if( $years=intval((floor($diff/31104000))) )
                    $diff = $diff % 31104000;
                if( $months=intval((floor($diff/2592000))) )
                    $diff = $diff % 2592000;
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
                //return( array('years'=>$years,'months'=>$months,'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
                
                return $hours . ":" . $minutes . ":" . $diff;
            }
            else
            {
                
                if($start == $end)
                {
                  //  echo 'inside else same';
                   // $diff = date('H:i:s',strtotime('23:59:0')); 
                                return "23:59:0";
                               // return( array('hours' => 23, 'minutes' => 59, 'seconds' => 0));
                }
                else
                {
                  //  echo'not same';
                     //$twelve['end'] = strtotime('12:00:00');
               //  $twelve['end'] = date('H:i:s',strtotime('12:00:00')); 
          ///      echo 'twelve end is ' . $twelve['end'] . '<br>';
                $diff    =   $twelve['end']  - $uts['start'];
       
                if( $years=intval((floor($diff/31104000))) )
                    $diff = $diff % 31104000;
                if( $months=intval((floor($diff/2592000))) )
                    $diff = $diff % 2592000;
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
        
            //        echo 'diff between 12 is ' . $hours . $minutes . $diff;
                $end = explode(":", $end);
                $hours += $end[0]; $minutes += $end[1]; $diff += $end[2];
                   return $hours . ":" . $minutes . ":" . $diff;
                //   return $hours . ":" . $minutes . ":" . $diff;
                 //  $twelvedifference = $hours. ":" . $minutes . ":" . $diff;
               //  $time = $this->addtime($twelvedifference, $end);
                 
                // echo 'difference is ' . $time;
              /*     return $time;
                  if( $years=intval((floor($diff/31104000))) )
                    $diff = $diff % 31104000;
                if( $months=intval((floor($diff/2592000))) )
                    $diff = $diff % 2592000;
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
                
                  echo 'diff is  hours is'  . $hours . 'minutes is' . $minutes . 'seconds is' . $diff;
       ///  return  $twelvedifference =date('H:i:s',strtotime($twelvedifference)); 
                // $this->addtime($twelvedifference, $)
              
              //  echo "Ending date/time is earlier than the start date/time";*/
                }
               
            }
        }
        else
        {
           // echo "Invalid date/time data detected";
        }
}



public function payrollProcessing() {
    $title = 'Payroll Processing';
    
    
    return ['template' => 'payroll_processing.html.php', 'title' => $title];
}

private function array_keys_exist($keys, $array){
    foreach($keys as $key){
        if(!array_key_exists($key, $array))return false;
    }
    return true;
}




public function input_hours_worked (){
    
	$hours = $_POST['hours'];                   //Retreive name, quanity, hours from payroll_processing.html.php
	
	
	 $hours = array_map('trim', $hours);  
	 
	 	$valid = true;
	 	
	 	  $errors = $this->checkForBlanks($valid, $hours);
	 	  
	 	  
	$finduser = $this->usersTable->find('name', $hours['name']);          //Check whether name is in database
	
		if(empty($finduser))
		{
		    	$valid = false;
			
			$errors[] = 'Are you an employee of Blue Ocean, Did an admin fill out your New Employee Form?';
		}else
		{
		   $finduser = $finduser[0];
		   
		    	if(!empty($finduser->getCheckByDate($hours['date']))) {
	 	        
	 	 	
	 	 	
				$valid = false;
				
				$errors[] = 'An employee cant payroll process twice on the same day';
			} 
			
			 $parts = explode('-', $hours['date']);
    
    $date = $parts[2];
   

    if(($date != '31')  && ($date != '01') && ($date != '30') && ($date != '28'))
    {
        	$valid = false;
			
			$errors[] = 'Dates are not right. Payroll processing only in the 1st and and last days of the month.';
        
    }
			
			   $clock = $finduser->getClock();
  
     if($clock->difference == "00:00:00")
     {
         
         	$valid = false;
			
			$errors[] = 'Employee never worked for a time differential.';
         
     }
    	
    
	
	
	
		}
		
		
			
			
		if($valid == true) {
		    
		    	$hours['date'] = new \DateTime($hours['date']);
			
		unset($hours['name']);	           //Since we are filling check database, no need for name column
		
			$hours['id'] = ' ';                                          //Primary key id will be blank to trigger
			
			   $payroll = $this->payrollTable->findById($finduser->id);
			
      $rate = $payroll->rate;
  
  
     
     
     
  $totalHours = $clock->difference;
     
     $difference = $clock->difference;
     
    $difference = explode(':', $difference);
    
   $hoursworked = $difference[0];
    
    $minutes = $difference[1];
    
   $quantity = $hoursworked + ($minutes/60);
     
   
    $normalpay = $rate * $quantity;
    
    if($clock->overtime != '00:00:00')
    {
        
        $overtime = explode(':', $clock->overtime);
    
   $hoursworked = $overtime[0];
    
    $minutes = $overtime[1];
    
       $quantity = $hoursworked + ($minutes/60);
       
     //  echo 'overtime quantity hours is '. $quantity . "<br>";
    
    $overtime = $quantity * (1.5 * $rate);
    
    	$hours['overtime'] = $overtime;
	 
    
 //   echo 'overtime is '. $overtime . "<br>";
    
  //  echo 'normalpay is '. $normalpay. "<br>";
    $amount = $overtime + $normalpay;
     
       $totalHours = $this->addtimever2($clock->difference, $clock->overtime);
     
    }
    else
    {
         $amount = $normalpay;
    
    }
    
    
     

 
     $finduser->resetClock();
     
	$hours['amount'] = $amount;
	
	
	$hours['quantity'] = $totalHours;
	

	 $check = $finduser->addPayroll($hours);         //Insert function inside the save function of usersTable database
				


	
    $checks = $this->checksTable->find('userid', $finduser->id);
 
    
    $year = '2019';                                                      //Year of Payroll Processing Cycle, if year                                                                      is finished next year will be 2020
  
    $gross_four01K = 0;
    
   
     foreach($checks as $check_paper)
   {
        if(isset($check_paper->getTax_deduction()->four01K))
        {
       $date_of_check = explode('-', $check_paper->date);
       
       $year_of_check = $date_of_check[0];
       
       if($year_of_check == $year)
       {
       $gross_four01K += $check_paper->getTax_deduction()->four01K;                                       //Always gets error when payrolling first time user?
    
       }
        }
       
     
   }
   
    
   
   
    if($gross_four01K >= 19000)
    {
        $capOkay = false;
        
        
    }
    else
    {
       $capOkay = true;
    }
          
    
	 $four01Kamount = $check->addDeductions($amount, $capOkay);                 //Get $amount - 401K since 401K is pretaxed;
	 
	 $amount - $four01Kamount;
	 
	 	$check->addTaxes($amount);
	 
	 
	
	
	$this->gross_processing($finduser, $rate, $check);
	
			header('location: index.php?route=payroll/payroll_success');         //Reroute to success page
			
		} 
		else {                                             //If registartion is invalid

	
			
			return ['template' => 'payroll_processing.html.php',                   //Refresh page with sticky variables,
					'title' => 'Missing Values. Try Again',     //along with $errors variable
					'variables' => [
					'hours' => $hours,
					'errors' => $errors
					]
			];
		}
}

 private function gross_processing($finduser, $rate, $check)
    {
      
   $checks = $this->checksTable->find('userid', $finduser->id);
   
 

   $total_income = 0;
   
   $gross_tax = 0;
   
   $gross_deduction = 0;
   
     

   foreach($checks as $check)
   {
   
      $gross_tax +=  $check->getTax_deduction()->federal_income_tax +  $check->getTax_deduction()->social_security +  $check->getTax_deduction()->medicare + $check->getTax_deduction()->state_income_tax + $check->getTax_deduction()->city_income_tax;
      
      $gross_deduction +=  $check->getTax_deduction()->health_insurance +  $check->getTax_deduction()->four01K + $check->getTax_deduction()->dental_health_insurance;
      
        $total_income += $check->amount;
      
      
   }
    

   
   $gross = [];
   
   $gross['gross_tax'] = $gross_tax;
   $gross['gross_deduction'] = $gross_deduction;
   $gross['total_income'] = $total_income;
   
   $finduser->addGross($gross);
          
         
}
    
public function gross()
{  
    $users = $this->usersTable->findAll();
     	return ['template'=> 'gross.html.php', 'title'
		=> 'Gross',
		'variables' =>
		[
		   'users' => $users,
		    ]
		
		];
}



    public function payroll_new_employee()
    { 
      
        	return ['template'=> 'new_employee.html.php', 'title'
		=> 'Add New Employee', 
		'variables' =>
		[
		   'standard_page' => true,
		    ]
		
		];
    }
    
    private function checkForBlanks(&$valid, $array, $dontcheck = null)
{ 
    

   
    $errors = [];
    
    
    
    
    foreach($array as $index => $value)
    {
        if($dontcheck != null && in_array($index, $dontcheck))
        {
        
            continue;
        }
        else
        {  
            if(empty($value)){
    
            	$errors[] = $index . ' cannot be blank';
            	$valid = false;
            }
        }
       
    }
    
    return $errors;
}

    public function process_new_employee()
    {
        
       
       
     $employee = $_POST['employee'];             //Get information from new_employee.html.php
        

        
        $user = $_POST['user'];
        
         	 $address = $_POST['address'];
         	 
        $submit = $_POST['submit'];
      
        
        	 $employee = array_map('trim', $employee); 
        	 
        	 $user = array_map('trim', $user); 
        	 
        	 $address = array_map('trim', $address); 
        	 
       	$valid = true;
       	
        
       	$array = array_merge($employee, $user, $address);
    
    
        if($user['payment_method'] == 'check')
        {
             $dontcheck = array('note', 'check number', 'routing number');
        }
        else
        {
            $dontcheck = array('note');
        }
        
        
        	 $errors = $this->checkForBlanks($valid, $array, $dontcheck);
        	 
        	 
        if($user['payment_method'] == 'direct_deposit'){
	       
        if(!empty($user['check number']) && !is_numeric(str_replace(" ","", $user['check number'])))
        {
           
            
            $valid = false;
            
            $errors[] = "Check # is not numbers. ";
            
           
        }
        
        if(!empty($user['routing number']) && !is_numeric(str_replace(" ","", $user['routing number'])))
        {
            
             $valid = false;
             
           
                  $errors[] = "Routing # is not numbers. ";
             
            
          
        }
        
      
        
        }
       
       
        if(!empty($address['zip']) && !is_numeric($address['zip']))
        {
            $valid = false;
            $errors[] = "Zip is not numbers. ";
        }
        
        if(count($this->usersTable->find('name', $user['name'])) > 0) {
				$valid = false;
				
				
				$errors[] = 'This username is already registered.';
			}
 
		
		if($valid == true) {
		  
		   	 
       
		  
	    $add = implode($address);
	    
        $user['address'] = $add;
        
        
		    	$user['social_security'] = password_hash($user['social_security'], PASSWORD_DEFAULT);
	
	    if($employee['division'] == 'New York, New York City')
	    {
	        $employee['state_income_tax'] = 0.04;
	         $employee['city_income_tax'] = 0.08;
	    }
	    else if($employee['division'] == 'Pennsylvania, Scranton')
	    {
	         $employee['state_income_tax'] = 0.0307;
	          $employee['city_income_tax'] = 0.034;
	    }
	    else if($employee['division'] == 'New Jersey, Newark')
		{
		    
		    $employee['state_income_tax'] = 0.05525;
		     $employee['city_income_tax'] = 0.01;
		}

	
		 if($user['payment_method'] == 'direct_deposit'){
	       
     
    
        
          $user['check number'] = password_hash($user['check number'], PASSWORD_DEFAULT);
        
$user['routing number'] = password_hash($user['routing number'], PASSWORD_DEFAULT);   
        
        $user['payment_method'] = "Direct Deposit\n Routing #: " . $user['routing number'] . "\n Check #:" . $user['check number'];
        
	    }
		else
		{
	
		    $user['payment_method'] = "Check";
		   
		}
		
		
        
		unset($user['routing number']);
		unset($user['check number']);
		
		
		$employee['id'] = ' ';
		

		$payrollEntity = $this->payrollTable->save($employee);      //Save $employee info into payrollTable database      
		
	
		
	$user =	$payrollEntity->addUser($user);                        //Save the $user info like name to $userTable database with foreign key being the payRollEntity's id which will signify the employee's id number 
		
		$user->addTimeClock();	
			
			
			header('location: index.php?route=payroll/payroll_success');         //Reroute to success page
			
		}
		else {      
		    
		    
		  //   $salary = $employee['rate'] * 40 * 52;                  
          
       //  $periodic_salary = $salary / 24;
			
			return ['template' => 'new_employee.html.php',                   //Refresh page with sticky variables,
					'title' => 'Missing Values. Try Again',     //along with $errors variable
					'variables' => [
					'employee' => $employee,
					'user' => $user,
					'address' => $address,
					//'salary' => $salary,
				//	'periodic_salary' => $periodic_salary,
					 'standard_page' => true,
					'submit' => $submit,
					'errors' => $errors
					]
			];
		}
	
		
		
		
    }
    
    
    public function tax_processing()
    
    {
       $users = $this->usersTable->findAll();
       
       
        
        	return ['template'=> 'tax.html.php', 'title'
		=> 'Tax',
		'variables' =>
		[
		   'users' => $users,
		    ]
		
		];
    }
    
    public function input_tax()
    {
        $tax = $_POST['tax'];
        
        	 $tax = array_map('trim', $tax); 
     
       $user = $this->usersTable->findById($tax['id']);
        $users = $this->usersTable->findAll();
        
    
        $user->addTaxes($tax);
        
       // echo $user->name;
        
    	return ['template'=> 'tax.html.php', 'title'
		=> 'Payroll Processing Successful',
			'variables' =>
		[
		   'users' => $users,
		   'name' => $user->name
		    ]]; 
		
    }
    
    public function deduction_processing()
    {
        $users = $this->usersTable->findAll();
       

        	return ['template'=> 'deductions.html.php', 'title'
		=> 'Deductions',
		'variables' =>
		[
		   'users' => $users,
		    ]
		
		];
    }
    
    public function input_deduction()
    {
         $deductions = $_POST['deduction'];
        
        
        	 $deductions = array_map('trim', $deductions); 
        	 
       
        	 
        	 $deductions['four01K'] = $deductions['four01K'] * .01;
        
        	 
      
     $user = $this->usersTable->findById($deductions['id']);
        
     
        $user->addDeductions($deductions);
        
         $users = $this->usersTable->findAll();
       
        
        
    	return ['template'=> 'deductions.html.php', 'title'
		=> 'Modified ' . $user->name . ' Deductions', 
			'variables' =>
		[
		   'users' => $users,
		   'name' => $user->name
		    ]]; 
    }
    
   


	public function payroll_success() {
		
		return ['template'=> 'payroll_success.html.php', 'title'
		=> 'Payroll Processing Successful'];
		
		
	}


}