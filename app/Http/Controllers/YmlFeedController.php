<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class YmlFeedController extends Controller {
    public function show() {
        $path = storage_path('app/public/yml-feed.xml');

        // Если файла нет или он старше 1 часа Format: Braces- генерируем новый
        if (!File::exists($path) || (time() - File::lastModified($path)) > 3600) {
            Artisan::call('generate:ymlfeed');
        }

        return response()->file($path, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function showPage() {
        $path = storage_path('app/public/yml-feed.xml');

        if (!File::exists($path)) {
            Artisan::call('generate:ymlfeed');
        }

        $xmlContent = File::get($path);
        $xml = simplexml_load_string($xmlContent);

        return view('yml-feed.show', [
            'feed' => $xml,
            'lastUpdated' => File::lastModified($path)
        ]);
    }
}
