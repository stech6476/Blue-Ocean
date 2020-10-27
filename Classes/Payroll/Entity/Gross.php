<?php 
namespace Payroll\Entity;

class Gross {
    
	public $id;
	public $gross_tax;
	public $gross_deduction;
	public $total_income;

	

	public function __construct()
	{
		
		
	
	}
	
	
	
    	
	public function serialize()
	{
	    return " gross_tax:   $this->gross_tax   gross_deduction:  $this->gross_deduction   total_income:  $this->total_income";
	}
	
	
}