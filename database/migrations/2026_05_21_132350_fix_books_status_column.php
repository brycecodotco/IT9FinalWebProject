<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement("ALTER TABLE books MODIFY status VARCHAR(255) DEFAULT 'Available'");
    }

    public function down()
    {
        // Revert is not necessary for this fix
    }
};