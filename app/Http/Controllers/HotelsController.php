<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class HotelsController extends ApiController
{
                                  // Our Hotel Function
    public function ourHotels(Request $request)
    {
        $response = [];
        $statusCode = 200;
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required_if:from_date|date',
            'city' => 'required|string',
            'adults_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 200;
            $response["status"] = -1;
            $response['message'] = $validator->errors()->all();
        } else {
            $response['status'] = 1;
            $response['message'] = "data retrieved";
            $data = [
                'from_date' => $request->input('from_date'),
                'to_date' => $request->input('to_date'),
                'city' => $request->input('city'),
                'adults_number' => $request->input('adults_ number'),

            ];
                                        // array of TopHotels
            $top_data = [
                'from' => $data['from_date'],
                'to' => $data['to_date'],
                'city' => $data['city'],
                'adults_ number' => $data['adults_number'],

            ];

                                   // array of BestHotels

            $best_data = [
                'fromDate' => $data['from_date'],
                'toDate' => $data['to_date'],
                'city' => $data['city'],
                'adultsCount' => $data['adults_number'],

            ];

            $top_hotels = $this->tophotels($top_data);
            if ($top_hotels) {
                foreach ($top_hotels as $hotel) {
                    $hotels[] = $this->topObject($hotel);
                }
            }

            $best_hotels = $this->besthotels($best_data);
            if ($best_hotels) {
                foreach ($best_hotels as $hotel) {
                    $hotels[] = $this->bestObject($hotel);
                }
            }
                         //hotels ordered by hotel rate
            usort($hotels, function ($a, $b) {
                $response['hotels'] = $a['rate'] < $b['rate'];
            });
        }

        return response()->json($response, $statusCode);
    }

    public function besthotels($best_data = [])
    {

                                // create a new cURL resource
        $curl = curl_init();

                           // set URL and other appropriate options

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://example.com",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($best_data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response);

    }

    public function tophotels($top_data = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://example.com",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($top_data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response);

    }


}
