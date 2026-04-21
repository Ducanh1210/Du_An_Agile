<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSQLSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@gmail.com', 'phone' => null, 'height' => null, 'role' => 'admin', 'avatar_url' => null, 'is_active' => 1, 'email_verified_at' => '2026-04-02 23:29:21', 'password' => '$2y$10$S/0h3gETUE/mTg5TTNVyG.6SFgwGI/KepsmayXIF3OJrtafmGnw3C', 'created_at' => '2026-04-02 22:34:25', 'updated_at' => '2026-04-16 03:01:50'],
            ['id' => 2, 'name' => 'Client Test', 'email' => 'client@gmail.com', 'phone' => null, 'height' => null, 'role' => 'user', 'avatar_url' => null, 'is_active' => 1, 'email_verified_at' => '2026-04-02 23:29:31', 'password' => '$2y$10$saoAn5zcGuiKVLc8BXL7BeUTDVi899EMrXa4M.JNch2twqU/LdDa2', 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 23:29:31'],
            ['id' => 3, 'name' => 'Đức Anh Nguyễn', 'email' => 'anp93005@gmail.com', 'phone' => null, 'height' => null, 'role' => 'user', 'avatar_url' => '/storage/avatars/UIbibMtXLrwdzJG9FUcXs4XL7FpZdB7YMVGSSwGm.jpg', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$bBPqGgEmGvsrnRyBv1IVOORy448rFxmvx5bRdQtI3r9YncajFGKQ6', 'created_at' => '2026-04-02 22:38:04', 'updated_at' => '2026-04-17 15:34:14'],
            ['id' => 5, 'name' => 'Nguyễn Minh Tuấn', 'email' => 'tuan.gym@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => 'https://images.unsplash.com/photo-1567013127542-490d757e51cd?w=500&q=80&auto=format&fit=crop', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$dCpZBzjmVZk6z0nCYDHFTO2luaUbdj7Q9A5kVredQFToOuAb1yGV2', 'created_at' => '2026-04-10 23:00:39', 'updated_at' => '2026-04-16 03:42:40'],
            ['id' => 6, 'name' => 'Trần Thị Lan', 'email' => 'lan.yoga@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=500&q=80&auto=format&fit=crop', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$OV90qJXmOP76Xg1g5S7ZvOQWQjHAh2689A6VCxnet006S6UIkccGu', 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-16 03:42:41'],
            ['id' => 7, 'name' => 'Lê Văn Hùng', 'email' => 'hung.boxing@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$MmPNGEZH18sbO/fqXp35yuMg2eGSsJHzMKWrzwRObEaY8Z/6E5va.', 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-10 23:00:40'],
            ['id' => 8, 'name' => 'Phạm Thu Hà', 'email' => 'ha.fitness@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => '/storage/avatars/w6zVBxJQZFsSVaX9KerUAB7YKBzhpFtsVBVmKYEP.jpg', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$KDRJEC/qASttEhq/oDSF9OQH08kdel4Dw1X7BoFeY4rVfa8WgCvCC', 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-10 23:38:00'],
            ['id' => 9, 'name' => 'Phạm Thu Hà', 'email' => 'thuha12@gmail.com', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => null, 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$FXaG1uJKtNXpH89MWce6q.241PnZunOUxjhNZy6c5QLe6.XmcrlZm', 'created_at' => '2026-04-11 07:04:49', 'updated_at' => '2026-04-14 03:58:14'],
            ['id' => 10, 'name' => 'Phan Đức Tú', 'email' => 'tubun2@gmail.com', 'phone' => null, 'height' => null, 'role' => 'staff', 'avatar_url' => null, 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$IalRE7D5bBKEoqRZfqORwOQHB2ijfSFF26CHZHTxlZFz/BtQGi6Vq', 'created_at' => '2026-04-11 07:18:02', 'updated_at' => '2026-04-11 08:03:49'],
            ['id' => 11, 'name' => 'Admin User', 'email' => 'admin@dummy.com', 'phone' => null, 'height' => null, 'role' => 'user', 'avatar_url' => null, 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$f0OMXD4nD..1k87H/2M.ZOKzaa4L9A.PqBe.SZ0T2OCTZtdWvAOcC', 'created_at' => '2026-04-11 08:46:51', 'updated_at' => '2026-04-14 03:28:58'],
            ['id' => 12, 'name' => 'Lê Văn Hùng', 'email' => 'hung.bodybuilding@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$jAJEYNG2D./U.1KA9ysxNuepKMw.9S5XoW..SHkQ8NSH.FbUKsPCe', 'created_at' => '2026-04-16 03:42:41', 'updated_at' => '2026-04-16 03:42:41'],
            ['id' => 13, 'name' => 'Phạm Thu Hà', 'email' => 'ha.yoga@extrafit.vn', 'phone' => null, 'height' => null, 'role' => 'trainer', 'avatar_url' => 'https://images.unsplash.com/photo-1609899537878-49e9196c5bcd?w=500&q=80&auto=format&fit=crop', 'is_active' => 1, 'email_verified_at' => null, 'password' => '$2y$10$Qph5BVQFHsuJjgw.6PJ.3ObteEhQrvgHcAmQU/kdPZw.hAA.LSQXu', 'created_at' => '2026-04-16 03:42:41', 'updated_at' => '2026-04-16 03:42:41'],
        ]);
    }
}
