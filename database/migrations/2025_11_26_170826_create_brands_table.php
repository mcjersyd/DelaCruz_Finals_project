<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $request->validate([
    'brand_name' => 'required|string|max:255|unique:brands,brand_name',
]);
Brand::create([
    'brand_name' => $request->brand_name,
]);

    });
    }

    public function down(): void {
        Schema::dropIfExists('brands');
    }
};
