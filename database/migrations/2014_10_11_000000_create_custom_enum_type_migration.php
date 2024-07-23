<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement("DROP TYPE IF EXISTS general_status");
        // DB::statement("CREATE TYPE public.general_status AS ENUM ('ACTIVE','INACTIVE')");
        // DB::statement("DROP TYPE IF EXISTS leap_auth_type");
        // DB::statement("CREATE TYPE public.leap_auth_type AS ENUM ('MOBILE_OTP')");
        // DB::statement("DROP TYPE IF EXISTS leap_client_type");
        // DB::statement("CREATE TYPE public.leap_client_type AS ENUM ('LEAP_APP_CLIENT','WI')");
        // DB::statement("DROP TYPE IF EXISTS leap_user_status");
        // DB::statement("CREATE TYPE public.leap_user_status AS ENUM ('ACTIVE','INACTIVE','SUSPENDED','DELETED')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement("DROP TYPE IF EXISTS general_status");
        // DB::statement("DROP TYPE IF EXISTS leap_auth_type");
        // DB::statement("DROP TYPE IF EXISTS leap_client_type");
        // DB::statement("DROP TYPE IF EXISTS leap_user_status");
    }
};
