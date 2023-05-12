<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('CREATE TRIGGER add_user_role AFTER INSERT ON users FOR EACH ROW INSERT INTO user_has_roles(user_id, role_id) VALUES (NEW.id, 2)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER add_user_role');
    }
};
