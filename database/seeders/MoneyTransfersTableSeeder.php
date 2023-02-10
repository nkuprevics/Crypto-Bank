<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MoneyTransfersTableSeeder extends Seeder
{
    public function run()
    {
        $currencies = ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'CHF', 'JPY', 'MXN'];

        $numFrom = $this->command->ask('Enter the account number to seed:', '1234567890');
        $amount = $this->command->ask('How many entries you want to seed:', '20');

        for ($i = 1; $i <= $amount; $i++) {
            DB::table('money_transfers')->insert([
                'num_from' => $numFrom,
                'num_to' => rand(100000000, 999999999),
                'name_to' => $this->generateName(),
                'lname_to' => $this->generateLastName(),
                'amount' => rand(100, 1000),
                'currency_from' => $currencies[array_rand($currencies)],
                'currency_to' => $currencies[array_rand($currencies)],
                'comment' => 'feeder comment',
                'date' => Carbon::now()->subYear()->subDays(rand(0, 365))
            ]);
        }
    }

    private function generateName()
    {
        $names = [
            'John', 'Jane', 'Bob', 'Alice', 'Tom', 'Linda', 'Mike', 'Emily', 'Edward', 'Sophie',
            'James', 'Emily', 'David', 'Olivia', 'Robert', 'Ava', 'Michael', 'Isabella', 'William', 'Mia',
        ];

        return $names[array_rand($names)];
    }

    private function generateLastName()
    {
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor',
            'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Moore', 'Young', 'Allen',
        ];

        return $lastNames[array_rand($lastNames)];
    }
}
