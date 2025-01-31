<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10000; $i++)
        {
            \App\Models\ProductModel::create([
                'pro_group_id' => 1,
                'pro_category_id' => 1,
                'pro_code' =>  substr(md5($i), 0, 13),
                'pro_p_code' => substr(md5($i), 0, 13),
                'pro_alternative_code' => substr(md5($i), 0, 13),
                'pro_ISBN' => substr(md5($i), 0, 13),
                'pro_title' => 'Test Product - '.$i,
            ]);
        }
    }
}
