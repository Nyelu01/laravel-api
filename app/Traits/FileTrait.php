<?php

namespace App\Traits;

use Exception;
use finfo;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    function storeBase64Image($base64String, $storagePath)
    {
        try {
            // Decode the base64 string to binary data
            $binaryData = base64_decode($base64String);

            // Generate a unique file name with the original extension
            $extension = $this->getImageExtension($base64String); // You need a separate function to get the extension
            $fileName = uniqid('img_') . '.' . $extension;

            // Create the full path within the storage directory
            $filePath = $storagePath . '/' . $fileName;

            // Store the file in Laravel's storage
            Storage::disk('public')->put($filePath, $binaryData);

            // Return the path with the generated image name
            return $filePath;
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "Something went wrong in FileTrait.storeBase64Image"
            ], 500);
        }
    }

    // Helper function to get image extension from base64 string
    function getImageExtension($base64String)
    {
        $data = explode(',', $base64String);
        $mime = explode(';', $data[0]);

        switch ($mime[0]) {
            case 'data:image/jpeg':
                return 'jpg';
            case 'data:image/png':
                return 'png';
            case 'data:image/gif':
                return 'gif';
            // Add more cases as needed for other supported formats
            default:
                return 'png'; // Default to PNG if the format is not recognized
        }
    }

    public function checkIfFileExist($storagePath)
    {
        return Storage::disk('public')->exists($storagePath);
    }

    public function deleteFileFromStorage($storagePath)
    {
        if ($this->checkIfFileExist($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }
}