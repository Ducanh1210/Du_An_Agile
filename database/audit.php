<?php
// Quick audit script to check database state

$tables = DB::select('SHOW TABLES');
foreach ($tables as $t) {
    $name = array_values((array) $t)[0];
    $count = DB::table($name)->count();
    echo "$name: $count rows\n";
}

echo "\n--- SUBSCRIPTION AUDIT ---\n";

// Check for users with multiple subscriptions
$dupes = DB::select("
    SELECT user_id, COUNT(*) as cnt 
    FROM subscriptions 
    GROUP BY user_id 
    HAVING cnt > 1
");

if (empty($dupes)) {
    echo "No users with duplicate subscriptions.\n";
} else {
    echo count($dupes) . " users have multiple subscriptions:\n";
    foreach ($dupes as $d) {
        echo "  user_id={$d->user_id} has {$d->cnt} subscriptions\n";
        $subs = DB::table('subscriptions')->where('user_id', $d->user_id)->get();
        foreach ($subs as $s) {
            echo "    id={$s->id} status={$s->status} start={$s->start_date} end={$s->end_date}\n";
        }
    }
}

echo "\n--- GENERAL DATA CHECK ---\n";

// Check users by role
$roles = DB::select("SELECT role, COUNT(*) as cnt FROM users GROUP BY role");
echo "Users by role:\n";
foreach ($roles as $r) {
    echo "  {$r->role}: {$r->cnt}\n";
}

// Check subscriptions by status
$statuses = DB::select("SELECT status, COUNT(*) as cnt FROM subscriptions GROUP BY status");
echo "Subscriptions by status:\n";
foreach ($statuses as $s) {
    echo "  {$s->status}: {$s->cnt}\n";
}
