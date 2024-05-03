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
        DB::statement('CREATE TABLE notifications(
            id INT PRIMARY KEY AUTO_INCREMENT,
            notification_icon VARCHAR(1024),
            notification_content VARCHAR(255) NOT NULL,
            notification_link VARCHAR(100),
            notification_target INT NOT NULL,
            notification_creator INT NOT NULL,
            notification_for_admin BOOL DEFAULT 0,
            is_read BOOL DEFAULT 0,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
