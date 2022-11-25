<?php

namespace App\Console\Commands;

use App\Models\Exchange;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class LoadExchangeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load exchange from Exchange API';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws GuzzleException|JsonException
     */
    public function handle(): int
    {
        $this->storeData('EUR/CHF');
        $this->storeData('EUR/USD');
        $this->storeData('USD/CHF');
        return CommandAlias::SUCCESS;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function storeData($symbol): void
    {
        $client = new Client();
        $response = $client->request('GET',config('constants.api.exchange.endpoint'),['query' => [
            'apikey' => config('constants.api.exchange.key'),
            'interval' => '4h',
            'symbol' => $symbol,
            'start_date' => Carbon::yesterday()->format('Y-m-d H:m:s'),
            'end_date' => Carbon::today()->format('Y-m-d H:m:s'),
            'format' => 'JSON',
            'timezone' => 'Europe/Rome'
        ]]);
        $this->createExchangeRecord($symbol,json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR));
    }

    private function createExchangeRecord($exchange,$data): void
    {
        foreach ($data['values'] as $record){
            if (!Exchange::where('symbol',$exchange)->where('datetime',$record['datetime'])->exists()){
                Exchange::create([
                    'value' => $record['close'],
                    'datetime' => $record['datetime'],
                    'symbol' => $exchange
                ]);
            }
        }
    }
}
