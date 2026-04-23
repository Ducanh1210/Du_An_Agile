<?php

use Illuminate\Support\Facades\DB;

// Disable FK checks for cleanup
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

// === 1. FIX DUPLICATE SUBSCRIPTIONS ===
echo "=== CLEANING DUPLICATE SUBSCRIPTIONS ===\n";

$dupes = DB::select("
    SELECT user_id, COUNT(*) as cnt 
    FROM subscriptions 
    GROUP BY user_id 
    HAVING cnt > 1
");

foreach ($dupes as $d) {
    echo "User {$d->user_id}: {$d->cnt} subscriptions → ";
    
    // Keep the best one (active first, then latest end_date)
    $best = DB::table('subscriptions')
        ->where('user_id', $d->user_id)
        ->orderByRaw("FIELD(status, 'active', 'pending_payment', 'expired', 'cancelled') ASC")
        ->orderBy('end_date', 'desc')
        ->first();
    
    $idsToDelete = DB::table('subscriptions')
        ->where('user_id', $d->user_id)
        ->where('id', '!=', $best->id)
        ->pluck('id')
        ->toArray();

    // Re-point any payments from deleted subs to the kept sub
    DB::table('payments')
        ->whereIn('subscription_id', $idsToDelete)
        ->update(['subscription_id' => $best->id]);

    // Re-point any bookings from deleted subs to the kept sub
    DB::table('bookings')
        ->whereIn('subscription_id', $idsToDelete)
        ->update(['subscription_id' => $best->id]);
    
    // Now delete the duplicates
    $deleted = DB::table('subscriptions')
        ->whereIn('id', $idsToDelete)
        ->delete();
    
    echo "kept id={$best->id} (status={$best->status}), deleted {$deleted} duplicates\n";
}

// === 2. CLEAN ORPHAN PAYMENTS ===
echo "\n=== CLEANING ORPHAN PAYMENTS ===\n";
$orphanPayments = DB::select("
    SELECT p.id FROM payments p 
    LEFT JOIN subscriptions s ON p.subscription_id = s.id 
    WHERE p.subscription_id IS NOT NULL AND s.id IS NULL
");
if (!empty($orphanPayments)) {
    $ids = array_map(fn($p) => $p->id, $orphanPayments);
    DB::table('payments')->whereIn('id', $ids)->delete();
    echo "Deleted " . count($ids) . " orphan payments\n";
} else {
    echo "No orphan payments found.\n";
}

// === 3. CLEAN ORPHAN BOOKINGS ===
echo "\n=== CLEANING ORPHAN BOOKINGS ===\n";
$orphanBookings = DB::select("
    SELECT b.id FROM bookings b 
    LEFT JOIN subscriptions s ON b.subscription_id = s.id 
    WHERE b.subscription_id IS NOT NULL AND s.id IS NULL
");
if (!empty($orphanBookings)) {
    $ids = array_map(fn($b) => $b->id, $orphanBookings);
    DB::table('bookings')->whereIn('id', $ids)->delete();
    echo "Deleted " . count($ids) . " orphan bookings\n";
} else {
    echo "No orphan bookings found.\n";
}

// Re-enable FK checks
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// === 4. FINAL SUMMARY ===
echo "\n=== FINAL STATE ===\n";
echo "Users: " . DB::table('users')->count() . "\n";
echo "Subscriptions: " . DB::table('subscriptions')->count() . "\n";
echo "Payments: " . DB::table('payments')->count() . "\n";
echo "Bookings: " . DB::table('bookings')->count() . "\n";

$statuses = DB::select("SELECT status, COUNT(*) as cnt FROM subscriptions GROUP BY status");
foreach ($statuses as $s) {
    echo "  {$s->status}: {$s->cnt}\n";
}

$stillDupes = DB::select("SELECT user_id, COUNT(*) as cnt FROM subscriptions GROUP BY user_id HAVING cnt > 1");
echo "\nUsers still with duplicates: " . count($stillDupes) . "\n";
echo "\n✅ Cleanup complete!\n";
