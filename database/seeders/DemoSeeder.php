<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fatwa;
use App\Models\Book;
use App\Models\News;
use Spatie\Permission\Models\Role;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'sheikh']);
        Role::firstOrCreate(['name' => 'user']);

        // مستخدمين أساسيين
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@fatwa.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $sheikh = User::create([
            'name' => 'الشيخ محمد',
            'email' => 'sheikh@fatwa.com',
            'password' => bcrypt('password'),
        ]);
        $sheikh->assignRole('sheikh');

        $user = User::create([
            'name' => 'مستخدم عادي',
            'email' => 'user@fatwa.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        // مستخدمين إضافيين
        User::factory(10)->create();

        // فتاوى وهمية
        Fatwa::factory(10)->create(['user_id' => $user->id]);

        // فتاوى مجابة
        Fatwa::factory(5)->create([
            'user_id' => $user->id,
            'sheikh_id' => $sheikh->id,
            'answer' => 'هذا هو الرد التجريبي على السؤال الفقهي.',
            'status' => 'answered'
        ]);

        // كتب
        Book::factory(10)->create();

        // أخبار
        News::factory(10)->create();
    }
}
