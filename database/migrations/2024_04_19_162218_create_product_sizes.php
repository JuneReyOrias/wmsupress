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
        DB::statement('CREATE TABLE product_sizes(
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) UNIQUE ,
            description VARCHAR(255) ,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_product_sizes_name ON product_sizes(name(10));');
        DB::statement('
        INSERT INTO `product_sizes` (`id`, `name`, `description`, `is_active`, `date_created`, `date_updated`) VALUES
        (1, "S", "Smail", 1, "2024-04-20 01:39:28", "2024-04-20 01:39:28"),
        (2, "M", "Medium", 1, "2024-04-20 01:39:36", "2024-04-20 01:39:36"),
        (3, "L", "Large", 1, "2024-04-20 01:39:45", "2024-04-20 01:59:43"),
        (4, "XL", "Extra Large", 1, "2024-04-20 01:43:49", "2024-04-20 01:43:49");');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
