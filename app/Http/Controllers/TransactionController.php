<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Creates a payment
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = $this->transactionService->createTransaction($request);

        return response()->json(['created' => true, 'id' => $response]);
    }
}
