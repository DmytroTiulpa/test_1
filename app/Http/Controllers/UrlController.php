<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use App\Models\Url;
use Illuminate\Support\Str;
use App\Services\UrlShortenerService;

class UrlController extends Controller
{
    protected $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function index()
    {
        return view('index');
    }

    public function shorten(StoreUrlRequest $request): JsonResponse
    {
        $url = $request->input('url');

        // Проверка на безопасность URL через Google Safe Browsing API
        if (!$this->isUrlSafe($url)) {
            return response()->json(['error' => 'Unsafe URL'], 400);
        }

        // Сокращение URL с помощью сервиса
        $shortUrl = $this->urlShortenerService->shortenUrl($url);

        return response()->json(['short_url' => $shortUrl]);
    }

    private function isUrlSafe($url): bool
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

        try {
            $response = $client->post($apiUrl, [
                'json' => $body,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                ],
                'verify' => false, // disable SSL verification
            ]);

            $data = json_decode($response->getBody(), true);

            return empty($data['matches']);
        } catch (\Exception $e) {
            //TODO Log the error or return the default value
            return false;
        }

    }

    public function redirect($hash)
    {
        $url = Url::where('short_url', $hash)->first();

        if ($url) {
            return redirect($url->original_url);
        } else {
            return response()->json(['error' => 'URL not found'], 404);
        }
    }

}
