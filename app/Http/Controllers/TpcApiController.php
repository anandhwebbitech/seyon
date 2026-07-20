<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TpcApiController extends Controller
{
    protected Client $client;
    protected string $baseUrl;
    protected string $clientId;
    protected string $password;

    public function __construct()
    {
        $this->client   = new Client(['timeout' => 30]);
        $this->baseUrl  = 'https://www.tpcglobe.com';
        $this->clientId = config('services.tpc.client');
        $this->password = config('services.tpc.password');
    }

    public function checkPincode(string $pincode)
    {
        $response = Http::get('https://www.tpcglobe.com/TPCWebService/tracktracejson.ashx', [
            'podno'  => "MAA123456",
            'client' => $this->clientId,
            'tpcpwd' => $this->password,
        ]);
        $data = $response->json();
dd(collect($data)->toArray());
        $url = "{$this->baseUrl}/tpcwebservice/PINcodeService.ashx?pincode={$pincode}";
        return $this->client->get($url)->getBody()->getContents();
    }

    public function searchArea(string $area)
    {
        $url = "{$this->baseUrl}/TPCWebservice/PINcodeCitysearch.ashx?AreaName={$area}";
        return $this->client->post($url)->getBody()->getContents();
    }

    public function cnoteStock()
    {
        $url = "{$this->baseUrl}/tpcwebservice/ClientCnoteStock.ashx";
        return $this->client->get($url, [
            'query' => [
                'client' => $this->clientId,
                'tpcpwd' => $this->password
            ]
        ])->getBody()->getContents();
    }

    public function requestCnote(int $qty = 100)
    {
        $url = "{$this->baseUrl}/TPCWebService/CnoteRequest.ashx";
        return $this->client->get($url, [
            'query' => [
                'client' => $this->clientId,
                'tpcpwd' => $this->password,
                'Qty'    => $qty
            ]
        ])->getBody()->getContents();
    }

    public function pickupRequest(array $payload)
    {
        $url = "{$this->baseUrl}/TPCWebService/PickupRequest.ashx";

        return $this->client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'query'   => [
                'client' => $this->clientId,
                'tpcpwd' => $this->password
            ],
            'json' => $payload
        ])->getBody()->getContents();
    }

    public function cancelCnote(string $podNo)
    {
        $url = "{$this->baseUrl}/TPCWebService/CancelCnoteBKG.ashx";
        return $this->client->get($url, [
            'query' => [
                'client' => $this->clientId,
                'tpcpwd' => $this->password,
                'podno'  => $podNo
            ]
        ])->getBody()->getContents();
    }

    public function modifyShipment(array $payload)
    {
        $url = "{$this->baseUrl}/tpCWebService/PickupAddon.ashx";

        return $this->client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'query' => [
                'client' => $this->clientId,
                'tpcpwd' => $this->password
            ],
            'json' => $payload
        ])->getBody()->getContents();
    }

    public function track(string $podNo)
    {
        $url = "{$this->baseUrl}/TPCWebService/tracktracejson.ashx";
        return $this->client->get($url, [
            'query' => [
                'podno'  => $podNo,
                'client' => $this->clientId,
                'tpcpwd' => $this->password
            ]
        ])->getBody()->getContents();
    }

    public function trackEnhanced(string $podNo)
    {
        $url = "{$this->baseUrl}/TPCWebService/tracktracejsonnew.ashx";
        return $this->client->get($url, [
            'query' => [
                'podno'  => $podNo,
                'client' => $this->clientId,
                'tpcpwd' => $this->password
            ]
        ])->getBody()->getContents();
    }

    public function printCnote(string $podNo)
    {
        return redirect(
            "{$this->baseUrl}/TPCWebService/CnotePrinting.aspx?" .
            http_build_query([
                'client' => $this->clientId,
                'tpcpwd' => $this->password,
                'podno'  => $podNo
            ])
        );
    }

    public function printSingle(string $podNo)
    {
        return redirect(
            "{$this->baseUrl}/TPCWebService/CnotePrintingsingle.aspx?" .
            http_build_query([
                'client' => $this->clientId,
                'tpcpwd' => $this->password,
                'podno'  => $podNo
            ])
        );
    }

    public function webhook(Request $request)
    {
        // Log or store webhook data
        Log::info('TPC Webhook', $request->all());

        return response()->json([
            'status' => 'success',
            'error'  => 0
        ]);
    }
}
