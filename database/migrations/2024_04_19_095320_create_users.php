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
        DB::statement('CREATE TABLE users(
            id INT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(255) NOT NULL,
            middle_name VARCHAR(255),
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(100) UNIQUE,
            password VARCHAR(255) NOT NULL,
            image VARCHAR(100) DEFAULT "default.png",
            contact_no VARCHAR (50),
            role_id INT,
            college_id INT,
            department_id INT,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');
        
        DB::statement('CREATE INDEX idx_user_password ON users(password(10));');
        DB::statement('CREATE INDEX idx_user_email ON users(email(10));');
        DB::statement('CREATE INDEX idx_user_fullname ON users(first_name(10),middle_name(10),last_name(10));');
        DB::statement('CREATE INDEX idx_user_college_id ON users(college_id);');
        DB::statement('CREATE INDEX idx_user_role_id ON users(role_id);');

        DB::statement('
        INSERT INTO `users`(`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `image`, `contact_no`, `role_id`, `college_id`, `department_id`, `is_active`, `date_created`, `date_updated`) VALUES 
        (NULL,
         "Joe",
         "",
         "Maderal",
         "joemaderal@gmail.com",
         "$2y$12$bhn5OsWUjzGmgs.0b3cW9.gPv2493VPtOcJqLnfmXmVizf1eTLibu",
         "default.png",
         "0995936987",
         3,
         15,
         2,
         1,
         NOW(),
         NOW())
        ');

        DB::statement('
        INSERT INTO `users`(`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `image`, `contact_no`, `role_id`, `college_id`, `department_id`, `is_active`, `date_created`, `date_updated`) VALUES 
        (NULL,
         "Junerey",
         "",
         "Orias",
         "oriasjunerey@gmail.com",
         "$2y$12$bhn5OsWUjzGmgs.0b3cW9.gPv2493VPtOcJqLnfmXmVizf1eTLibu",
         "default.png",
         "0995936987",
         1,
         15,
         2,
         1,
         NOW(),
         NOW())
        ');

        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("users");
    }
};
