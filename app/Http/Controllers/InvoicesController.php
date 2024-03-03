<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use App\Models\invoices;
use App\Models\User;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AddInvoice;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $sections = sections::all();
        $invoices = invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoices',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'total' => $request->total,
            'note' => $request->note,


        ]);

        $id_invoice = invoices::latest()->first()->id;

        invoices_details::create([
            'id_Invoice' => $id_invoice,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->section,
            'Status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::User()->name),

        ]);

        
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        
        
         $user = User::get();
         $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoicrs_new($invoices));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.Status_update',compact('invoices'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = sections::all();
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.edit_invoices',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrfail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        session()->flash('edit','تم التعديل بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id',$id)->first();
        $details = invoice_attachments::where('invoice_id',$id)->first(); 

     
        if(!empty($details->invoice_number)){
          //storage::disk('public_uploads')->delete($details->invoice_number.'/'.$details->file_name);
               // delete folder all
          storage::disk('public_uploads')->deleteDirectory($details->invoice_number);

        }
        $invoices->forcedelete();
        session()->flash('delete_invoices');
        return redirect('/invoices');
    }

    public function archive(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id',$id)->first();
        $invoices->delete();
        session()->flash('Archive_invoices','تم ارشفة الفاتورة بنجاح');
        return redirect('/Achive');
    }



    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function Status_update($id,Request $request)
    {
         //   dd($request->Status);
        $invoices = invoices::findOrFail($id);
           //return $request->invoice_id;
        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section,
                'Status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section,
                'Status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update','تم تحديث الفاتورة بنجاح');
        return redirect('/invoices');

    }

    public function invoices_paid()
    {
       $invoices = invoices::where('value_status',1)->get();
       return view('invoices.invoices_paid',compact('invoices'));
    }
    public function invoices_unpaid()
    {
       $invoices = invoices::where('value_status',2)->get();
       return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function invoices_partial()
    {
       $invoices = invoices::where('value_status',3)->get();
       return view('invoices.invoices_partial',compact('invoices'));
    }

    public function print_invoice($id)
    {
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }

    public function markasRead_All(Request $request)
    {
        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
       }
    }
  
}