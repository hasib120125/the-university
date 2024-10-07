<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditTransactionResource extends JsonResource
{
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
            'payment' => $this->whenLoaded('payment', new PaymentResource($this->payment)),
            'student' => $this->whenLoaded('student', new StudentResource($this->student)),
            'credit' => $this->credit,
            'per_credit_rate' => $this->per_credit_rate,
            'type' => $this->type,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
