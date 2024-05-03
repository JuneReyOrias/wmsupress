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
        DB::statement('CREATE TABLE products(
            id INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(100) UNIQUE ,
            name VARCHAR(255) NOT NULL ,
            description VARCHAR(255) ,
            image VARCHAR(100) NOT NULL ,
            price DOUBLE NOT NULL,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        DB::statement('CREATE INDEX idx_products_name ON products(name(10));');
        DB::statement('CREATE INDEX idx_products_code ON products(code(10));');
        DB::statement('CREATE INDEX idx_products_image ON products(image(10));');
        DB::statement('
        INSERT INTO `products` (`id`, `code`, `name`, `description`, `image`, `price`, `is_active`, `date_created`, `date_updated`) VALUES
        (1, "S-1", "Seal", "high quality seal embroidery ", "1534f4a5b1c04f5aa629ba9471441fc1.jpg", 45.4, 1, "2024-04-20 01:21:44", "2024-04-20 01:21:44"),
        (2, "L-100", "Lanyard", NULL, "161afcede561c7e7022cacd7ab1bec7b.png", 14.4, 1, "2024-04-20 01:32:59", "2024-04-20 01:32:59");');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
