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
        DB::statement('CREATE TABLE availed_services(
            id INT PRIMARY KEY AUTO_INCREMENT,
            service_status_id INT NOT NULL,
            customer_id INT NOT NULL,
            image_proof VARCHAR(100) ,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_availed_services_customer_id ON availed_services(customer_id);');
        DB::statement('CREATE INDEX idx_availed_services_image_proof ON availed_services(image_proof(10));');
        DB::statement('CREATE INDEX idx_availed_services_service_status_id ON availed_services(service_status_id);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availed_services');
    }
};
