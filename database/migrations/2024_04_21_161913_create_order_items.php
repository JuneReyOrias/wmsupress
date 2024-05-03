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
        DB::statement('CREATE TABLE order_items(
            id INT PRIMARY KEY AUTO_INCREMENT,
            order_id INT NOT NULL ,
            order_by INT NOT NULL ,
            product_stock_id INT NOT NULL ,
            quantity INT NOT NULL ,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');

        DB::statement('CREATE INDEX idx_order_items_product_stock_id ON order_items(product_stock_id);');
        DB::statement('CREATE INDEX idx_order_items_order_id ON order_items(order_id);');
        DB::statement('CREATE INDEX idx_order_items_order_by ON order_items(order_by);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
