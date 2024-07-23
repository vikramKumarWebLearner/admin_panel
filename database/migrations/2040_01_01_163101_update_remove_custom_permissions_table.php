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
        // Example of custom module permission records update & delete
        // DB::statement("UPDATE crm_permissions SET title = 'add' WHERE name = 'categories.create' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'save' WHERE name = 'categories.store' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'edit' WHERE name = 'categories.edit' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'delete' WHERE name = 'categories.destroy' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'view' WHERE name = 'categories.index' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'show' WHERE name = 'categories.show' AND guard_name = 'web'");
        // DB::statement("UPDATE crm_permissions SET title = 'update' WHERE name = 'categories.update' AND guard_name = 'web'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
