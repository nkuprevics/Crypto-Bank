<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $table = 'crypto_transactions';

    protected $fillable = [
        'bank_account',
        'name',
        'symbol',
        'amount',
        'price',
    ];


    public static function register(array $attributes): bool
    {

        $transaction = static::create(array_merge(request()->all(), $attributes));

        return $transaction->exists;
    }

    public static function getHistoryByAccount(string|null $from): Collection
    {
        $history = CryptoTransaction::where('bank_account', $from)
            ->orWhere('bank_account', $from)
            ->orderBy('created_at', 'desc')
            ->get();

        return $history;
    }

    public static function filterTransactions(string $start_date, string $end_date, string $account): Collection
    {
        $end_date = Carbon::parse($end_date)->addDays(1)->format('Y-m-d');

        $history = CryptoTransaction::where(function ($query) use ($account) {
            $query->where('bank_account', $account);})
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'desc')
            ->get();

        return $history;

    }
}
