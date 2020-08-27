<?php

use Illuminate\Database\Seeder;

class VendorDishesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $range_dish = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        $range_vendors = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,
        34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50];
        for($x=0;$x < 150; $x++){
            $index_dish = array_rand($range_dish);
            $sel_dish = $range_dish[$index_dish];

            $index_vendor = array_rand($range_vendors);
            $sel_vendor = $range_vendors[$index_vendor];
            DB::table('vendordishes')->insert([
                [
                    'dish_id' => $sel_dish,
                    'vendor_id' => $sel_vendor,
                ]
            ]);
        }
    }
}
