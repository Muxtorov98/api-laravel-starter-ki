<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('person_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('person')->onDelete('cascade'); // Shaxs ID
            $table->string('passport_serial_number')->nullable(false); // Pasport seriyasi
            $table->string('passport_number')->nullable(false); // Pasport raqami
            $table->string('passport_personal_number')->unique(); // Shaxsiy raqam (unique)
            $table->string('issued_by'); // Berilgan organ
            $table->date('issued_date'); // Berilgan sana
            $table->date('expiry_date')->nullable(); // Amal qilish muddati
            $table->string('country')->nullable(); // Mamlakat

            $table->commonColumns();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_document');
    }
};
