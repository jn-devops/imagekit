<?php

namespace Homeful\Imagekit;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Imagekit
{
    public function uploadFile(Request $Request)
    {
        $imageUrl = $Request->input('imageUrl');
        $folderPath = $Request->input('folderPath') ? $Request->input('folderPath') : config('imagekit')['apiKey'];
        $authKey = base64_encode(config('imagekit')['apiKey'].':'.$imageUrl);

        $formData = [
            [
                'name' => 'file',
                'contents' => fopen($imageUrl, 'r'),
            ],
            [
                'name' => 'fileName',
                'contents' => $Request->input('fileName').'.png',
            ],
            [
                'name' => 'folder',
                'contents' => $folderPath,
            ],
        ];

        try {
            $client = new Client;
            $response = $client->post('https://upload.imagekit.io/api/v1/files/upload', [
                'headers' => [
                    'Authorization' => 'Basic '.$authKey,
                ],
                'multipart' => $formData,
            ]);

            return $response->getBody();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error uploading file: '.$e->getMessage(),
            ], 500);
        }
    }

    public function uploadFilev2(array $jsonInput)
    {
        $imageUrl = $jsonInput['imageUrl'];
        $folderPath = isset($jsonInput['folderPath']) ? $jsonInput['folderPath'] : config('imagekit')['apiKey'];
        $authKey = base64_encode(config('imagekit')['apiKey'].':'.$imageUrl);

        $formData = [
            [
                'name' => 'file',
                'contents' => fopen($imageUrl, 'r'),
            ],
            [
                'name' => 'fileName',
                'contents' => $jsonInput['fileName'].'.png',
            ],
            [
                'name' => 'folder',
                'contents' => $folderPath,
            ],
        ];

        try {
            $client = new Client;
            $response = $client->post('https://upload.imagekit.io/api/v1/files/upload', [
                'headers' => [
                    'Authorization' => 'Basic '.$authKey,
                ],
                'multipart' => $formData,
            ]);

            return $response->getBody();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error uploading file: '.$e->getMessage(),
            ], 500);
        }
    }
}
