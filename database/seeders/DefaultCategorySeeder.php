<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DefaultCategorySeeder extends Seeder
{
    public function run(): void
    {
        $income = ['বেতন', 'ব্যবসা', 'উপহার', 'অন্যান্য আয়'];
        $expense = ['খাবার', 'যাতায়াত', 'বাড়ি ভাড়া', 'বিদ্যুৎ', 'গ্যাস', 'পানি', 'শিক্ষা', 'চিকিৎসা', 'অন্যান্য খরচ'];

        foreach ($income as $name) {
            Category::firstOrCreate(['user_id' => null, 'name' => $name, 'type' => 'income'], ['is_default' => true]);
        }
        foreach ($expense as $name) {
            Category::firstOrCreate(['user_id' => null, 'name' => $name, 'type' => 'expense'], ['is_default' => true]);
        }
    }
}
