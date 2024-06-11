<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function shorten(StoreUrlRequest $request)
    {
        $url = $request->input('url');

        // Check if URL is safe using Google Safe Browsing API
        if (!$this->isUrlSafe($url)) {
            return response()->json(['error' => 'Unsafe URL']);
        }

        $existingUrl = Url::where('original_url', $url)->first();

        if ($existingUrl) {
            return response()->json(['short_url' => $existingUrl->short_url]);
        }

        // Generate unique short URL
        $hash = Str::random(6);
        $shortUrl = url('/') . '/' . $hash;

        // Save the new URL to the database
        $newUrl = Url::create([
            'original_url' => $url,
            'short_url' => $shortUrl,
        ]);

        return response()->json(['short_url' => $newUrl->short_url]);
    }

    private function isUrlSafe($url)
    {
        $client = new Client();
        $apiKey = 'AIzaSyCZwCz6thY61Vxhw7UAxxa_e75KKn07rZQ';
        $apiUrl = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;

        $body = [
            'client' => [
                'clientId' => 'yourcompanyname',
                'clientVersion' => '1.5.2',
            ],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                    ['url' => $url],
                ],
            ],
        ];

        $response = $client->post($apiUrl, [
            'json' => $body,
            'headers' => [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ],
            'verify' => false, // disable SSL
        ]);

        $data = json_decode($response->getBody(), true);

        return empty($data['matches']);
    }

    public function redirect($hash)
    {
        $url = Url::where('short_url', url('/') . '/' . $hash)->first();

        if ($url) {
            return redirect($url->original_url);
        } else {
            return response()->json(['error' => 'URL not found'], 404);
        }
    }

}
