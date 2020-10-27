<?php 
include __DIR__ . '/../public_html/css/fpdf181/fpdf.php';  





$pdf = new FPDF('L','in','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);       

$pdf->Cell(10,.4117,'General Information                                          Pay Frequency Weekly (24 Pay Periods)', 1, 1, 'L');  


$pdf->SetFont('Arial','B',10); 

$pdf->Cell(5,.4117,'Employee: '. ucwords($_SESSION['username']) , 1, 0, 'L');  
$pdf->Cell(5,.4117,'Check #: '. $check->id , 1, 1, 'L');  
$pdf->Cell(4,.4117,'Address: '. $user->address , 1, 0, 'L');  
$pdf->Cell(2,.4117,'Phone: '. $user->phone , 1, 0, 'L'); 
$arr = explode("\n",$user->payment_method);
$pdf->Cell(3,.4117,'Payment-Method : '. $arr[0] , 1, 1, 'L'); 



$pdf->SetFont('Arial','B',16);  


$pdf->Cell(10,.4117,'Income Details', 1, 1, 'L');

$pdf->SetFont('Arial','B',10); 

$pdf->Cell(2,.4117,'Income: ' . $payroll->income , 1, 0, 'L');
$pdf->Cell(1.67,.4117,'Rate: '. $payroll->rate, 1, 0, 'L');
//$pdf->Cell(2,.4117,'Type: ' . $payroll->type , 1, 0, 'L');
$pdf->Cell(1.67,.4117,'Quantity: ' . $check->quantity , 1, 0, 'L');
$pdf->Cell(1.67,.4117,'Amount: ' . $check->amount , 1, 0, 'L');
$pdf->Cell(1.67,.4117,'Gross Pay: ' . $gross->total_income , 1, 0, 'L');

 $time = explode(':', $check->quantity);

   $hoursworked = $time[0];   $minutes = $time[1];    $quantity = $hoursworked + ($minutes/60);
    
    $amount = $quantity * $payroll->rate;
    
     if($amount < $check->amount)
    {
        $decrement = $check->amount - $amount;
        
       $weight  = $decrement * 1.5 * $payroll->rate;
       
       $decrement = $check->amount - $weight;
       
       if($decrement > $weight)
       {
    
       
         $decrement = $decrement - $weight;
         
          $decrement = $check->amount - $decrement;
         
       
       $overtime = $decrement/$payroll->rate;
       
       }
       else
       {
       
           $decrement = $weight - $decrement;
         
            $decrement = $check->amount + $decrement;
                $overtime = $decrement/$payroll->rate;
            
           
       }

    }
    else
    {
          $overtime = 0;
    }
    
    
$pdf->Cell(1.33,.4117,'Overtime: ' . number_format($overtime,2) , 1, 1, 'L');




$pdf->SetFont('Arial','B',16);  
$pdf->Cell(5,.4117,'Tax Details', 1, 0, 'L');                   //Start of Tax Deduction Header
$pdf->Cell(5,.4117,'Deduction Details', 1, 1, 'L');


$pdf->SetFont('Arial','B',12);      


$pdf->Cell(2.4117,.4117,'Tax', 1, 0, 'L');            
$pdf->Cell(1.25,.4117,'Amount', 1, 0, 'L');
$pdf->Cell(1.25,.4117,'Gross', 1, 0, 'L');

$pdf->Cell(2,.4117,'Deduction', 1, 0, 'L');
$pdf->Cell(1,.4117,'Amount', 1, 0, 'L');
$pdf->Cell(1,.4117,'Gross', 1, 0, 'L');        
$pdf->Cell(1,.4117,'Cap', 1, 1, 'L'); 

$pdf->SetFont('Arial','B',10);  
                                                            //Start of Tax/Deduction Cells
$pdf->Cell(2.4117,.4117,'Federal Income Tax', 1, 0, 'L');  
$pdf->Cell(1.25,.4117,$tax_deduction->federal_income_tax , 1, 0, 'L');
$pdf->Cell(1.25,.4117,$gross_federal_income_tax, 1, 0, 'L');

$pdf->Cell(2,.4117,'Health Insurance', 1, 0, 'L'); 
$pdf->Cell(1,.4117,$tax_deduction->health_insurance , 1, 0, 'L');
$pdf->Cell(1,.4117,$gross_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117,'--------', 1, 1, 'L');


$pdf->Cell(2.4117,.4117,'Social Security', 1, 0, 'L');  
$pdf->Cell(1.25,.4117,$tax_deduction->social_security , 1, 0, 'L');
$pdf->Cell(1.25,.4117,$gross_social_security, 1, 0, 'L');

$pdf->Cell(2,.4117,'401K', 1, 0, 'L'); 
$pdf->Cell(1,.4117,$tax_deduction->four01K , 1, 0, 'L');
$pdf->Cell(1,.4117,$gross_four01K, 1, 0, 'L');
$pdf->Cell(1,.4117,'$9,500', 1, 1, 'L');

$pdf->Cell(2.4117,.4117,'Medicare', 1, 0, 'L');  
$pdf->Cell(1.25,.4117,$tax_deduction->medicare , 1, 0, 'L');
$pdf->Cell(1.25,.4117,$gross_medicare, 1, 0, 'L');

$pdf->Cell(2,.4117,'401K Employer', 1, 0, 'L'); 
$pdf->Cell(1,.4117,$tax_deduction->four01K , 1, 0, 'L');
$pdf->Cell(1,.4117,$gross_four01K, 1, 0, 'L');
$pdf->Cell(1,.4117,'$9,500', 1, 1, 'L');


$pdf->Cell(2.4117,.4117,trim(explode(',', $payroll->division)[0]) . ' State Income Tax' , 1, 0, 'L');  
$pdf->Cell(1.25,.4117,$tax_deduction->state_income_tax  , 1, 0, 'L');
$pdf->Cell(1.25,.4117,$gross_state_income_tax, 1, 0, 'L');


$pdf->Cell(2,.4117,'Health Insurance Employer', 1, 0, 'L'); 
$pdf->Cell(1,.4117,$tax_deduction->health_insurance , 1, 0, 'L');
$pdf->Cell(1,.4117,$gross_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117,'------', 1, 1, 'L');

/*$pdf->Cell(2,.4117,'Employer', 1, 0, 'L'); 
$pdf->Cell(1,.4117,$tax_deduction->four01K , 1, 0, 'L');
$pdf->Cell(1,.4117,$gross_four01K, 1, 0, 'L');
$pdf->Cell(1,.4117,'$9,500', 1, 1, 'L');*/

$pdf->Cell(2.4117,.4117,trim(explode(',', $payroll->division)[1]) . ' Local Income Tax' , 1, 0, 'L');  
$pdf->Cell(1.25,.4117,$tax_deduction->city_income_tax  , 1, 0, 'L');
$pdf->Cell(1.25,.4117,$gross_city_income_tax, 1, 0, 'L');

$pdf->Cell(2,.4117,'Dental Health Insurance', 1, 0, 'L');
$pdf->Cell(1,.4117, $tax_deduction->dental_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117, $gross_dental_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117,'------', 1, 1, 'L');

$pdf->Cell(4.932,.4117,' ', 0, 0, 'L');
$pdf->SetFont('Arial','',9);  
$pdf->Cell(2,.4117,'Employer Dental Health Insurance', 1, 0, 'L');
$pdf->Cell(1,.4117, $tax_deduction->dental_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117, $gross_dental_health_insurance, 1, 0, 'L');
$pdf->Cell(1,.4117,'------', 1, 1, 'L');



$pdf->SetFont('Arial','B',16);     
$pdf->Cell(10,.4117,'Check Summary', 1, 1, 'L');                        //Start of Check Summary Header



$pdf->SetFont('Arial','B',12); 

$pdf->Cell(2,.4117,'', 1, 0, 'L');
$pdf->Cell(2,.4117,'Total Incomes', 1, 0, 'L');
$pdf->Cell(2,.4117,'Total Tax', 1, 0, 'L');
$pdf->Cell(2,.4117,'Total Deduction', 1, 0, 'L');
$pdf->Cell(2,.4117,'Net Pay', 1, 1, 'L');



$pdf->Cell(2,.4117,'This Check', 1, 0, 'L');

$pdf->SetFont('Arial','B',10);  
                                   

$pdf->Cell(2,.4117,$check->amount, 1, 0, 'L');
$pdf->Cell(2,.4117,$net_tax, 1, 0, 'L');
$pdf->Cell(2,.4117,$net_deduction, 1, 0, 'L');
$pdf->Cell(2,.4117,$net_pay, 1, 1, 'L');


$pdf->SetFont('Arial','B',12); 

$pdf->Cell(2,.4117,'Gross', 1, 0, 'L');

$pdf->SetFont('Arial','B',10);  


$pdf->Cell(2,.4117,$gross->total_income, 1, 0, 'L');
$pdf->Cell(2,.4117,$gross->gross_tax, 1, 0, 'L');
$pdf->Cell(2,.4117,$gross->gross_deduction, 1, 0, 'L');
$pdf->Cell(2,.4117,$net_total_income, 1, 1, 'L');



$pdf->Output();



?>