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
        DB::statement('CREATE TABLE product_stocks(
            id INT PRIMARY KEY AUTO_INCREMENT,
            product_id INT,
            product_color_id INT,
            product_size_id INT,
            quantity INT,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_product_stocks_product_id ON product_stocks(product_id);');
        DB::statement('CREATE INDEX idx_product_stocks_product_color_id ON product_stocks(product_color_id);');
        DB::statement('CREATE INDEX idx_product_stocks_product_size_id ON product_stocks(product_size_id);');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
