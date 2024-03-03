<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class Invoices_Report extends Controller
{
 public function index()
  {
    return view('reports.invoices_report');
  }

 public function searsh_invoices(Request $request)
  {
    $rdio = $request->rdio;

    if($rdio == 1){
        
             if($request->type && $request->start_at =='' && $request->end_at ==''){
                $invoices = invoices :: select('*')->where('status','=',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report',compact('type'))->withDetails($invoices);
             } else {
               $start_at = date($request->start_at);
               $end_at = date($request->end_at);
               $type = $request->type;
               $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$request->type)->get();
               return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);
            }
  } else {
    $invoices = invoices :: select('*')->where('invoice_number','=',$request->invoice_number)->get();
    return view('reports.invoices_report')->withDetails($invoices);


  }
}
}