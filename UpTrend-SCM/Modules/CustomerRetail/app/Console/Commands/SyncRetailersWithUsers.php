<?php

namespace Modules\CustomerRetail\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\CustomerRetail\App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SyncRetailersWithUsers extends Command
{
    protected $signature = 'retailers:sync-users';
    protected $description = 'Ensure every retailer has a linked user_id in the users table.';

    public function handle()
    {
        $count = 0;
        Retailer::whereNull('user_id')->get()->each(function ($retailer) use (&$count) {
            $user = User::where('email', $retailer->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $retailer->business_name ?? 'Retailer',
                    'email' => $retailer->email,
                    'password' => Hash::make($retailer->password),
                    'role' => 'retailer',
                ]);
            }
            $retailer->user_id = $user->id;
            $retailer->save();
            $count++;
        });
        $this->info("Synced $count retailers with users.");
    }
} 