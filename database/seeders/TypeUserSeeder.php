<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_user')->insert(
            [
                [
                    'id' => 1,
                    'description' => 'admin',
                ],
                [
                    'id'=> 2,
                    'description'=> 'common',
                ],
            ]
        );
    }
}
