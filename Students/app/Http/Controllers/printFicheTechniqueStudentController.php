<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class printFicheTechniqueStudentController extends Controller
{
   function index()
    {
	    $student_data = $this->get_student_data();
     	return view('dynamic_pdf')->with('student_data', $student_data);
    }

    function get_student_data()
    {
	    $student_data = DB::table('eleves')
        ->limit(10)
        ->get();
    	return $student_data;
    }

    function pdf()
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_student_data_to_html());
     return $pdf->stream();
    }

    function convert_student_data_to_html()
    {
     $student_data = $this->get_student_data();
     $output = '
     <h3 align="center">student Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Address</th>
    <th style="border: 1px solid; padding:12px;" width="15%">City</th>
    <th style="border: 1px solid; padding:12px;" width="15%">Postal Code</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Country</th>
   </tr>
     ';  /*
     foreach($student_data as $student)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$student->studentName.'</td>
       <td style="border: 1px solid; padding:12px;">'.$student->Address.'</td>
       <td style="border: 1px solid; padding:12px;">'.$student->City.'</td>
       <td style="border: 1px solid; padding:12px;">'.$student->PostalCode.'</td>
       <td style="border: 1px solid; padding:12px;">'.$student->Country.'</td>
      </tr>
      ';
     }*/
     $output .= '</table>';
     return $output;
    }
}
