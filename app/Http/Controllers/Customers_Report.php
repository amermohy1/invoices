<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\sections;

class Customers_Report extends Controller
{
    public function index(){
      // $invoices = invoices::all();
       $sections = sections::all();
       return view('reports.customers_report',compact('sections'));
    }

    public function searsh_customers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at =='' ) {
            $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);

        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);

        }
    }
}
