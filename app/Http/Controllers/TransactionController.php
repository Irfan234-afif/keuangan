<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\TransactionType;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        if (request()->length) {
            $transactions = $transaction->with(['users', 'balances', 'transaction_types'])->latest()->take(request()->length)->get();
            return TransactionResource::collection($transactions)->toArray(request());
        }
        $transactions = $transaction->with(['users', 'balances', 'transaction_types'])->latest()->get();
        return TransactionResource::collection($transactions)->toArray(request());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $request->validated();

        $lastBalanceAmount = Balance::latest()->first()->balance_amount;

        $transaction_type = TransactionType::where('type', $request->transaction_type)->first();

        $addBalanceAmount = $request->transaction_type === 'income' ? $lastBalanceAmount + $request->amount : $lastBalanceAmount - $request->amount;

        $balance = Balance::create(
            [
                'balance_amount' => $addBalanceAmount,
            ],
        );

        $user = auth()->user()->transactions()->create(
            [
                'amount' => $request->amount,
                'balance_id' => $balance->id,
                'transaction_type_id' => $transaction_type->id,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,

            ]
        );

        return response($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}