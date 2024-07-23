<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class GeneralHelper
{
    public function getUrl()
    {
        try {
            $imageUrl = 'Test';

            return $imageUrl;
        } catch (\Exception $e) {
            \Log::error('sendEmailNotifications Exception: ' . $e->getMessage());
        }
    }
}
