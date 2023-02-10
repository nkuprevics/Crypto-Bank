<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoinMarketCap;

class CryptoInventory extends Model
{
    protected $table = 'crypto_inventories';

    protected $fillable = [
        'id',
        'owner_bank_account',
        'inventory',
    ];

    private function initializeAPI(): CoinMarketCap\Api
    {
        $coinmarketcap = new CoinMarketCap\Api($_ENV['COIN_MARKET_CAP_API']);
        return $coinmarketcap;
    }

    public static function getCryptoCollection(int $limit): object
    {
        $coinmarketcap = (new CryptoInventory())->initializeAPI();
        $result = $coinmarketcap->cryptocurrency()->listingsLatest(['limit' => $limit, 'convert' => 'EUR']);

        foreach ($result->data as $crypto) {
            $crypto->logo = (new CryptoInventory())::getLogo($coinmarketcap, $crypto->symbol);
        }
        return $result;
    }

    private static function getLogo(CoinMarketCap\Api $API, string $symbol)
    {
        $logoPath = '../../logosCache/' . $symbol . '.png';
        $logoCheck = '../public/logosCache/' . $symbol . '.png';

        if (!file_exists($logoCheck)) {
            $logoUrl = $API->cryptocurrency()->info(['symbol' => $symbol])->data->{$symbol}->logo;
            $logoUrl = str_replace("64x64", "128x128", $logoUrl);
            $logoData = file_get_contents($logoUrl);

            file_put_contents($logoCheck, $logoData);
        }

        return $logoPath;
    }

    public static function storeTransaction(string $bankAccount, string $symbol, float $amount):void
    {
        $inventory = CryptoInventory::where('owner_bank_account', $bankAccount)->first();

        if ($inventory) {
            // Update existing inventory
            $symbols = json_decode($inventory->inventory, true);
            if (isset($symbols[$symbol])) {
                $symbols[$symbol] += $amount;
            } else {
                $symbols[$symbol] = $amount;
            }
            $inventory->inventory = json_encode($symbols);
            $inventory->save();
        } else {
            // Create new inventory
            $inventory = new CryptoInventory;
            $inventory->owner_bank_account = $bankAccount;
            $inventory->inventory = json_encode([$symbol => $amount]);
            $inventory->save();
        }
    }

    public static function getInventory(string|null $bankAccount): array
    {
        $inventory = CryptoInventory::where('owner_bank_account', $bankAccount)->first();

        if ($inventory) {
            return json_decode($inventory->inventory, true);
        } else {
            return [];
        }
    }
}
