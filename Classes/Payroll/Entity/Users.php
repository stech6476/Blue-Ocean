<?php  
namespace Payroll\Entity;                       //Helper function for Users Controller

class Users {
	public $id;                                 //Entity classes will have all of its fields public for easy access
	public $name;
	public $email;
	public $password;
	public $permissions;
	public $phone;
	public $social_security;
	public $address;
	public $note;
	public $payment_method;
	public $notification;
	
    private $checksTable;
    
    private $payrollTable;
    
    private $grossTable;
    
    private $clock_in_clock_outTable;
    
    private $payroll;
    
    private $gross;
    
	const NEW_EMPLOYEE_REGISTER = 1;                              //2^6 bitwise-permissions const variables
	const EMPLOYEE_SEARCH = 2;
	const PAYROLL_PROCESSING = 4;
	const DEDUCTIONS = 8;
	const TAX = 16;
	const EDIT_USER_ACCESS = 32;
	
	public function __construct(\Framework\DatabaseTable $checksTable, \Framework\DatabaseTable $payrollTable, \Framework\DatabaseTable $grossTable, \Framework\DatabaseTable $clock_in_clock_outTable)
	{
			
			$this->checksTable = $checksTable;
			$this->payrollTable = $payrollTable;
			$this->grossTable = $grossTable;
			$this->clock_in_clock_outTable = $clock_in_clock_outTable;
	}
	
	public function getPayroll()
	{
		if(empty($this->payroll)){
		$this->payroll = $this->payrollTable->findById($this->id);
		}
		
		return $this->payroll;      //transparent caching
		
	}
	
	public function getGross()
	{
        if(empty($this->gross)){
		$this->gross = $this->grossTable->findById($this->id);
		}
		
		return $this->gross;      //transparent caching
	}
	
	public function addDivision($division)
	{
	     $this->payrollTable->save($division);
	}
	
	
	public function addTaxes($taxes)
	{
	    
	    $this->payrollTable->save($taxes);
	}
	
	public function addDeductions($deductions)
	{
	     $this->payrollTable->save($deductions);
	}
	

	public function hasPermission($permission) {
		
		return $this->permissions & $permission;                         //XORING function
		
	}
	
	public function addPayroll($check) {
		
		$check['userid'] = $this->id;           //foreign key is userid
		
   
    return	$this->checksTable->save($check);
	
	}
	
	public function addGross($gross)
	{
	    $gross['id'] = $this->id;
	    
	    $this->grossTable->save($gross);
	}
	
	public function addClockIn($clock)
	{
	    $clock['id'] = $this->id;
	    
	 
	    
	      $this->clock_in_clock_outTable->save($clock);
	}
	
	public function addDifference($clock)
	{
	    $clock['id'] = $this->id;
	    
	  
	    
	    $clock['clock_in'] = NULL;
	    
	 
	    
	     $this->clock_in_clock_outTable->save($clock);
	     
	     
	    
	    
	}
	
	public function resetClock()
	{
	     $clock['id'] = $this->id;
	   $clock['clock_in'] = NULL;
	     $clock['difference'] = '00:00:00';
	     $clock['overtime'] = NULL;
	     
	        $this->clock_in_clock_outTable->save($clock);
	    
	}
	
	public function addTimeClock()
	{
	     $clock['id'] = $this->id;
	     $clock['difference'] = '00:00:00';
	      $this->clock_in_clock_outTable->save($clock);
	}
	
    public function getClock()
    {
        return  $this->clock_in_clock_outTable->findById($this->id);
    }
    
    
	
	public function getCheckByDate($date)
	{
	 
	    $checks = $this->checksTable->find('date', $date);
	    $foundcheck = null;
	    foreach($checks as $check)
	    {
	        if($check->userid == $this->id)
	        {
	            $foundcheck = $check;
	        }
	    }
	    return $foundcheck;
	
	}
	
	public function serialize()
	{
	    return "id:   $this->id   name:   $this->name   email:   $this->email   password:  ------ ' permissions:    $this->permissions   phone:  $this->phone   social_security:   ------- address: $this->address note: $this->note payment_method: " . strtok($this->payment_method, '\n') . "notifications: $this->notification";
	}
	
	
	
	
}