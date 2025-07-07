# Uptrend Clothing Store - Vendor API Documentation

## Overview
This API provides endpoints for vendor registration, authentication, and management for the Uptrend Clothing Store system. The API is designed to integrate with Java-based applications and other external systems.

## Base URL
```
http://your-domain.com/api
```

## Authentication
The API uses Laravel Sanctum for token-based authentication. Include the Bearer token in the Authorization header for protected endpoints.

```
Authorization: Bearer {your-token}
```

## Endpoints

### 1. Vendor Registration

**POST** `/api/vendor/register`

Register a new vendor account.

#### Request Body
```json
{
    "business_name": "Fashion Store Ltd",
    "email": "vendor@example.com",
    "password": "securepassword123",
    "phone": "+256700000000",
    "address": "Kampala, Uganda",
    "contact": "+256700000000",
    "year_of_establishment": 2020,
    "about": "We specialize in trendy clothing for all ages"
}
```

#### Response (Success - 201)
```json
{
    "success": true,
    "message": "Vendor registered successfully",
    "data": {
        "vendor_id": 1,
        "business_name": "Fashion Store Ltd",
        "email": "vendor@example.com",
        "status": "pending"
    }
}
```

#### Response (Error - 422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### 2. Vendor Login

**POST** `/api/vendor/login`

Authenticate a vendor and receive an access token.

#### Request Body
```json
{
    "email": "vendor@example.com",
    "password": "securepassword123"
}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "vendor": {
            "id": 1,
            "business_name": "Fashion Store Ltd",
            "email": "vendor@example.com",
            "status": "pending",
            "is_active": true
        },
        "token": "1|abc123def456ghi789...",
        "token_type": "Bearer"
    }
}
```

#### Response (Error - 401)
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

### 3. Get Current Vendor

**GET** `/api/vendor/me`

Get the current authenticated vendor's information.

#### Headers
```
Authorization: Bearer {token}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "data": {
        "id": 1,
        "business_name": "Fashion Store Ltd",
        "email": "vendor@example.com",
        "phone": "+256700000000",
        "address": "Kampala, Uganda",
        "contact": "+256700000000",
        "year_of_establishment": 2020,
        "about": "We specialize in trendy clothing for all ages",
        "status": "pending",
        "is_active": true,
        "created_at": "2025-01-15T10:30:00.000000Z"
    }
}
```

### 4. Update Vendor Profile

**PUT** `/api/vendor/profile`

Update the current vendor's profile information.

#### Headers
```
Authorization: Bearer {token}
```

#### Request Body
```json
{
    "business_name": "Updated Fashion Store Ltd",
    "phone": "+256700000001",
    "address": "New Kampala Address",
    "about": "Updated business description"
}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "business_name": "Updated Fashion Store Ltd",
        "email": "vendor@example.com",
        "phone": "+256700000001",
        "address": "New Kampala Address",
        "contact": "+256700000000",
        "year_of_establishment": 2020,
        "about": "Updated business description",
        "status": "pending",
        "is_active": true
    }
}
```

### 5. Vendor Logout

**POST** `/api/vendor/logout`

Logout the current vendor and invalidate the token.

#### Headers
```
Authorization: Bearer {token}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 6. Get Products

**GET** `/api/products`

Get all active products (public endpoint).

#### Query Parameters
- `vendor_id` (optional): Filter by specific vendor

#### Response (Success - 200)
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Blue T-Shirt",
                "description": "Comfortable cotton t-shirt",
                "price": "25000.00",
                "color": "Blue",
                "size": "M",
                "current_stock": 50,
                "category": "ladies",
                "image": "products/tshirt.jpg",
                "vendor": {
                    "id": 1,
                    "business_name": "Fashion Store Ltd"
                }
            }
        ],
        "per_page": 20,
        "total": 1
    }
}
```

### 7. Create Product

**POST** `/api/products`

Create a new product (requires authentication).

#### Headers
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

