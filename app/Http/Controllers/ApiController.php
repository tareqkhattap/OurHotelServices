<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function topObject($hotel)
    {

        // Convert Strings to Arrays
        $response = new \stdClass();
        $response->provider = strval($hotel['TopHotels']);
        $response->hotelName = strval($hotel['hotelName']);
        $response->fare = floatval($hotel['price']);
        $response->amenities = $hotel['amenities'];
        $response->rate = floatval($hotel['rate']);

        return $response;

    }

    public function bestObject($hotel)
    {
        // Convert Strings to Arrays
        $amenities_ar = explode(', ', $hotel['roomAmenities']);
        $response = new \stdClass();
        $response->provider = strval($hotel['BestHotels']);
        $response->hotelName = strval($hotel['hotel']);
        $response->fare = floatval($hotel['hotelFare']);
        $response->amenities =  $amenities_ar;
        $response->rate = floatval($hotel['hotelRate']);

        return $response;

    }
}
