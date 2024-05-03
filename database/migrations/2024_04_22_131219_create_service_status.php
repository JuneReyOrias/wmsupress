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
        DB::statement('CREATE TABLE service_status(
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) UNIQUE,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
         DB::statement('INSERT INTO service_status VALUES(
            NULL,
            "Pending",
            NOW(),
            NOW()),
            (NULL,
            "Declined",
            NOW(),
            NOW()),
            (NULL,
            "Approved",
            NOW(),
            NOW()),
            (NULL,
            "Completed",
            NOW(),
            NOW()),
            (NULL,
            "Cancelled",
            NOW(),
            NOW()),
            (NULL,
            "Ready for Pickup",
            NOW(),
            NOW());');
           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_status');
    }
};
