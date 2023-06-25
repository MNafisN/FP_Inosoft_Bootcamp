<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /** 
     * untuk mengambil semua list transaction
     */
    public function getAll() : Object
    {
        $transactions = $this->transaction->select('transaction_code')->get();
        return $transactions;
    }

    /**
     * untuk mengambil data transaction berdasarkan kode transaksi
     */
    public function getById(string $transactionCode) : ?Object
    {
        $transaction = $this->transaction->where('transaction_code', $transactionCode)->first();
        return $transaction;
    }
}