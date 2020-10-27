<?php 
namespace Payroll\Entity;

class Payroll {
    
	public $id;
	public $income;
	public $rate;
	public $type;
    public $federal_income_tax;
    public $social_security;
    public $medicare;
    public $state_income_tax;
    public $city_income_tax;
    public $health_insurance;
    public $dental_health_insurance;
    public $four01K;

	
	private $usersTable;
	private $user;
	
	
	public function __construct(\Framework\DatabaseTable $usersTable)
	{
		
		$this->usersTable = $usersTable;
		
	}
	
	
	public function getUser()
	{
		if(empty($this->user)){
		$this->user = $this->usersTable->findById($this->userid);
		}
		
		return $this->user;      //transparent caching
		
	}
	
	public function addUser($user) {
		
		$user['id'] = $this->id;
	
	 return $this->usersTable->save($user);
		
	}
	
	public function calculateGross($array)
	{
	    $array['id'] = $this->id;
	}
	
	
	public function serialize()
	{
	    return " income:   $this->income   rate:   $this->rate   type:  $this->type   federal_income_tax: $this->federal_income_tax   social_security:  $this->social_security  medicare:   $this->medicare  state_income_tax:  $this->state_income_tax  city_income_tax: $this->city_income_tax health_insurance: $this->health_insurance four01K: $this->four01K " ;
	}
	
}