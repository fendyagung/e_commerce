<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data lama agar tidak duplikat
        DB::table('users')->delete();

        $user = new User;
        $user->name = "Fendi Agung";
        $user->email = "fendagung515@gmail.com";
        $user->password = bcrypt("1234");
        $user->phone = "123456789";
        $user->alamat = "Yogyakarta";
        $user->role = "admin";
        $user->status = "aktif"; // Sesuai dengan field di migration Anda
        $user->foto = null;      // Field foto boleh null sesuai migration
        $user->save();
    }
}