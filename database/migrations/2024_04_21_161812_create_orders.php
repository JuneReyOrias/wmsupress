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
        DB::statement('CREATE TABLE orders(
            id INT PRIMARY KEY AUTO_INCREMENT,
            order_by INT NOT NULL ,
            status INT DEFAULT 1 NOT NULL,
            total_price double ,
            image_proof VARCHAR(100) ,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_orders_order_by ON orders(order_by);');
        DB::statement('CREATE INDEX idx_orders_status ON orders(status);');
        DB::statement('CREATE INDEX idx_orders_image_proof ON orders(image_proof(10));');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
