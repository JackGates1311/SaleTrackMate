<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
                'id' => '9a387cc7-b34d-4ccc-af83-4472fe8f28db',
                'username' => 'peraperic',
                'email' => 'peraperic@mail.com',
                'password' => '$2y$10$Mdjz.ZUS2uOiupBdFp5/9uQowWO19sQqocOt5jzqEhS0PmsWBwuvO',
                'first_name' => 'Pera',
                'middle_name' => null,
                'last_name' => 'Peric',
                'country' => 'RS',
                'city' => 'Sabac',
                'address' => 'Ulica bb.',
                'postal_code' => '15000',
                'phone' => '015390888',
                'fax' => null,
                'is_active' => 1,
                'account_type' => 'ADMINISTRATOR',
                'created_at' => '2023-09-25 18:33:43',
                'updated_at' => '2023-09-25 18:33:43',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
