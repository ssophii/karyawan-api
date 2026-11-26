<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;
use App\Models\Karyawan;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $divisi = collect(['Operasional', 'Pengembangan', 'Umum'])
        ->map(fn ($nama) => Divisi::firstOrCreate(['nama' => $nama]));

        Karyawan::factory()->count(25)->create([
            'divisi_id' => fn() => $divisi->random()->id,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
