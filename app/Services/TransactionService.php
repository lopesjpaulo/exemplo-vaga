<?php

namespace App\Services;


use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    /**
     * Guid for transaction
     */
    private $guid;

    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(
        Transaction $transaction
    )
    {
        $this->guid = Str::uuid()->toString();

        $this->transaction = $transaction;
    }

    /**
     * Validate the request for a transaction
     * 
     * @param \Illuminate\Http\Request $request
     */
    private function validateRequest(Request $request): void
    {
        $rules = [
            'amount'                => 'required|numeric'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            throw new ValidationException($validator);
    }

    /**
     * Save the transaction object on mysql
     * 
     * @param \Illuminate\Http\Request $request
     * @return int
     */
    public function createTransaction(Request $request): int
    {
        $this->validateRequest($request);

        $requestData = $request->all();

        $response = $this->transaction::create(
            [
                "guid" => $this->guid,
                "amount" => $requestData['amount']
            ]
        );

        return $response->transaction_id;
    }
}
