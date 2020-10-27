<?php 
namespace Payroll\Controllers;


use \Framework\DatabaseTable; 

class Register                               //Class where registration, editing their privelges etc
{
	
	private $usersTable;
	
	public function __construct(DatabaseTable $usersTable)
	{
	
	
	
		
		$this->usersTable = $usersTable;                   //Will use userTable database
		
		
	}
		
	
		
		
		public function registration_form() {             //Function triggered when user clicks Register tag
			
			
			
			return ['template' => 'register.html.php',
					'title' => 'Register An Account',			
					];
		}
		
		
		
		public function success() {                    //Function triggered as _POST 
			
			
			$users = $this->usersTable->findAll();               //Get all $users in usersTable as classes into variable $users    
			return ['template' => 'registersuccess.html.php',      
					'title' => 'Register Successful',
					'variables' => [
					'users' => $users                           //Redirect to this html file along with $users variable from database to be output to HTML
					]
			];
			
			
		}
		
	

		
		public function register_user() {                     //When user click's register submit button
			
			$user = $_POST['users'];                         //Get the email, password, username
		
	        $user = array_map('trim', $user);                //Trim whitespaces
	       
			$valid = true;
			$errors = [];
			
		
		
		
		if(empty($user['email'])) {                              //Series of checks on whether registration info is correct
			
			
			$valid = false;
			
			$errors[] = 'E-mail cannot be blank';
		}
		else if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
			$valid = false;
			$errors[] = 'Invalid email address';
		}
		else{
			
			
			
			$user['email'] = strtolower($user['email']);
			
			if(count($this->usersTable->find('email', $user['email'])) > 0) {
				$valid = false;
				
				
				$errors[] = 'This email is already registered';
			}
		}
		
		
		if(empty($user['name']))
		{
			$valid = false;
			
			$errors[] = 'Name cannot be blank';
		}
		
		$finduser = $this->usersTable->find('name', $user['name']);     //Detect if the person registering got a job
		
		if(empty($finduser))
		{
		    	$valid = false;
			
			$errors[] = 'Are you an employee of Blue Ocean, Did an admin fill out your New Employee Form?';
		}
		else
		{
		    $finduser = $finduser[0];
		}
		
		if(empty($user['password'])) {
			
			
			$valid = false;
			
			$errors[] = 'Password cannot be blank';
		}
			
			
			
			
		if($valid == true) {
			// PHP hash the password
			$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
			
						
		                                         //Primary key id will be what the $finduser has, thereby triggering update in Database class
	        $user['id'] = $finduser->id;                     
	
			$this->usersTable->save($user);           //Insert function inside the save function of usersTable database
				
			
			header('location: index.php?route=user/success');         //Reroute to success page
			
		} 
		else {                                             //If registartion is invalide
			
			return ['template' => 'register.html.php',                   //Refresh page with sticky variables,
					'title' => 'Register Not Successful. Try Again',     //along with $errors variable
					'variables' => [
					'user' => $user,
					'errors' => $errors
					]
			];
			
			
		}
	}
	
	public function list() {                                    //Basic list all the users function
	
	$users = $this->usersTable->findAll();
	
	return ['template'=> 'users.html.php',
				'title' => 'User List',
				'variables' => [
				'users' => $users,
				]
				];
	
}

public function permissions(){                                  //When edit permission button is clicked in List of Registered Users tab
	$user = $this->usersTable->findById($_GET['id']);                  
	
	$reflected = new \ReflectionClass('\Payroll\Entity\Users');       //Get constants of permissions from Entity class using reflection, ex, 1, 32, 16 etc
	$constants = $reflected->getConstants();
	return ['template'=> 'permissions.html.php', 
				'title' => 'Edit Permissions',
				'variables' => [
				'user' => $user,
				'permissions' => $constants
				]
				];
	
}

public function savePermissions() {
	
	
	$user = [
	'id' => $_GET['id'],
	'permissions' => array_sum($_POST['permissions'] ?? [])              //If the user "submitted" permissions
	];                                                                  //for a user, sum the constants in the 
	                                                                //POST variable and save this new user with
	$this->usersTable->save($user);                            //new permissions column can be 63, 32, 1, etc
	header('location: index.php?route=user/list');
}

public function password_reset() {
    
    
    
   //$user = $this->usersTable->find('name', $_SESSION['username'])[0];

   
  
   	return ['template'=> 'password_reset.html.php', 
				'title' => 'Password Reset',
				'variables' => [
                'reset' => true
				]
			];

}

public function password_reset_process() {
    
   $user = $_POST['user'];
   
   $finduser = null;
     
   $user = array_map('trim', $user);                //Trim whitespaces
	       
			$valid = true;
			
			$errors = [];
   
   if($user['emailreset'] == true)
   {
       $user = $this->usersTable->find('email', $user['email']);
       
       	if(empty($user))
		{
		    	$valid = false;
			
			$errors[] = 'Are you an employee of Blue Ocean, Did an admin fill out your New Employee Form?';
		}
	
	
	
	    if($valid){
		   $finduser = $user[0];
		   
		    	return ['template'=> 'password_reset.html.php', 
				'title' => 'Password Reset',
				'variables' => [
                'reset' => false,
                'user' => $finduser
				]
			]; 
		    
		}
		   else {
      //  $user = $this->usersTable->find('name', $_SESSION['username'])[0];
        return ['template' => 'password_reset.html.php',                   //Refresh page with sticky variables,
					'title' => 'Email Reset Not Successful. Try Again',     //along with $errors variable
					'variables' => [
					'user' => $user,
					 'reset' => true,
					'errors' => $errors
					]
			];
        
    }
       
   }
   else
   {
       
 //   echo 'user name is ' . $user['name'];
  
   
   if(empty($user['password']))
   {
       $errors[] = 'Password Value is blank.';
       $valid = false;
   }
   
   if($valid)
   {
       
       
  	$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
  	 $finduser = $this->usersTable->find('name', $user['name'])[0];
  	 
  	unset($user['emailreset']);
  	$user['id'] = $finduser->id;
    $this->usersTable->save($user);
	header('location: index.php?route=user/success');
	
	
    }
    else {
        $user = $this->usersTable->find('name', $user['name'])[0];
        return ['template' => 'password_reset.html.php',                   //Refresh page with sticky variables,
					'title' => 'Password Reset Not Successful. Try Again',     //along with $errors variable
					'variables' => [
					'user' => $user,
					'reset' => false,
					'errors' => $errors
					]
			];
        
    }
   }
    
}
	
}
	