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
        if (!Schema::hasColumn('Reuniones', 'notas')) {
            Schema::table('Reuniones', function (Blueprint $table) {
                $table->text('notas')->nullable()->after('valor');
            });
        }

        DB::statement(
            "ALTER TABLE `Reuniones` MODIFY COLUMN `estado` ENUM('realizada','cancelada','pendiente','realizada-sin-costo') NOT NULL"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE `Reuniones` SET `estado` = 'realizada' WHERE `estado` = 'realizada-sin-costo'");
        DB::statement(
            "ALTER TABLE `Reuniones` MODIFY COLUMN `estado` ENUM('realizada','cancelada','pendiente') NOT NULL"
        );

        if (Schema::hasColumn('Reuniones', 'notas')) {
            Schema::table('Reuniones', function (Blueprint $table) {
                $table->dropColumn('notas');
            });
        }
    }
};
