<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UserLogout {
	public function __construct() {
	}

	public function handle(Logout $event) {
		// $event->user->checkout(0);
	}
}
