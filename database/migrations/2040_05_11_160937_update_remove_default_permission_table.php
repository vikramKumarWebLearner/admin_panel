<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // update permission records
        DB::statement("UPDATE permissions SET title = 'Add' WHERE name = 'permissions.create' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Save' WHERE name = 'permissions.store' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Edit' WHERE name = 'permissions.edit' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Delete' WHERE name = 'permissions.destroy' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'List' WHERE name = 'permissions.index' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Show' WHERE name = 'permissions.show' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Update' WHERE name = 'permissions.update' AND guard_name = 'web'");
        DB::statement("DELETE FROM permissions WHERE name = 'permissions.load-router' AND guard_name = 'web'");

        // update roles records
        DB::statement("UPDATE permissions SET title = 'Add' WHERE name = 'roles.create' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Save' WHERE name = 'roles.store' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Edit' WHERE name = 'roles.edit' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Delete' WHERE name = 'roles.destroy' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'List' WHERE name = 'roles.index' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Show' WHERE name = 'roles.show' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Update' WHERE name = 'roles.update' AND guard_name = 'web'");

        // update users records
        DB::statement("UPDATE permissions SET title = 'Add' WHERE name = 'users.create' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Save' WHERE name = 'users.store' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Edit' WHERE name = 'users.edit' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Delete' WHERE name = 'users.destroy' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'List' WHERE name = 'users.index' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Show' WHERE name = 'users.show' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Update' WHERE name = 'users.update' AND guard_name = 'web'");
        DB::statement("UPDATE permissions SET title = 'Send Reset Password Link' WHERE name = 'users.send-reset-password-link' AND guard_name = 'web'");

        // delete generator builder records
        DB::statement("DELETE FROM permissions WHERE module = 'generator_builder' AND guard_name = 'web'");

        // delete permissions records
        DB::statement("DELETE FROM permissions WHERE module = 'permissions' AND guard_name = 'web'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
