<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Auth\Events\Authenticated;

class UserAuthenticated
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($event)
    {
    }
}
