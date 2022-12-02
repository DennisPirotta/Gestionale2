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
    protected $signature = 'exchange:load {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load exchange from Exchange API';

    /**
     * Execute the console command.
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(): int
    {
        if ($this->option('all')) {
            $start_date = Carbon::now()->firstOfYear();
        } else {
            $start_date = Carbon::yesterday();
        }
        $end_date = Carbon::today();
        $client = new Client();
        $response = $client->request('GET', config('constants.api.exchange.endpoint'), ['query' => [
            'apikey' => config('constants.api.exchange.key'),
            'interval' => '4h',
            'symbol' => 'EUR/CHF',
            'start_date' => $start_date->format('Y-m-d H:m:s'),
            'end_date' => $end_date->format('Y-m-d H:m:s'),
            'format' => 'JSON',
            'timezone' => 'Europe/Rome',
        ]]);
        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        foreach ($data['values'] as $record) {
            if (! Exchange::where('value', $record['close'])->where('datetime', $record['datetime'])->exists()) {
                Exchange::create(['value' => $record['close'], 'datetime' => $record['datetime']]);
            }
        }

        return CommandAlias::SUCCESS;
    }
}
