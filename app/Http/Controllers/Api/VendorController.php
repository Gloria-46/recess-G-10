<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http; // Added for Java server communication
use Illuminate\Support\Facades\Log; // Added for logging

class VendorController extends Controller
{
    /**
     * Register a new vendor via API
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:20',
            'year_of_establishment' => 'nullable|integer|min:1900|max:' . date('Y'),
            'about' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Validate with Java server before creating vendor
            $javaValidationResult = $this->validateWithJavaServer($request);
            
            if (!$javaValidationResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vendor validation failed',
                    'validation_errors' => $javaValidationResult['errors']
                ], 422);
            }

            $vendor = Vendor::create([
                'business_name' => $request->business_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone ?? $request->contact,
                'address' => $request->address,
                'contact' => $request->contact,
                'yearOfEstablishment' => $request->year_of_establishment,
                'about' => $request->about ?? '',
                'is_active' => true,
                'status' => 'pending',
                'visit_date' => now()->addDays(3),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vendor registered successfully',
                'data' => [
                    'vendor_id' => $vendor->id,
                    'business_name' => $vendor->business_name,
                    'email' => $vendor->email,
                    'status' => $vendor->status,
                    'validation_result' => $javaValidationResult['data'] ?? null,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate vendor data with Java server
     */
    private function validateWithJavaServer(Request $request): array
    {
        try {
            // Configure Java server URL - update this with your actual Java server URL
            $javaServerUrl = env('SPRING_API_URL', 'http://localhost:8080/api') . '/validate-vendor';
            
            $validationData = [
                'business_name' => $request->business_name,
                'email' => $request->email,
                'phone' => $request->phone ?? $request->contact,
                'address' => $request->address,
                'year_of_establishment' => $request->year_of_establishment,
                'contact' => $request->contact,
                'about' => $request->about,
            ];

            // Make HTTP request to Java server
            $response = Http::timeout(30)->post($javaServerUrl, $validationData);
            
            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => $result['success'] ?? false,
                    'errors' => $result['errors'] ?? [],
                    'data' => $result['data'] ?? null,
                    'message' => $result['message'] ?? 'Validation completed'
                ];
            } else {
                // If Java server is not available, log the error but continue with registration
                Log::warning('Java validation server not available', [
                    'url' => $javaServerUrl,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'success' => true, // Continue with registration if Java server is down
                    'errors' => [],
                    'data' => null,
                    'message' => 'Java validation server not available, proceeding with registration'
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('Java validation server error', [
                'error' => $e->getMessage(),
                'vendor_data' => $request->only(['business_name', 'email', 'phone', 'address'])
            ]);
            
            // If Java server is completely unavailable, continue with registration
            return [
                'success' => true,
                'errors' => [],
                'data' => null,
                'message' => 'Java validation server unavailable, proceeding with registration'
            ];
        }
    }

    /**
     * Get vendor profile
     */
    public function profile(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
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

    /**
     * Update vendor profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
        $validator = Validator::make($request->all(), [
            'business_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:vendors,email,' . $vendor->id,
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'contact' => 'sometimes|string|max:20',
            'year_of_establishment' => 'sometimes|integer|min:1900|max:' . date('Y'),
            'about' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor->update($request->only([
            'business_name', 'email', 'phone', 'address', 
            'contact', 'yearOfEstablishment', 'about'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
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
            ]
        ]);
    }

    /**
     * Get vendor products
     */
    public function getProducts(Request $request): JsonResponse
    {
        $products = Product::with('vendor')
            ->when($request->vendor_id, function($query, $vendorId) {
                return $query->where('vendor_id', $vendorId);
            })
            ->where('is_active', true)
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Create a new product
     */
    public function createProduct(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string',
            'size' => 'required|string',
            'current_stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['vendor_id'] = $vendor->id;
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Update a product
     */
    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        $vendor = $request->user();
        
        // Check if vendor owns this product
        if ($product->vendor_id !== $vendor->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'color' => 'sometimes|string',
            'size' => 'sometimes|string',
            'current_stock' => 'sometimes|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Delete a product
     */
    public function deleteProduct(Request $request, Product $product): JsonResponse
    {
        $vendor = $request->user();
        
        // Check if vendor owns this product
        if ($product->vendor_id !== $vendor->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete product image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get vendor orders
     */
    public function getOrders(Request $request): JsonResponse
    {
        $vendor = $request->user();
        
        $orders = Order::with(['items.product', 'user'])
            ->where('vendor_id', $vendor->id)
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get specific order
     */
    public function getOrder(Request $request, Order $order): JsonResponse
    {
        $vendor = $request->user();
        
        if ($order->vendor_id !== $vendor->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $order->load(['items.product', 'user']);

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order): JsonResponse
    {
        $vendor = $request->user();
        
        if ($order->vendor_id !== $vendor->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }
} 