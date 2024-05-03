<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE TABLE colleges(
            id INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(100) UNIQUE,
            name VARCHAR(255) NOT NULL,
            is_active BOOL DEFAULT 1,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );');

        DB::statement('CREATE INDEX idx_college_code ON colleges(code(10));');
        DB::statement('CREATE INDEX idx_college_name ON colleges(name(10));');

        DB::statement('INSERT INTO colleges VALUES(NULL,"CA","College of Agriculture",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"COA","College of Architecture",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CAIS","College of Asian and Islamic Studies",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CCJE","College of Criminal Justice Education",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"COE","College of Engineering",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CFES","College of Forestry and Environmental Studies",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CHE","College of Home Economics",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CL","College of Law",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CLA","College of Liberal Arts",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CN","College of Nursing",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CPADS","College of Administrative and Development Studies",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CSPE","College of Sports Science and Physical Education",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CSM","College of Science and Mathematics",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CSCD","College of Social Work and Community Development",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CCS","College of Computing Studies",1,NOW(),NOW());');
        DB::statement('INSERT INTO colleges VALUES(NULL,"CTE","College of Teacher Education",1,NOW(),NOW());');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
