<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        $count_all = invoices::count();
        $count_invoices2 = invoices::where('value_status',2)->count();
        $count_invoices22 = $count_invoices2 /  $count_all * 100 ;

        $count_invoices1 = invoices::where('value_status',1)->count();
        $count_invoices11 = $count_invoices1 /  $count_all * 100 ;

        $count_invoices3 = invoices::where('value_status',3)->count();
        $count_invoices33 = $count_invoices3 /  $count_all * 100 ;

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$count_invoices22]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$count_invoices11]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$count_invoices33]
                ],


            ])
            ->options([]);

    
return view('home', compact('chartjs'));

    }
}
