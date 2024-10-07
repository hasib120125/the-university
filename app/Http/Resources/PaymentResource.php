<?php

namespace App\Http\Resources;

use App\Enumeration\PaymentType;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PaymentResource extends JsonResource
{
    public function status($status)
    {
        switch ($status) {
            case 1:
                return __('student/form.payment.approved');
            case 2:
                return __('student/form.payment.reject');
            default:
                return __('student/form.payment.pending');
        }
    }

    public function type($value)
    {
        switch ($value) {
            case PaymentType::$FULL_PAYMENT:
                return  __('student/form.payment.full_payment');
                break;

            case PaymentType::$PARTIAL_PAYMENT:
                return  __('student/form.payment.status_text.partial_payment');
                break;

            case PaymentType::$DUE_PAYMENT:
                return  __('student/form.payment.status_text.due_payment');
                break;
            
            default:
                return '';
                break;
        }
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'amount' => $this->amount,
            'student' => $this->whenLoaded('student', new StudentResource($this->student)),
            'note' => $this->note,
            'attachment' => $this->attachment ? Storage::url($this->attachment) : null,
            'status' => $this->status,
            'credit' => $this->credit,
            'type' => $this->type,
            'type_text' => $this->type($this->type),
            'status_text' => $this->status($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
