<?php

namespace Framework;


class EntryPoint 
{
	
	private $tab;
	private $routes;
	private $method;
	
	public function __construct(string $tab, string $method, \Framework\Routes $routes)
	{
		$this->tab = $tab;
		$this->routes = $routes;	
		$this->method = $method;
		$this->checkUrl();
	}
	
	private function checkUrl() {
		if($this->tab !== strtolower($this->tab)) {                               //If URI is uppercase change to lowercase for SEO
		http_response_code(301); //redirection is permanent
		header('location: index.php?route=' . strtolower($route));
		}
	}
	
	private function loadTemplate($templateFileName, $variables = [])              
{
	extract($variables);                                               //If there are variables extract them
	 
	ob_start();                                                        //Start a buffer
	
	include __DIR__ . '/../../Templates/' . $templateFileName;   //Open the required html page from Templates directory, 
	
	 
	return ob_get_clean();                                            //Input all the HTML into buffer pass it to $output variable
	
}


	public function run() {
		
		$authentication = $this->routes->getAuthentication();
		
			$routes = $this->routes->getRoutes();                                //Get flowchart/array of project
	
		
		
		if(isset($routes[$this->tab]['login']) && !$authentication->isLoggedIn()) {         //Case 1: if the tab has a 'login' => true index, then check if the user's Session id password matches the usersTable password, If true proceed to Case 2
		
	
		header('location: index.php?route=login/error');	 //Else redirect to homepage, 
		}
		else if(isset($routes[$this->tab]['permissions']) && !$this->routes->checkPermission($routes[$this->tab]['permissions']))                                                       //Case 2: if the tab
		{                                                                                //has a 'permissions' index then xor the Payroll/Entity/User const variabel EDIT_USER_ACCESS 32 with user's permission variable from users Table, if true proceed to Case 3
			 
				header('location: index.php?route=login/permission');	 //Else redirect to no permissions page
		}
		else {
	
	
	
		$controller = $routes[$this->tab]                                         //Case 3: Get the controller 
			[$this->method]['controller'];                                          //for the tab, can be 
			                                                                      //payroll controller, or                                  userController
			                                                                      
			$action = $routes[$this->tab]                                         //Get what action or function
			[$this->method]['action'];                                            //To perform
			
			//$page = $controller->{$action}();
			$page = $controller->$action();                                       //Trigger the function
			                                                     //Ex - $page = $payrollController -> home
		//$page = $this->routes->callAction($this->route);
		
		
		                                                                      //$page will be an array with a $title, $variables, and $template
	
		$title = $page['title'];	
		
		if(isset($page['variables'])) {
		$output = $this->loadTemplate($page['template'],          //Next proceed to loadTemplate function above
		$page['variables']);
		}                  
	else {
		$output = $this->loadTemplate($page['template']);            //$output contains all html of tab page
	}
	
		echo $this->loadTemplate('header.html.php', [                 //After loadTemplate, proceed to open 
		'loggedIn' => $authentication->isLoggedIn(),                  //default header.html.php, this is how                                                               the
			'output' => $output,                                     //tabs are always visible whenever the                                                            page
			'title' => $title,
			
			'permissions' => $authentication->getUser()->permissions ?? ' '
		                                                           	//changes
		]);                                                        //Pass the $title, $output, $loggedIn true or false to header.html 
		
	}
	
	}
}
?>