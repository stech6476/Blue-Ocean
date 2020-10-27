<?php
namespace Payroll;          //namespace is what directory this php file is in

use \Framework\DatabaseTable;                  //Like c++ using namespace std; 

class PayrollRoutes implements \Framework\Routes        //implements interface from Routes.php in Framework, 
{                                                        //interface was covered in CSC OOP class
    
	private $payrollTable;                             //class variables
		
	private $usersTable;
	
	private $checksTable;
	
	private $tax_deductionTable;
	
	private $grossTable;
	
    private $retireeTable;
    
    private $clock_in_clock_outTable;
    
	private $authentication;
	
	
	
	
	public function __construct() {                      //constructor
		
		include __DIR__ . '/../../Safe/DatabaseConnection.php';        //Get $pdo from database connection, notice can't use autoload this because its in Safe directory not the Classes directory
		
		
	$this->payrollTable = new \Framework\DatabaseTable($pdo, 'payroll', 'id', '\Payroll\Entity\Payroll', [&$this->usersTable]);         //Instantiate class variables to database tables 
		
			$this->usersTable = new \Framework\DatabaseTable($pdo, 'users', 'id', '\Payroll\Entity\Users', [&$this->checksTable, &$this->payrollTable, &$this->grossTable, &$this->clock_in_clock_outTable]);      //This userstable will have an extra helper Entity class called Users
			
		
		$this->checksTable = new \Framework\DatabaseTable($pdo, 'checks', 'id', '\Payroll\Entity\Checks',
		        [&$this->tax_deductionTable, &$this->payrollTable]);
		
		
		
		$this->tax_deductionTable = new \Framework\DatabaseTable($pdo, 'tax_deduction', 'id', '\Payroll\Entity\Tax_Deduction', [&$this->tax_deductionTable]);
		
		
		$this->grossTable = new \Framework\DatabaseTable($pdo, 'gross', 'id', '\Payroll\Entity\Gross');
		
		$this->retireeTable = new\Framework\DatabaseTable($pdo, 'retiree', 'id', '\Payroll\Entity\Retiree');
		
		$this->clock_in_clock_outTable = new\Framework\DatabaseTable($pdo, 'clock_in_clock_out', 'id');
		
		
		$this->authentication = new \Framework\Authentication($this->usersTable, 'name', 'password');
		//Authentication is not a database class, its just a normal class that gets the usersTabele, what the username and password is
				
	
	}
	
	
	
