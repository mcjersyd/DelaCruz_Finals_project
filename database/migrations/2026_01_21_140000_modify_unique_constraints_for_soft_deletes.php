<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Drop old unique constraint and add new one that excludes soft-deleted records
        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique('brands_name_unique');
            $table->unique(['name', 'deleted_at'])->nullable();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropUnique('vehicles_plate_number_unique');
            $table->unique(['plate_number', 'deleted_at'])->nullable();
        });
    }

    public function down(): void {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique('brands_name_deleted_at_unique');
            $table->unique('name');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropUnique('vehicles_plate_number_deleted_at_unique');
            $table->unique('plate_number');
        });
    }
};
