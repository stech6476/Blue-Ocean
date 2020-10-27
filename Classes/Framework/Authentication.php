<?php 
namespace Framework;                       //Framework classes can be used in any project, like a library

class Authentication                           //Class for user authentication
{
	
	private $users;
	private $usernameColumn;
	private $passwordColumn;
	
	public function __construct(DatabaseTable $users, string $usernameColumn, string $passwordColumn) {
		
		session_start();                          //Using sessions instead of cookies for more security
		$this->users = $users;
		$this->usernameColumn = $usernameColumn;
		$this->passwordColumn = $passwordColumn;
		
	}
	
	
	public function login($username, $password) {             //Get username/password from textbox
		
		$user = $this->users->find($this->usernameColumn, $username);       //Use the database mysql find function to match the databse username/password with textbox username/password
		
		
		
		if(!empty($user)) {                          //If there is no username, the user is invalid
			if($password == $user[0]->{$this->passwordColumn} || password_verify($password, $user[0]->{$this->passwordColumn})){     //Simple non-hashed password check,     //PHP password_verify hashing password check for those who chose to hash the passwords

		                                        
				session_regenerate_id();  //avoid sesssion fixation
				
				$_SESSION['username'] = $username;                     //If everything is check, put username/password to $_SESSION variable, $_SESSION will never get deleted unless unset
				$_SESSION['password'] = $user[0]->{$this->passwordColumn};
				
				return true;
				
			}
			else           //If the passwords did not match the user is invalid
			{
			   
			    	return false;
			}
			
	}
	else
	{
			    
	    	return false;
	}
	
			
		
	}
	
	
	public function isLoggedIn()                  //Same as above function
	{
		if(empty($_SESSION['username'])) {
			

			return false;
		}
		
		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
		//$user = $this->users->find($this->usernameColumn, $_SESSION['username']);
	
		$passwordColumn = $this->passwordColumn;
		if(!empty($user) && $user[0]->$passwordColumn === $_SESSION['password']) {
			return true;
		}
		else
			return false;
	}
	
	public function getUser(){                          //Return all the details of a logged in user
		if($this->isLoggedIn()) {
			return $this->users->find($this->usernameColumn,  $_SESSION['username'])[0];
		}
		else {
			return false;
		}
	}
	
}
	
	
	
	
	
	
	
	
	
	