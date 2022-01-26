<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_record(){
        $pricing = Pricing::get();
        return $pricing;
    }
    public function index()
    {
        $pricing = Pricing::get();
        return view("pricing",  [
            'pricing' => Self::all_record()
           
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'sdn' => ['required','regex:/^[A-Za-z0-9\[\]\-]*$/'],
            'rate' => ['required','numeric'],
            'type' => ['required','numeric'],
            'grace' => ['required','numeric'],
            'minimal' => ['required','numeric'],
            'fraction' => ['required','numeric'],



        ]);
   

        $pricing = Pricing::create([
            'name' => $request->name,
            'sdn' => $request->sdn,
            'rate' => $request->rate,
            'type' => $request->type,
            'grace' => $request->grace,
            'minimal' => $request->minimal,
            'fraction' => $request->fraction,


        ]);
        if($pricing){
            toastr()->success('A new pricing has been added');
            return back();
        }
        else{
            toastr()->warning('Failed to add a new pricing');
            return back();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function show(Pricing $pricing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pricing $pricing)
    {
        //
    }

  
    public function destroy($del, Request $request)
    {
        $query = DB::table('pricings')->where('id', $del)->delete();
        if($query){
            toastr()->error('A Pricing has been delted');
            return back();
        }
        else{
            toastr()->warning('Failed to delete a  pricing');
            return back();
        }
    }
    public function edit_price($edit, Request $request)
    {
        $query = DB::table('pricings')->where('id', $edit)->count();
        if($query > 0)
        {
            $get = DB::table('pricings')->where('id', $edit)->get();
            return view("pricing", [
                'data' => $get,
                'pricing' => Self::all_record()
            ]);
        }
        else{
            toastr()->warning('Invalid ID');
            return redirect('pricing');
        }
        
    }
    public function edit($edit, Request $request){

        $this->validate($request, [
            'name' => ['required'],
            'sdn' => ['required'],
            'rate' => ['required'],
            'type' => ['required'],
            'grace' => ['required'],
            'minimal' => ['required'],
            'fraction' => ['required'],


        ]);
   

        $pricing = Pricing::where('id', '=' , $edit)->update([
            'name' => $request->name,
            'sdn' => $request->sdn,
            'rate' => $request->rate,
            'type' => $request->type,
            'grace' => $request->grace,
            'minimal' => $request->minimal,
            'fraction' => $request->fraction,


        ]);
        if($pricing){
            toastr()->info('Record has been updated');
            return back();
        }
        else{
            toastr()->warning('Failed to update');
            return back();
        }
      
    }
}
