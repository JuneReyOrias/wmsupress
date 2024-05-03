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
        DB::statement('CREATE TABLE product_colors(
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) UNIQUE ,
            description VARCHAR(255) ,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_product_colors_name ON product_colors(name(10));');
        DB::statement('
        INSERT INTO `product_colors` (`id`, `name`, `description`, `is_active`, `date_created`, `date_updated`) VALUES
        (1, "Black", "Dark af", 1, "2024-04-20 01:40:06", "2024-04-20 01:40:06"),
        (2, "Maroon", "Shady maroon", 1, "2024-04-20 01:40:16", "2024-04-20 01:40:16");');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
