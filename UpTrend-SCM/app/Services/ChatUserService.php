<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class ChatUserService
{
    /**
     * Get available users for chat, grouped by role, based on the current user's role.
     *
     * @param User $currentUser
     * @return array
     */
    public static function getAvailableChatUsersGrouped(User $currentUser)
    {
        $role = $currentUser->role;
        $groups = [
            'Admins' => collect(),
            'Vendors' => collect(),
            'Warehouses' => collect(),
            'Retailers' => collect(),
            'Customers' => collect(),
        ];

        // Define chat rules
        $chatMatrix = [
            'admin' => ['admin', 'vendor', 'warehouse', 'retailer'],
            'warehouse' => ['warehouse', 'vendor', 'retailer', 'admin'],
            'vendor' => ['vendor', 'warehouse'],
            'retailer' => ['retailer', 'warehouse', 'admin', 'customer'],
            'customer' => ['retailer'],
        ];

        $allowedRoles = $chatMatrix[$role] ?? [];

        // Query users for each allowed role
        foreach ($allowedRoles as $allowedRole) {
            $users = User::where('role', $allowedRole)
                ->where('id', '!=', $currentUser->id)
                ->get();
            switch ($allowedRole) {
                case 'admin':
                    $groups['Admins'] = $users;
                    break;
                case 'vendor':
                    $groups['Vendors'] = $users;
                    break;
                case 'warehouse':
                    $groups['Warehouses'] = $users;
                    break;
                case 'retailer':
                    $groups['Retailers'] = $users;
                    break;
                case 'customer':
                    $groups['Customers'] = $users;
                    break;
            }
        }

        // For roles that can chat within their own role (all but customer and retailer)
        if (in_array($role, ['admin', 'vendor', 'warehouse'])) {
            $users = User::where('role', $role)
                ->where('id', '!=', $currentUser->id)
                ->get();
            switch ($role) {
                case 'admin':
                    $groups['Admins'] = $groups['Admins']->merge($users);
                    break;
                case 'vendor':
                    $groups['Vendors'] = $groups['Vendors']->merge($users);
                    break;
                case 'warehouse':
                    $groups['Warehouses'] = $groups['Warehouses']->merge($users);
                    break;
            }
        }

        return $groups;
    }
} 