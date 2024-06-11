<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;
class UrlShortenerService
{
    public function shortenUrl($url)
    {
        // Check if the URL already exists in the database
        $existingUrl = Url::where('original_url', $url)->first();

        if ($existingUrl) {
            return $existingUrl->short_url;
        }

        // Generate unique short URL
        $hash = Str::random(6);
        $shortUrl = url('/') . '/' . $hash;

        // Save the new URL to the database
        $newUrl = Url::create([
            'original_url' => $url,
            'short_url' => $shortUrl,
        ]);

        return $newUrl->short_url;
    }
}
