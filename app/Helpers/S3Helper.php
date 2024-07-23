<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use GuzzleHttp\Psr7\Uri;

class S3Helper
{
    /**
     * Upload an image file to the specified S3 bucket.
     *
     * @param UploadedFile $file The image file to be uploaded.
     * @param string $path The path within the bucket where the file will be stored.
     * @param string $visibility The visibility of the uploaded file (public or private).
     * @return string|false The URL of the uploaded file on success, or false on failure.
     */

    public function uploadImageToS3(UploadedFile $file, $path = 'images/', $visibility = 'public-read')
    {
        // Generate a unique file name
        $fileName = $path.time() . '.' . $file->getClientOriginalExtension();

        // Set the S3 bucket name
        $bucket = env('AWS_BUCKET');

        // Create an instance of the S3 client
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            // Upload the file to the S3 bucket
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $fileName,
                'Body' => fopen($file, 'rb'),
                'ACL' => $visibility, // Set the desired ACL for the uploaded file
            ]);

            $imageUrl = $fileName;

            return $imageUrl;
        } catch (AwsException $e) {
            // Handle the exception if the upload fails
            return false;
        }
    }

    public function getListImageOfS3()
    {
        // Create an instance of the S3 client
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            // Get the list of objects in the S3 bucket
            $result = $s3Client->listObjects([
                'Bucket' => env('AWS_BUCKET'),
            ]);

            // Extract the object keys from the result
            $objectKeys = [];
            foreach ($result['Contents'] as $object) {
                $objectKeys[] = $object['Key'];
            }

            return $objectKeys;
        } catch (AwsException $e) {
            // Handle the exception if listing objects fails
            return response()->json(['message' => 'Failed to retrieve object list'], 500);
        }
    }

    public function removeImageToS3($imageKey)
    {
        $imageKey = $imageKey; // Adjust the image key with the appropriate folder name

        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            $s3Client->deleteObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $imageKey,
            ]);

            // Return a success response
            return response()->json(['message' => 'Image removed successfully']);
        } catch (AwsException $e) {
            dd($e);
            // Handle the exception if the image removal fails
            return response()->json(['message' => 'Failed to remove image'], 500);
        }
    }

    public function getSignedUrl($fileName, $expiration)
    {
        try {
            $bucketName = env('AWS_BUCKET');

            $s3Client = new S3Client([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Set the expiration time for the signed URL
            // $expiration = '+1 minute'; // Adjust the expiration time as needed

            $command = $s3Client->getCommand('putObject', [
                'Bucket' => $bucketName,
                'Key' => $fileName
            ]);

            $signedUrl = $s3Client->createPresignedRequest($command, $expiration)->getUri();

            // Assuming $uri is the instance of the Psr7 Uri object
            $urlString = (string) $signedUrl;

            return $urlString;
        } catch (AwsException $e) {
            // Handle the exception if any error occurs
            throw $e;
        }
    }

    public function getDownloadUrl($fileName, $expiration)
    {
        try {
            $bucketName = env('AWS_BUCKET');

            $s3Client = new S3Client([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Set the expiration time for the signed URL
            // $expiration = '+1 minute'; // Adjust the expiration time as needed

            $command = $s3Client->getCommand('getObject', [
                'Bucket' => $bucketName,
                'Key' => $fileName
            ]);

            $signedUrl = $s3Client->createPresignedRequest($command, $expiration)->getUri();

            // Assuming $uri is the instance of the Psr7 Uri object
            $urlString = (string) $signedUrl;

            return $urlString;
        } catch (AwsException $e) {
            // Handle the exception if any error occurs
            throw $e;
        }
    }
}