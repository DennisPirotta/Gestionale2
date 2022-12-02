<?php

namespace App\Models;

use Eloquent;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Exchange
 *
 * @property int $id
 * @property string $datetime
 * @property string $exchange
 * @property float $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Exchange newModelQuery()
 * @method static Builder|Exchange newQuery()
 * @method static Builder|Exchange query()
 * @method static Builder|Exchange whereCreatedAt($value)
 * @method static Builder|Exchange whereDatetime($value)
 * @method static Builder|Exchange whereExchange($value)
 * @method static Builder|Exchange whereId($value)
 * @method static Builder|Exchange whereUpdatedAt($value)
 * @method static Builder|Exchange whereValue($value)
 * @mixin Eloquent
 *
 * @method static \Database\Factories\ExchangeFactory factory(...$parameters)
 */
class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'value', 'datetime',
    ];

    public static function getDataForChart(): array
    {
        $data = [];
        foreach (self::all() as $exchange) {
            $data[] = [
                'x' => $exchange->datetime,
                'y' => $exchange->value,
            ];
        }

        return $data;
    }

    public static function uploadLastYearData(): void
    {
        try {
            $client = new Client();
            $response = $client->request('GET', config('constants.api.exchange.endpoint'), ['query' => [
                'apikey' => config('constants.api.exchange.key'),
                'interval' => '4h',
                'symbol' => 'EUR/CHF',
                'start_date' => Carbon::today()->subYear()->format('Y-m-d H:m:s'),
                'end_date' => Carbon::today()->format('Y-m-d H:m:s'),
                'format' => 'JSON',
                'timezone' => 'Europe/Rome',
            ]]);
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($data['values'] as $record) {
                self::create([
                    'value' => $record['close'],
                    'datetime' => $record['datetime'],
                ]);
            }
        } catch (Exception|GuzzleException) {
        }
    }
}
