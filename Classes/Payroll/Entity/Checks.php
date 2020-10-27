<?php 
namespace Payroll\Entity;

class Checks {
    
	public $id;
	public $quantity;
	public $date;
	public $net_pay;
    public $userid;
    public $net_tax;
    public $net_deduction;
    public $amount;

	
	private $tax_deductionTable;
	private $payrollTable;
	
	private $tax_deduction;
	
	public function __construct(\Framework\DatabaseTable $tax_deductionTable, \Framework\DatabaseTable $payrollTable)
	{
		
		
		$this->tax_deductionTable = $tax_deductionTable;
		$this->payrollTable = $payrollTable;
	}
	
	public function getTax_deduction()
	{
		if(empty($this->tax_deduction)){
		$this->tax_deduction = $this->tax_deductionTable->findById($this->id);
		}
		
		return $this->tax_deduction;      //transparent caching
		
	}
	
    public function addTaxes($amount)
    {
    
      $payroll =  $this->payrollTable->findById($this->userid);
    
        $tax= [];
        $tax['id'] = $this->id;
        $tax['federal_income_tax'] =  $payroll->federal_income_tax * $amount;
        $tax['social_security'] = $payroll->social_security * $amount;
        $tax['medicare'] = $payroll->medicare * $amount;
        $tax['state_income_tax'] = $payroll->state_income_tax * $amount;
        $tax['city_income_tax'] = $payroll->city_income_tax * $amount;
  
        
        $this->tax_deductionTable->save($tax);
    }
    
    public function addDeductions($amount, $capOkay)
    { 
        $payroll =  $this->payrollTable->findById($this->userid);
        
        $deduction = [];
        
        $deduction['id'] = $this->id;
        
        //Our monthly premiums will be $440 dollars, so 220 per cycle in a month, 50% payed by employee, 50% payed by employer
        
        $deduction['health_insurance'] = 0.50 * ($payroll->health_insurance * 220);
        
         //Our monthly premiums will be $440 dollars, so 220 per cycle in a month, 50% payed by employee, 50% payed by employer
         
        $deduction['dental_health_insurance'] =  0.50 * ($payroll->dental_health_insurance * 220);
        
        if($capOkay)
        {
        
        $deduction['four01K'] = $payroll->four01K * $amount;
        
        }
        else
        {
             $deduction['four01K'] = 0;
        }
        
       
       $this->tax_deductionTable->save($deduction);
       
       return $deduction['four01K'];
        
    }
	
	
}