<?php  
namespace Payroll\Entity;                       //Helper function for Users Controller

class Tax_Deduction{
    
	public $federal_income_tax;                                 //Entity classes will have all of its fields public for easy access
	
	public $social_security;
	
	public $medicare;
	
	public $state_income_tax;
	
	public $city_income_tax;
	
	public $health_insurance;
	
	public $dental_health_insurance;
	
	public $four01K;
	
  
    

	public function __construct()
	{
		
	}

	
}