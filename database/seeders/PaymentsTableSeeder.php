<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->delete();

        DB::table('payments')->insert([
            [
                'id' => 4, 'subscription_id' => 5, 'amount' => 900000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776088131', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-13 06:48:51', 'updated_at' => '2026-04-13 06:49:56'
            ],
            [
                'id' => 9, 'subscription_id' => 10, 'amount' => 300000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776136124', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-13 20:08:44', 'updated_at' => '2026-04-13 20:09:19'
            ],
            [
                'id' => 10, 'subscription_id' => 11, 'amount' => 300000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776138882', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-13 20:54:42', 'updated_at' => '2026-04-13 20:55:02'
            ],
            [
                'id' => 12, 'subscription_id' => 13, 'amount' => 1500000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776213842', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-14 17:44:02', 'updated_at' => '2026-04-14 17:45:28'
            ],
            [
                'id' => 13, 'subscription_id' => 14, 'amount' => 800000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776214104', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-14 17:48:24', 'updated_at' => '2026-04-14 17:48:40'
            ],
            [
                'id' => 18, 'subscription_id' => 23, 'amount' => 1500000.00, 'method' => 'e_wallet', 'status' => 'completed',
                'invoice_code' => 'VNP1776215868', 'note' => null, 'confirmed_by' => null, 'created_at' => '2026-04-14 18:17:48', 'updated_at' => '2026-04-14 18:18:05'
            ],
        ]);
    }
}
