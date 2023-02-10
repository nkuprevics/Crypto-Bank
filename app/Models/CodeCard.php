<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeCard extends Model
{
    use HasFactory;

    protected $table = 'code_cards';

    protected $fillable = [
        'belongs_to',
        '1',
        '2',
        '3',
        '4',
    ];

    public static function create(string $belongs_to): bool
    {
        $newCard = (new CodeCard())->fill([
            'belongs_to' => $belongs_to,
            '1' => rand(1000, 9999),
            '2' => rand(1000, 9999),
            '3' => rand(1000, 9999),
            '4' => rand(1000, 9999),
        ]);

        return $newCard->save();
    }
}
