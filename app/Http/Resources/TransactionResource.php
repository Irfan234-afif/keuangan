<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'user_name' => $this->users->name,
            'balance_amount' => $this->balances->balance_amount,
            'transaction_type' => $this->transaction_types->type,
            'transaction_date' => $this->transaction_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toResponse($request)
    {
        return $this->resource;
    }
}