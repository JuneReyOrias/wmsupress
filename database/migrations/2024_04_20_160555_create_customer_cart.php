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
        DB::statement('CREATE TABLE customer_cart(
            id INT PRIMARY KEY AUTO_INCREMENT,
            customer_id INT NOT NULL,
            product_stock_id INT NOT NULL,
            quantity INT NOT NULL,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');

        DB::statement('CREATE INDEX idx_customer_cart_customer_id ON customer_cart(customer_id);');
        DB::statement('CREATE INDEX idx_customer_cart_product_stock_id ON customer_cart(product_stock_id);');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_cart');
    }
};