#### Request Body (Form Data)
```
name: "Red Dress"
description: "Elegant red dress for special occasions"
price: 75000
color: "Red"
size: "L"
current_stock: 25
category: "ladies"
image: [file upload]
```

#### Response (Success - 201)
```json
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 2,
        "name": "Red Dress",
        "description": "Elegant red dress for special occasions",
        "price": "75000.00",
        "color": "Red",
        "size": "L",
        "current_stock": 25,
        "category": "ladies",
        "image": "products/red-dress.jpg",
        "vendor_id": 1,
        "is_active": true
    }
}
```

### 8. Update Product

**PUT** `/api/products/{product_id}`

Update an existing product (requires authentication).

#### Headers
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

#### Request Body (Form Data)
```
name: "Updated Red Dress"
price: 80000
current_stock: 30
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Product updated successfully",
    "data": {
        "id": 2,
        "name": "Updated Red Dress",
        "price": "80000.00",
        "current_stock": 30
    }
}
```

### 9. Delete Product

**DELETE** `/api/products/{product_id}`

Delete a product (requires authentication).

#### Headers
```
Authorization: Bearer {token}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Product deleted successfully"
}
```

### 10. Get Orders

**GET** `/api/orders`

Get vendor's orders (requires authentication).

#### Headers
```
Authorization: Bearer {token}
```

#### Query Parameters
- `status` (optional): Filter by order status (pending, processing, shipped, delivered, cancelled)

#### Response (Success - 200)
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "order_number": "ORD-2025-001",
                "total_amount": "100000.00",
                "status": "pending",
                "customer_email": "customer@example.com",
                "created_at": "2025-01-15T10:30:00.000000Z",
                "items": [
                    {
                        "id": 1,
                        "product": {
                            "name": "Blue T-Shirt",
                            "price": "25000.00"
                        },
                        "quantity": 2,
                        "subtotal": "50000.00"
                    }
                ]
            }
        ],
        "per_page": 20,
        "total": 1
    }
}
```

### 11. Get Specific Order

**GET** `/api/orders/{order_id}`

Get details of a specific order (requires authentication).

#### Headers
```
Authorization: Bearer {token}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "data": {
        "id": 1,
        "order_number": "ORD-2025-001",
        "total_amount": "100000.00",
        "status": "pending",
        "customer_email": "customer@example.com",
        "shipping_address": "Kampala, Uganda",
        "created_at": "2025-01-15T10:30:00.000000Z",
        "items": [
            {
                "id": 1,
                "product": {
                    "name": "Blue T-Shirt",
                    "price": "25000.00"
                },
                "quantity": 2,
                "subtotal": "50000.00"
            }
        ]
    }
}
```

### 12. Update Order Status

**PUT** `/api/orders/{order_id}/status`

Update the status of an order (requires authentication).

#### Headers
```
Authorization: Bearer {token}
```

#### Request Body
```json
{
    "status": "processing"
}
```

#### Response (Success - 200)
```json
{
    "success": true,
    "message": "Order status updated successfully",
    "data": {
        "id": 1,
        "status": "processing"
    }
}
```

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

### Unauthorized (401)
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

### Forbidden (403)
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Internal server error",
    "error": "Error details"
}
```

## Java Integration Example

### Using Java HttpClient

