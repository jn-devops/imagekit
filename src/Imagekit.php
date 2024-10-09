<?php

namespace Homeful\Imagekit;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Storage;
class Imagekit {

public function uploadFile(Request $Request){
    dd($request);
    $imageUrl = $request->input('imageUrl'); // Make sure 'selfieUrl' is passed in the request
    $folderPath = $request->input('folderPath')?$request->input('folderPath'):config('defaultFolderPath');
    $authKey = base64_encode(config('apiKey') . ':' . $imageUrl);

    $formData = [
        [
            'name' => 'file',
            'contents' => fopen($imageUrl, 'r'),
        ],
        [
            'name' => 'fileName',
            'contents' => $request->input('fileName') . '.png',
        ],
        [
            'name' => 'folder',
            'contents' => $folderPath,
        ],
    ];

    try {
        $client = new Client();
        $response = $client->post('https://upload.imagekit.io/api/v1/files/upload', [
            'headers' => [
                'Authorization' => 'Basic ' . $authKey,
            ],
            'multipart' => $formData,
        ]);

        $responseData = json_decode($response->getBody(), true);
        return response()->json([
            'url' => $responseData['url'],
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error uploading file: ' . $e->getMessage(),
        ], 500);
    }
}

}
