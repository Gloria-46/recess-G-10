<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Login vendor and return token
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('vendor')->attempt($credentials)) {
            $vendor = Auth::guard('vendor')->user();
            
            // Create token for API access
            $token = $vendor->createToken('vendor-api-token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'vendor' => [
                        'id' => $vendor->id,
                        'business_name' => $vendor->business_name,
                        'email' => $vendor->email,
                        'status' => $vendor->status,
                        'is_active' => $vendor->is_active,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Logout vendor and revoke token
     */
    public function logout(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
        if ($vendor) {
            // Revoke all tokens for this vendor
            $vendor->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get current authenticated vendor
     */
    public function me(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $vendor->id,
                'business_name' => $vendor->business_name,
                'email' => $vendor->email,
                'phone' => $vendor->phone,
                'address' => $vendor->address,
                'contact' => $vendor->contact,
                'year_of_establishment' => $vendor->yearOfEstablishment,
                'about' => $vendor->about,
                'status' => $vendor->status,
                'is_active' => $vendor->is_active,
                'created_at' => $vendor->created_at,
            ]
        ]);
    }
} 