```java
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.net.URI;
import java.nio.charset.StandardCharsets;

public class VendorApiClient {
    private static final String BASE_URL = "http://your-domain.com/api";
    private static final HttpClient client = HttpClient.newHttpClient();
    
    public String registerVendor(String businessName, String email, String password) {
        String jsonBody = String.format("""
            {
                "business_name": "%s",
                "email": "%s",
                "password": "%s",
                "phone": "+256700000000",
                "address": "Kampala, Uganda"
            }
            """, businessName, email, password);
            
        HttpRequest request = HttpRequest.newBuilder()
            .uri(URI.create(BASE_URL + "/vendor/register"))
            .header("Content-Type", "application/json")
            .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
            .build();
            
        try {
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
            return response.body();
        } catch (Exception e) {
            throw new RuntimeException("Registration failed", e);
        }
    }
    
    public String loginVendor(String email, String password) {
        String jsonBody = String.format("""
            {
                "email": "%s",
                "password": "%s"
            }
            """, email, password);
            
        HttpRequest request = HttpRequest.newBuilder()
            .uri(URI.create(BASE_URL + "/vendor/login"))
            .header("Content-Type", "application/json")
            .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
            .build();
            
        try {
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
            return response.body();
        } catch (Exception e) {
            throw new RuntimeException("Login failed", e);
        }
    }
    
    public String getVendorProfile(String token) {
        HttpRequest request = HttpRequest.newBuilder()
            .uri(URI.create(BASE_URL + "/vendor/me"))
            .header("Authorization", "Bearer " + token)
            .GET()
            .build();
            
        try {
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
            return response.body();
        } catch (Exception e) {
            throw new RuntimeException("Failed to get profile", e);
        }
    }
}
```

### Using Spring RestTemplate

```java
import org.springframework.http.*;
import org.springframework.web.client.RestTemplate;
import com.fasterxml.jackson.databind.ObjectMapper;

@Service
public class VendorApiService {
    private static final String BASE_URL = "http://your-domain.com/api";
    private final RestTemplate restTemplate = new RestTemplate();
    private final ObjectMapper objectMapper = new ObjectMapper();
    
    public VendorRegistrationResponse registerVendor(VendorRegistrationRequest request) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        
        HttpEntity<VendorRegistrationRequest> entity = new HttpEntity<>(request, headers);
        
        ResponseEntity<VendorRegistrationResponse> response = restTemplate.exchange(
            BASE_URL + "/vendor/register",
            HttpMethod.POST,
            entity,
            VendorRegistrationResponse.class
        );
        
        return response.getBody();
    }
    
    public VendorLoginResponse loginVendor(VendorLoginRequest request) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        
        HttpEntity<VendorLoginRequest> entity = new HttpEntity<>(request, headers);
        
        ResponseEntity<VendorLoginResponse> response = restTemplate.exchange(
            BASE_URL + "/vendor/login",
            HttpMethod.POST,
            entity,
            VendorLoginResponse.class
        );
        
        return response.getBody();
    }
    
    public VendorProfileResponse getVendorProfile(String token) {
        HttpHeaders headers = new HttpHeaders();
        headers.setBearerAuth(token);
        
        HttpEntity<String> entity = new HttpEntity<>(headers);
        
        ResponseEntity<VendorProfileResponse> response = restTemplate.exchange(
            BASE_URL + "/vendor/me",
            HttpMethod.GET,
            entity,
            VendorProfileResponse.class
        );
        
        return response.getBody();
    }
}
```

## Testing the API

### Using cURL

#### Register a vendor:
```bash
curl -X POST http://your-domain.com/api/vendor/register \
  -H "Content-Type: application/json" \
  -d '{
    "business_name": "Test Store",
    "email": "test@example.com",
    "password": "password123",
    "phone": "+256700000000",
    "address": "Kampala, Uganda"
  }'
```

#### Login:
```bash
curl -X POST http://your-domain.com/api/vendor/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

#### Get profile (with token):
```bash
curl -X GET http://your-domain.com/api/vendor/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Notes

1. **Token Management**: Store the token securely and include it in the Authorization header for all protected endpoints.

2. **Error Handling**: Always check the `success` field in responses and handle errors appropriately.

3. **File Uploads**: For product images, use `multipart/form-data` content type.

4. **Rate Limiting**: The API includes rate limiting to prevent abuse.

5. **CORS**: Configure CORS settings if calling from a web application.

6. **SSL**: Use HTTPS in production for secure communication.

## Support

For API support and questions, contact the development team at uptrendclothing09@gmail.com. 