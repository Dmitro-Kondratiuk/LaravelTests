<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
           [
               'id'=>1,
               'name'=>'Designer',
               'created_at'=>now(),
               'updated_at'=>now()
           ],
           [
               'id'=>2,
               'name'=>'Security',
               'created_at'=>now(),
               'updated_at'=>now()
           ],
           [
               'id'=>3,
               'name'=>'Developer',
               'created_at'=>now(),
               'updated_at'=>now()
           ],
           [
               'id'=>4,
               'name'=>'QA Manager',
               'created_at'=>now(),
               'updated_at'=>now()
           ],

        ]);
    }
}
