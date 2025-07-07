import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.net.URI;
import java.nio.charset.StandardCharsets;
import java.util.Scanner;

/**
 * Java Client Example for Uptrend Clothing Store Vendor API
 * This example demonstrates how to integrate with the Laravel vendor registration system
 */
public class JavaClientExample {
    private static final String BASE_URL = "http://localhost:8000/api"; // Update with your domain
    private static final HttpClient client = HttpClient.newHttpClient();
    private static String authToken = null;
    
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        
        System.out.println("=== Uptrend Clothing Store - Vendor API Client ===");
        System.out.println("1. Register new vendor");
        System.out.println("2. Login vendor");
        System.out.println("3. Get vendor profile");
        System.out.println("4. Get products");
        System.out.println("5. Exit");
        
        while (true) {
            System.out.print("\nEnter your choice (1-5): ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Consume newline
            
            switch (choice) {
                case 1:
                    registerVendor(scanner);
                    break;
                case 2:
                    loginVendor(scanner);
                    break;
                case 3:
                    getVendorProfile();
                    break;
                case 4:
                    getProducts();
                    break;
                case 5:
                    System.out.println("Goodbye!");
                    return;
                default:
                    System.out.println("Invalid choice. Please try again.");
            }
        }
    }
    
    /**
     * Register a new vendor
     */
    private static void registerVendor(Scanner scanner) {
        System.out.println("\n=== Vendor Registration ===");
        
        System.out.print("Business Name: ");
        String businessName = scanner.nextLine();
        
        System.out.print("Email: ");
        String email = scanner.nextLine();
        
        System.out.print("Password: ");
        String password = scanner.nextLine();
        
        System.out.print("Phone: ");
        String phone = scanner.nextLine();
        
        System.out.print("Address: ");
        String address = scanner.nextLine();
        
        String jsonBody = String.format("""
            {
                "business_name": "%s",
                "email": "%s",
                "password": "%s",
                "phone": "%s",
                "address": "%s"
            }
            """, businessName, email, password, phone, address);
            
        try {
            HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + "/vendor/register"))
                .header("Content-Type", "application/json")
                .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                .build();
                
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
                
            System.out.println("Response Status: " + response.statusCode());
            System.out.println("Response Body: " + response.body());
            
        } catch (Exception e) {
            System.err.println("Registration failed: " + e.getMessage());
        }
    }
    
    /**
     * Login vendor and get authentication token
     */
    private static void loginVendor(Scanner scanner) {
        System.out.println("\n=== Vendor Login ===");
        
        System.out.print("Email: ");
        String email = scanner.nextLine();
        
        System.out.print("Password: ");
        String password = scanner.nextLine();
        
        String jsonBody = String.format("""
            {
                "email": "%s",
                "password": "%s"
            }
            """, email, password);
            
        try {
            HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + "/vendor/login"))
                .header("Content-Type", "application/json")
                .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                .build();
                
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
                
            System.out.println("Response Status: " + response.statusCode());
            System.out.println("Response Body: " + response.body());
            
            // Extract token from response (you might want to use JSON parsing)
            if (response.statusCode() == 200) {
                String responseBody = response.body();
                // Simple token extraction - in production, use proper JSON parsing
                if (responseBody.contains("\"token\":")) {
                    int tokenStart = responseBody.indexOf("\"token\":\"") + 9;
                    int tokenEnd = responseBody.indexOf("\"", tokenStart);
                    authToken = responseBody.substring(tokenStart, tokenEnd);
                    System.out.println("Authentication token saved successfully!");
                }
            }
            
        } catch (Exception e) {
            System.err.println("Login failed: " + e.getMessage());
        }
    }
    
    /**
     * Get current vendor profile (requires authentication)
     */
    private static void getVendorProfile() {
        if (authToken == null) {
            System.out.println("Please login first to get authentication token.");
            return;
        }
        
        System.out.println("\n=== Vendor Profile ===");
        
        try {
            HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + "/vendor/me"))
                .header("Authorization", "Bearer " + authToken)
                .GET()
                .build();
                
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
                
            System.out.println("Response Status: " + response.statusCode());
            System.out.println("Response Body: " + response.body());
            
        } catch (Exception e) {
            System.err.println("Failed to get profile: " + e.getMessage());
        }
    }
    
    /**
     * Get all products (public endpoint)
     */
    private static void getProducts() {
        System.out.println("\n=== Products ===");
        
        try {
            HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + "/products"))
                .GET()
                .build();
                
            HttpResponse<String> response = client.send(request, 
                HttpResponse.BodyHandlers.ofString());
                
            System.out.println("Response Status: " + response.statusCode());
            System.out.println("Response Body: " + response.body());
            
        } catch (Exception e) {
            System.err.println("Failed to get products: " + e.getMessage());
        }
    }
}

/**
 * Spring Boot Example (if using Spring Framework)
 */
/*
import org.springframework.http.*;
import org.springframework.web.client.RestTemplate;
import org.springframework.stereotype.Service;

@Service
public class VendorApiService {
    private static final String BASE_URL = "http://localhost:8000/api";
    private final RestTemplate restTemplate = new RestTemplate();
    
    public String registerVendor(String businessName, String email, String password) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        
        String jsonBody = String.format("""
            {
                "business_name": "%s",
                "email": "%s",
                "password": "%s",
                "phone": "+256700000000",
                "address": "Kampala, Uganda"
            }
            """, businessName, email, password);
        
        HttpEntity<String> entity = new HttpEntity<>(jsonBody, headers);
        
        ResponseEntity<String> response = restTemplate.exchange(
            BASE_URL + "/vendor/register",
            HttpMethod.POST,
            entity,
            String.class
        );
        
        return response.getBody();
    }
    
    public String loginVendor(String email, String password) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        
        String jsonBody = String.format("""
            {
                "email": "%s",
                "password": "%s"
            }
            """, email, password);
        
        HttpEntity<String> entity = new HttpEntity<>(jsonBody, headers);
        
        ResponseEntity<String> response = restTemplate.exchange(
            BASE_URL + "/vendor/login",
            HttpMethod.POST,
            entity,
            String.class
        );
        
        return response.getBody();
    }
    
    public String getVendorProfile(String token) {
        HttpHeaders headers = new HttpHeaders();
        headers.setBearerAuth(token);
        
        HttpEntity<String> entity = new HttpEntity<>(headers);
        
        ResponseEntity<String> response = restTemplate.exchange(
            BASE_URL + "/vendor/me",
            HttpMethod.GET,
            entity,
            String.class
        );
        
        return response.getBody();
    }
}
*/ 