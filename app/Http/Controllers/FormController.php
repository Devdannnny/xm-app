<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    public function submitFrm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'symbol'          => 'required',
            'startDate'       => 'required',
            'endDate'       => 'required',
            'email'       => 'required',
        ]);

        if ($validator->fails()) {
            // Return a response
            return response()->json(['message' => 'Some fields are empty', 'error' => true, 'data' => []]);
        } else {
            // Return a response

            $response = Http::withHeaders([
                "X-RapidAPI-Key" => "46089cd813mshe2b77559ff59ff4p1d9170jsn312ba580c1d2",
                "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com"
            ])->withOptions([
                "verify" => false
            ])->get("https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data", [
                "symbol" => $request->symbol,
                // "region" => "US"
            ]);

            $data = $response->json()["prices"];

            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $data = array_reduce($data, function ($carry, $item) use ($startDate, $endDate) {
                $date = $item['date'];
                $start = strtotime($startDate);
                $end = strtotime($endDate);
                if ($date >= $start && $date <= $end) {
                    $carry[] = $item;
                }
                return $carry;
            }, []);

            foreach ($data as &$row) {
                $row["date"] = date("Y-m-d", $row["date"]);
            }
            return response()->json(['message' => 'Form submitted successfully', 'error' => false, 'data' => $data]);
        }
    }

    public function getStockData(Request $request)
    {
        try {
            // code to fetch data
            $response = Http::withHeaders([
                "X-RapidAPI-Key" => "46089cd813mshe2b77559ff59ff4p1d9170jsn312ba580c1d2",
                "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com"
            ])->withOptions([
                "verify" => false
            ])->get("https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data", [
                "symbol" => $request->symbolSelected,
                // "region" => "US"
            ]);

            $data = $response->json()["prices"];

            if (is_array($data) && sizeof($data) > 0) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $data = array_reduce($data, function ($carry, $item) use ($startDate, $endDate) {
                    $date = $item['date'];
                    $start = strtotime($startDate);
                    $end = strtotime($endDate);
                    if ($date >= $start && $date <= $end) {
                        $carry[] = $item;
                    }
                    return $carry;
                }, []);
                foreach ($data as &$row) {
                    $row["date"] = date("Y-m-d", $row["date"]);
                }
                return response()->json($data);
            } else {
                return response()->json($data);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
