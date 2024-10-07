<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditTransactionResource;
use App\Http\Resources\PaymentResource;
use App\Models\CreditTransaction;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pending()
    {
        return PaymentResource::collection(executeQuery(Payment::query()->where('status', 0)->with('student')));
    }

    public function approved()
    {
        return CreditTransactionResource::collection(executeQuery(CreditTransaction::query()->with('student', 'payment')));
    }

    public function approve(Payment $payment)
    {
        $student = Student::with('duePayments')->where('id', $payment->student_id)->first();
        
        $setting = Setting::first();
        
        $transaction = new CreditTransaction();
        $transaction->payment_id = $payment->id;
        $transaction->student_id = $payment->student_id;
        $transaction->type = $payment->type;
        $transaction->credit = $payment->type == 1 ? $payment->amount / $setting->credit_rate 
                                : ($payment->type == 2 ? $student->duePayments[0]->pivot->credit : 0);
        $transaction->per_credit_rate = $setting->credit_rate;
        $transaction->save();

        switch ($payment->type) {
            case 1:
                $student->increment('available_credit', $transaction->credit);
                break;
            case 2:
                $student->available_credit = $student->available_credit + $transaction->credit; 
                $student->due_payments = $student->due_payments + $student->duePayments[0]->pivot->due_payments; 
                $student->save();
                $student->duePayments()->detach($payment->id);
                break;

            case 3:
                $student->decrement('due_payments', $payment->amount );
                break;
            
            default:
                # code...
                break;
        }

        $payment->status = 1;
        $payment->save();
    }
}
