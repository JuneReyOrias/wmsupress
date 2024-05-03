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
        DB::statement('CREATE TABLE stockin_stockout_records(
            id INT PRIMARY KEY AUTO_INCREMENT,
            product_stock_id INT,
            stock_type_id INT,
            stock_by INT,
            quantity INT,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');

        DB::statement('CREATE INDEX idx_stockin_stockout_records_product_stock_id ON stockin_stockout_records(product_stock_id);');
        DB::statement('CREATE INDEX idx_stockin_stockout_records_stock_type_id ON stockin_stockout_records(stock_type_id);');
        DB::statement('CREATE INDEX idx_stockin_stockout_records_stock_by ON stockin_stockout_records(stock_by);');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockin_stockout_records');
    }
};
