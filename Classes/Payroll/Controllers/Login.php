<?php 
namespace Payroll\Controllers;

class Login                             //Login Controller for login/logout/invalid login/invalid permission
{
	
	private $authentication;
	
	public function __construct(\Framework\Authentication $authentication) 
	{
		
		$this->authentication = $authentication;                    //Will use authentication class
		
		
	}
	
	public function permissionError() {                          
		
		$user = $this->authentication->getUser();
			return ['template'=> 'permissionerror.html.php',  'title'
			=> 'Permission Error',
		];
		
	}
	
	public function error()
	{
		return ['template'=> 'loginerror.html.php', 'title'
		=> 'You Are Not Logged In'];
		
	}
	
	public function loginForm() {                                //If the user pressed Login In tab, Payroll Routes will trigger this function, a simple $GET function
		 
		return ['template'=> 'login.html.php', 'title'
		=> 'Log In'];
		
		
	}
	
	public function processLogin() {                        //Then if the user pressed submit button for logon.html.php, this function will be triggered as a POST request
		
		$user = $_POST['user'];                               //Get all the post variables from login.html.php
		
		if($this->authentication->login($user['name'], $user['password'])) {       //If the authentication class found a match from textbox username to database username 
			header('location: index.php?route=login/success');            //Go to login/success array index in payroll/routes, this is like pressing a tab without the user pressing a tab
		
		}
		else {
			return ['template'=> 'login.html.php',                      //If the authentication class did not
			'title'	=> 'Log in Again Please',                     //find a match, redo the login.html.php file
		'variables' => [
		'error' => 'Invalid Username/Password.',
		'user' => $user                           //Send 'user' as 'variables' to refill the textbox to make it sticky
		]
	];

		}
	}

	

	
	public function success() {
		
		return ['template'=> 'loginsuccess.html.php', 'title'
		=> 'Login Successful'];
		
		
	}
	
	
	public function logout() {
		
		//unset($_SESSION);                            //When logging out, erase the SESSION password/username
		$_SESSION = [];
		session_destroy();
		return ['template'=> 'logout.html.php', 'title'
		=> 'You Have Been Logged Out'];
		
		
	}
	
	
}