 public function getRoutes() : array {             //Main Function that sends the skeleton or flowchart of entire project routes as an array to EntryPoint.php
 
 //Controllers is the classes where functions reside
     
	$payrollController = new \Payroll\Controllers\PayrollController($this->payrollTable, $this->usersTable, $this->checksTable, $this->tax_deductionTable, $this->grossTable, $this->retireeTable, $this->clock_in_clock_outTable, $this->authentication);                  //Payroll Controller will receive a Payroll database, usersTable database, authentication class
		
			$usersController = new \Payroll\Controllers\Register($this->usersTable);
			//Users controller will get the usersTable database for registering
			
			$loginController = new \Payroll\Controllers\Login($this->authentication);
			//Login Controller will get an authentication class for login

	
		$routes = [
				
				'payroll/home' => [                              //payroll/home from header.html will have a                                               $_SERVER['REQUEST_METHOD'] of 'GET' only that                                         will use the $payrollController to start the                                                "action"(function) home
					'GET' => [
						'controller' => $payrollController,
						'action' => 'home'
						]
				],
				
					'payroll/divisions' => [               //payroll/division from header.html will have a                                               $_SERVER['REQUEST_METHOD'] of 'GET' only that                                         will use the $payrollController to start the                                                "action"(function) divisions
					'GET' => [
						'controller' => $payrollController,
						'action' => 'divisions'
						]
				],
				
				
					'payroll/papercheck' => [              
					'GET' => [
						'controller' => $payrollController,
						'action' => 'papercheck'
						],
					'POST' => [
					    'controller' => $payrollController,
						'action' => 'process_papercheck'
					    ],
			      	'login' => true,
				],
				
					'payroll/dispute_check' => [              
					'GET' => [
						'controller' => $payrollController,
						'action' => 'dispute_check'
						],
					'POST' => [
					    'controller' => $payrollController,
						'action' => 'process_dispute_check'
					    ],
					    'login' => true
			      
				],
				
				
				
					'payroll/printer' => [              
					'POST' => [
						'controller' => $payrollController,
						'action' => 'printer'
						]
			     
				],
				
				
				
				'payroll/recalculate' => [
					'POST' => [
						'controller' => $payrollController,
						'action' => 'recalculate'
						]
				],
				
				'payroll/calculate' => [
				    
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'salary'
				        ],
				    'POST' => [
				         'controller' => $payrollController,
				        'action' => 'calculate_salary'
				        
				        ],
				    
				    ],
				
				
				
				'payroll/clock_in_out' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'clock_in_out'
				        ],
				    'POST' => [
				         'controller' => $payrollController,
				        'action' => 'process_clock_in_out'
				        
				        ],
				         'login' => true
				    ],
				    
				    
				    	
				'payroll/notification' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'notification'
				        ],
				    'POST' => [
				         'controller' => $payrollController,
				        'action' => 'process_notification'
				        
				        ],
				         'login' => true
				    ],
				    
				    	'payroll/health_notification' => [
				  
				    'POST' => [
				         'controller' => $payrollController,
				        'action' => 'health_process_notification'
				        
				        ]
				    ],
				    
				    'payroll/health_insurance_processing' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'health_insurance'
				        ],
				    'POST' => [
				         'controller' => $payrollController,
				        'action' => 'health_insurance_process'
				        
				        ]
				    ],

				
				'payroll/payroll_processing' => [              
					'GET' => [
						'controller' => $payrollController,
						'action' => 'payrollProcessing'
						],
					'POST' => [
					    'controller' => $payrollController,
						'action' => 'input_hours_worked'
					    
					    ],
					    
					 'permissions' => \Payroll\Entity\Users::PAYROLL_PROCESSING
				],
			
				
				
				'payroll/payroll_new_employee' => [
				    'GET' => [
						'controller' => $payrollController,
						'action' => 'payroll_new_employee',
						],
					'POST' => [
					    'controller' => $payrollController,
						'action' => 'process_new_employee'
					    
					    ],
					    
				   'permissions' => \Payroll\Entity\Users::NEW_EMPLOYEE_REGISTER
				    
				],
				
				
				'payroll/tax' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'tax_processing'
				        ],
				        
				    'POST' => [
				        'controller' => $payrollController,
				        'action' => 'input_tax'
				        
				        ],
				     'permissions' => \Payroll\Entity\Users::TAX
				    
				],
				
				'payroll/deductions' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'deduction_processing'
				        ],
				        
				    'POST' => [
				        'controller' => $payrollController,
				        'action' => 'input_deduction'
				        
				        ],
				   'permissions' => \Payroll\Entity\Users::DEDUCTIONS
				    
				],
				
				
				'payroll/gross' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action' => 'gross'
				        ]
				    
				],
				   
				    
				    
				'payroll/employee_search' => [
				    'GET' => [
				        'controller' => $payrollController,
						'action' => 'employee_search'
				        ],
				        
				     'permissions' => \Payroll\Entity\Users::EMPLOYEE_SEARCH 
				],
				
				'payroll/employee_edit' => [
				    'GET' => [
				        'controller' => $payrollController,
						'action' => 'employee_edit'
				        ],
				    'POST' => [
				        'controller' => $payrollController,
						'action' => 'employee_edit_process'
				        ]
				],
				  
				  
				 'payroll/employee_delete' => [
				    'POST' => [
				        'controller' => $payrollController,
						'action' => 'employee_delete'
				        ]
				], 
				
				'payroll/payroll_success' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action'=> 'payroll_success'
				        ]
				],
				
				'payroll/retiree' => [
				    'GET' => [
				        'controller' => $payrollController,
				        'action'=> 'retiree'
				        ]
				],
			
				
				
				'user/register' => [                        //user/register from header.html tab will have a                                               $_SERVER['REQUEST_METHOD'] of 'GET' that                                         will use the $usersController to start the                                                "action"(function) registration_form
				                                        //Once the user enters submit $_SERVER['REQUEST_METHOD'] will be now 'POST' that will automatically trigger the 'POST" => register_user function down below
				    
					'GET' => [
						'controller' => $usersController,
						'action' => 'registration_form'
						],
					'POST' => [
						'controller' => $usersController,
						'action' => 'register_user'
						]
				],
				
				'user/success' => [
					'GET' => [
						'controller' => $usersController,
						'action' => 'success'
						]
				],
				
				'user/view' => [
					'GET' => [
						'controller' => $usersController,
						'action' => 'success'
						]
				],
				
				'user/permissions' => [                                
				'GET' => [
				'controller' => $usersController,
				'action' => 'permissions'
				],
				
				
				'POST' => [
				'controller' => $usersController,
				'action' => 'savePermissions'
				],
				'login' => true,
				'permissions' => \Payroll\Entity\Users::EDIT_USER_ACCESS
				],
				
				
				
				'user/list' => [
				'GET' => [
				'controller' => $usersController,
				'action' => 'list'
				],
				'login' => true,
				'permissions' => \Payroll\Entity\Users::EDIT_USER_ACCESS
				],
				
				'user/password_reset' => [
				'GET' => [
				'controller' => $usersController,
				'action' => 'password_reset'
				],
				
				'POST' => [
				'controller' => $usersController,
				'action' => 'password_reset_process'
				]
				
				],
				
				
				'login/error' => [
				'GET' => [
						'controller' => $loginController,
						'action' => 'error'
						]
				],
				
				
						
				'login/permission' => [
				'GET' => [
						'controller' => $loginController,
						'action' => 'permissionError'
						]
				],		
						
						
						
				'login' => [
				'GET' => [
						'controller' => $loginController,
						'action' => 'loginForm'
				],
				
				
				'POST' => [
						'controller' => $loginController,
						'action' => 'processLogin'
						]
				],
				
				
					
					'login/success' => [
				'GET' => [
						'controller' => $loginController,
						'action' => 'success'
					],
					'login' => true
						],
						
						
					'logout' => [
				'GET' => [
						'controller' => $loginController,
						'action' => 'logout'
						]
					]
			
			];
			
			return $routes;
 
				

		}
		
		
		public function getAuthentication() : \Framework\Authentication{
			
			
			return $this->authentication;                                    
			
			
			
		}
		
		
		public function checkPermission($permission): bool {                    
			$user = $this->authentication->getUser();                      //Returns a user from usersTable
			   
			
			
			if($user && $user->hasPermission($permission)) {               //If the user's permission number in database xored with $permission from the variable in the parameter is true return true
				
				return true;
			} else {
				return false;
			}
		}
		
}		
?>