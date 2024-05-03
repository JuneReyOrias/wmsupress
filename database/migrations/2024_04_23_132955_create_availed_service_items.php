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
        DB::statement('CREATE TABLE availed_service_items(
            id INT PRIMARY KEY AUTO_INCREMENT,
            customer_id INT NOT NULL,
            avail_service_id INT NOT NULL,
            service_id INT NOT NULL,
            quantity INT ,
            price_per_unit DOUBLE,
            total_price DOUBLE, 
            remarks VARCHAR(1024),
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_availed_service_items_service_id ON availed_service_items(service_id);');
        DB::statement('CREATE INDEX idx_availed_service_items_avail_service_id ON availed_service_items(avail_service_id);');
        DB::statement('CREATE INDEX idx_availed_service_items_customer_id ON availed_service_items(customer_id);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availed_service_items');
    }
};
