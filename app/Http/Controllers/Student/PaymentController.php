<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SettingResource;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        return PaymentResource::collection(Auth::guard('student')->user()->payments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'type' => 'required|numeric|min:1|between:1,3',
            'credit' => 'required_if:type,2|numeric',
        ]);

        $payment = Payment::create([
            'payment_id' => 'ICS'.random_int(100000, 999999),
            'amount' => $request->amount,
            'note' => $request->note,
            'type' => $request->type,
            'student_id' => Auth::user()->id,
            'attachment' => $request->file('attachment') ? $request->file('attachment')->store('payments') : null,
        ]);

        if($request->type == 2){
            $setting = Setting::first();
            $needToPay = $setting->credit_rate * $request->credit;
            $duePayments = $needToPay - $request->amount;
            $payment->dueStudents()->attach($payment->id, [
                'credit' => $request->credit,
                'student_id' => Auth::user()->id, 
                'due_payments'=> $duePayments
            ]);
        }

        return new PaymentResource($payment);
    }

    public function show(Payment $payment)
    {
        //
    }

    public function update(Request $request, Payment $payment)
    {
        //
    }

    public function destroy(Payment $payment)
    {
        //
    }

    public function creditCost()
    {
        return new SettingResource(Setting::first());
    }
}
