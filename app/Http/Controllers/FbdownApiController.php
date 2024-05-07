<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FbdownApiController extends Controller
{
    // Fetching data from the Facebook API
    public function fetchFacebookData(Request $request)
    {
        // Get the Facebook video URL from the request body
        $fbUrl = $request->input('url');

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Make a POST request to the external API
            $response = $client->post('https://fbdown.online/wp-json/aio-dl/video-data/', [
                'form_params' => [
                    'url' => $fbUrl
                ]
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Check if response data is valid
            if (!empty($responseData)) {
                // Process the response data as needed
                return response()->json($responseData);
            } else {
                // Handle empty response
                return response()->json(['error' => 'Empty response from external API'], 500);
            }
        } catch (\Exception $e) {
            // Handle Guzzle or server-side errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchVideoData(Request $request)
    {
        // Get the video URL from the request body
        $videoUrl = $request->input('url');

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Make a POST request to the external API
            $response = $client->post('https://anydownloader.com/wp-json/aio-dl/video-data/', [
                'form_params' => [
                    'url' => $videoUrl
                ]
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Check if response data is valid
            if (!empty($responseData)) {
                // Process the response data as needed
                return response()->json($responseData);
            } else {
                // Handle empty response
                return response()->json(['error' => 'Empty response from external API'], 500);
            }
        } catch (\Exception $e) {
            // Handle Guzzle or server-side errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    
}
