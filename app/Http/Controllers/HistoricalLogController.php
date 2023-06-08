<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricalData;

class HistoricalLogController extends Controller
{
    public function index()
    {
        // Retrieve historical data from the database
        // Example:
        $historicalData = HistoricalData::all();
        
        return view('history', compact('historicalData'));
    }
}
