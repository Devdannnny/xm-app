<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    //
    public function getSymbols()
    {
        // $response = Http::get('http://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
        $symbols = $response->json();
        // $symbols = array_column($symbols, 'Symbol');
        // $companyName = array_column($symbols, 'Symbol');
        return view("home.index", ['symbols' => $symbols]);
    }
}