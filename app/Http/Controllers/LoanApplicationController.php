<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanApplicationDetails;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Exception;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role==1){
            $loan_application = LoanApplication::get();
        }else{
            $loan_application = LoanApplication::where('customer_id',Auth::user()->id)->get();
        }

        return view('loan application.index',compact('user','loan_application'));
    }

    public function approve(Request $request,$application_id){
        try {
            $loanApplication = LoanApplication::find($application_id);
            $loanApplication->loan_status = '1';
            $loanApplication->status_updated_by = Auth::user()->id;
            if($loanApplication->save()){
               return back()->with('success','Application approved');
            }
        } catch (Exception $e) {
            return back()->with('error',"Something went wrong". $e->getMessage() . " Line No. " . $e->getLine() . " File:-" . $e->getFile());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('loan application.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'loan_type' => 'required',
                'loan_amount' => 'required',
                'loan_term' => 'required'
            ]);
            //create loan application
            $loanApplication = new LoanApplication();
            $loanApplication->loan_type = $request->loan_type;
            $loanApplication->loan_amount = $request->loan_amount;
            $loanApplication->loan_term = $request->loan_term;
            $loanApplication->status_updated_by = 0;
            $loanApplication->customer_id = Auth::user()->id;
            if($loanApplication->save()){
                //create loan application installment details
                $loan_ammount = round($loanApplication->loan_amount/$loanApplication->loan_term,2);
                $loan_installment = array();
                $installment = array();
                for($i=1;$i<=$loanApplication->loan_term;$i++){
                    $payment_duration = 7;
                    $pdates = $payment_duration * $i;
                    $payment_date =  date("Y-m-d", strtotime("+ ".$pdates." day"));
                    $loan_installment[$i]['payment_date'] = $payment_date;
                    $loan_installment[$i]['installment_amount'] = $loan_ammount;
                    $installment[] = $loan_ammount;
                }

                $installment_sum = array_sum($installment);
                if($installment_sum!=$loanApplication->loan_amount){
                    $diff_amount = $loanApplication->loan_amount - $installment_sum;
                    $diff_amount = round($diff_amount,2);
                    $key = array_key_last($loan_installment);
                    $last_value_of_installment = $loan_installment[$key]['installment_amount']+ $diff_amount;
                    $loan_installment[$key]['installment_amount'] = $last_value_of_installment;
                }

                if(count($loan_installment)>0){
                    foreach ($loan_installment as $ikey => $ivalue) {
                        $loanApplicationdetail = new LoanApplicationDetails();
                        $loanApplicationdetail->application_id  =  $loanApplication->id;
                        $loanApplicationdetail->installment_amount  =  $ivalue['installment_amount'];
                        $loanApplicationdetail->payment_date  =  $ivalue['payment_date'];
                        $loanApplicationdetail->save();
                    }
                }
                return back()->with('success','Application created Successfully');
            }else{
                return back()->with('error','Application not created');
            }
        } catch (Exception $e) {
            return back()->with('error',"Something went wrong". $e->getMessage() . " Line No. " . $e->getLine() . " File:-" . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $loan_application = LoanApplicationDetails::where('application_id',$id)->get();
        $lapp = LoanApplication::where('id',$id)->first();
        return view('loan application.show',compact('user','loan_application','lapp'));
    }

    public function pay(LoanApplication $loanApplication,$id)
    {
        $user = Auth::user();
        $lapp_detail = LoanApplicationDetails::where('id',$id)->first();

        $installment_id = Crypt::encryptString($id);
        return view('loan application.pay',compact('user','lapp_detail','installment_id'));
    }

    public function pay_installment(Request $request)
    {
        try {
            $request->validate([
                'installment_amount' => 'required',
            ]);

            $installment_id = Crypt::decryptString($request->installment_id);
            $loanApplication = LoanApplicationDetails::find($installment_id);
            if($loanApplication->installment_status=='1'){
                return back()->with('error','You have already paid this');
            }
            $loanApplication->installment_paid_amount = $request->installment_amount;
            $loanApplication->paid_by = Auth::user()->id;
            $loanApplication->installment_status = '1';
            $loanApplication->installment_paid_date = date('Y-m-d');
            if($loanApplication->save()){
                //check condition of paid amount
                //if paid amount is equal or greater than loan amount than pais all installment and change loan status paid
                $loan_paid_amount = LoanApplicationDetails::where('application_id',$loanApplication->application_id)->sum('installment_paid_amount');
                $loan_amount = LoanApplication::where('id',$loanApplication->application_id)->first()->loan_amount;
                if($loan_paid_amount>=$loan_amount){
                    LoanApplication::where('id',$loanApplication->application_id)->update(['loan_payment_status'=>'1','loan_paid_date'=>date('Y-m-d')]);
                    LoanApplicationDetails::where('application_id',$loanApplication->application_id)->where('installment_status','0')->update(['installment_status'=>'1','paid_by'=>Auth::user()->id,'installment_paid_date'=>date('Y-m-d')]);
                }
                //check condition of paid amount
                return back()->with('success','Payment done Successfully');
            }else{
                return back()->with('error','Payment not done');
            }
        } catch (Exception $e) {
            return back()->with('error',"Something went wrong". $e->getMessage() . " Line No. " . $e->getLine() . " File:-" . $e->getFile());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanApplication $loanApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanApplication $loanApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanApplication $loanApplication)
    {
        //
    }
}
