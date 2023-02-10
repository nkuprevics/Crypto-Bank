<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_from',
        'num_to',
        'name_from',
        'lname_from',
        'name_to',
        'lname_to',
        'amount_from',
        'amount_to',
        'currency_from',
        'currency_to',
        'comment',
    ];

    public static function register(array $attributes): bool
    {
        $transaction = static::create(array_merge(request()->all(), $attributes));

        return $transaction->exists;
    }

    public static function filterTransactions(string $start_date, string $end_date, string $account): Collection
    {
        $end_date = Carbon::parse($end_date)->addDays(1)->format('Y-m-d');

        $history = Transaction::where(function ($query) use ($account) {
            $query->where('num_from', $account)
                ->orWhere('num_to', $account);
        })
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'desc')
            ->get();

        return $history;
    }
}
