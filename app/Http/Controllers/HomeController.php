<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\HistoricalData;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch humidity data from the API
        $humidityData = $this->fetchHumidityData();
        
        // Store the humidity data in the historical log
        foreach ($humidityData as $city => $humidity) {
            HistoricalData::create([
                'date' => now()->toDateString(),
                'city' => $city,
                'humidity' => $humidity,
            ]);
        }

        // Retrieve the historical log for display
        $historicalData = HistoricalData::latest()->get();

        return view('home', compact('humidityData', 'historicalData'));
    }

    private function fetchHumidityData()
    {
        $apiKey = '0313e0041e884a568140c9e79d6f3195'; // Replace with your actual Weatherbit API key
        $cities = ['Miami', 'Orlando', 'New York'];
        $humidityData = [];
    
        foreach ($cities as $city) {
            $url = "https://api.weatherbit.io/v2.0/current?key=$apiKey&city=$city";
            $client = new Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['data'][0])) {
                $humidity = $data['data'][0]['rh'];
                $humidityData[$city] = $humidity;
            }
        }
    
        return $humidityData;
    }
    
}
