<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; 
use  Illuminate\Validation;
use Illuminate\Support\Facades\DB;
use  Illuminate\Database\Query;
use App\Http\Controllers\CallsController;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::Paginate(10);
        return view("report",  [
            'reports' => $reports
           
        ]);
       
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => ['required'],
            'period' => ['required'],
            

        ]);

        $reports = Report::create([
            'email' => $request->email,
            'period' => $request->period,
            

        ]);

        return back();
    }
    public function destroy($del, Request $request)
    {
        DB::table('reports')->where('id', $del)->delete();
        return back();
    }

    public function createPDF() {
        // retreive all records from db
        $calls =   DB::table('cdr')->take('10')->get();
        $rates =   DB::table('pricings')->take('10')->get();
  
        // share data to view
        
        $pdf = PDF::loadView("calls", compact('calls','rates'));
  
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }
}
