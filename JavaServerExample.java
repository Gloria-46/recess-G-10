import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;
import org.springframework.http.HttpStatus;
import java.util.*;

/**
 * Example Java Server for Vendor Validation
 * 
 * Your existing Java server should implement an endpoint similar to this
 * that validates vendor registration criteria.
 */
@SpringBootApplication
@RestController
@RequestMapping("/api")
public class JavaServerExample {

    public static void main(String[] args) {
        SpringApplication.run(JavaServerExample.class, args);
    }

    /**
     * Validate vendor registration data
     * 
     * Expected request format:
     * {
     *   "business_name": "Fashion Store Ltd",
     *   "email": "vendor@example.com",
     *   "phone": "+256700000000",
     *   "address": "Kampala, Uganda",
     *   "year_of_establishment": 2020,
     *   "contact": "+256700000000"
     * }
     * 
     * Expected response format:
     * {
     *   "success": true/false,
     *   "message": "Validation message",
     *   "errors": ["error1", "error2"],
     *   "data": {
     *     "validation_score": 85,
     *     "risk_level": "low",
     *     "recommendations": ["recommendation1", "recommendation2"]
     *   }
     * }
     */
    @PostMapping("/validate-vendor")
    public ResponseEntity<Map<String, Object>> validateVendor(@RequestBody Map<String, Object> vendorData) {
        Map<String, Object> response = new HashMap<>();
        List<String> errors = new ArrayList<>();
        
        try {
            // Extract vendor data
            String businessName = (String) vendorData.get("business_name");
            String email = (String) vendorData.get("email");
            String phone = (String) vendorData.get("phone");
            String address = (String) vendorData.get("address");
            Integer yearOfEstablishment = (Integer) vendorData.get("year_of_establishment");
            String contact = (String) vendorData.get("contact");
            
            // Your validation logic goes here
            // This is where you implement your specific validation criteria
            
            // Example validation rules:
            
            // 1. Business name validation
            if (businessName == null || businessName.trim().length() < 3) {
                errors.add("Business name must be at least 3 characters long");
            }
            
            // 2. Email validation
            if (email == null || !email.contains("@")) {
                errors.add("Invalid email format");
            }
            
            // 3. Phone number validation (Uganda format)
            if (phone != null && !phone.matches("^\\+256\\d{9}$")) {
                errors.add("Phone number must be in Uganda format (+256XXXXXXXXX)");
            }
            
            // 4. Year of establishment validation
            if (yearOfEstablishment != null && (yearOfEstablishment < 1900 || yearOfEstablishment > 2025)) {
                errors.add("Year of establishment must be between 1900 and 2025");
            }
            
            // 5. Address validation
            if (address == null || address.trim().length() < 10) {
                errors.add("Address must be at least 10 characters long");
            }
            
            // 6. Business credibility check (example)
            if (businessName != null && businessName.toLowerCase().contains("test")) {
                errors.add("Business name appears to be a test entry");
            }
            
            // 7. Email domain validation (example)
            if (email != null && email.endsWith("@example.com")) {
                errors.add("Please use a valid business email address");
            }
            
            // 8. Duplicate business name check (example)
            if (businessName != null && isDuplicateBusinessName(businessName)) {
                errors.add("Business name already exists in our system");
            }
            
            // 9. Financial stability check (example)
            if (yearOfEstablishment != null && yearOfEstablishment < 2020) {
                // Additional checks for older businesses
                if (!hasValidFinancialHistory(businessName)) {
                    errors.add("Unable to verify financial history for this business");
                }
            }
            
            // 10. Location validation (example)
            if (address != null && !isValidLocation(address)) {
                errors.add("Business address appears to be invalid");
            }
            
            // Determine validation result
            boolean isValid = errors.isEmpty();
            
            // Calculate validation score
            int validationScore = calculateValidationScore(vendorData);
            
            // Determine risk level
            String riskLevel = determineRiskLevel(validationScore);
            
            // Generate recommendations
            List<String> recommendations = generateRecommendations(vendorData, validationScore);
            
            // Build response
            response.put("success", isValid);
            response.put("message", isValid ? "Vendor validation successful" : "Vendor validation failed");
            response.put("errors", errors);
            
            Map<String, Object> data = new HashMap<>();
            data.put("validation_score", validationScore);
            data.put("risk_level", riskLevel);
            data.put("recommendations", recommendations);
            data.put("business_name", businessName);
            data.put("email", email);
            data.put("validation_timestamp", System.currentTimeMillis());
            
            response.put("data", data);
            
            return ResponseEntity.ok(response);
            
        } catch (Exception e) {
            response.put("success", false);
            response.put("message", "Validation server error: " + e.getMessage());
            response.put("errors", Arrays.asList("Internal server error"));
            response.put("data", null);
            
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(response);
        }
    }
    
    /**
     * Example helper methods for validation
     */
    
    private boolean isDuplicateBusinessName(String businessName) {
        // Implement your duplicate checking logic
        // This could involve database queries, external API calls, etc.
        return false; // Placeholder
    }
    
    private boolean hasValidFinancialHistory(String businessName) {
        // Implement financial history validation
        // This could involve credit checks, business registry queries, etc.
        return true; // Placeholder
    }
    
    private boolean isValidLocation(String address) {
        // Implement address validation
        // This could involve geocoding, address verification services, etc.
        return address != null && address.length() > 5; // Placeholder
    }
    
    private int calculateValidationScore(Map<String, Object> vendorData) {
        int score = 100;
        
        // Deduct points for various validation issues
        String businessName = (String) vendorData.get("business_name");
        String email = (String) vendorData.get("email");
        String phone = (String) vendorData.get("phone");
        Integer yearOfEstablishment = (Integer) vendorData.get("year_of_establishment");
        
        if (businessName == null || businessName.trim().length() < 5) {
            score -= 10;
        }
        
        if (email == null || !email.contains("@")) {
            score -= 15;
        }
        
        if (phone == null || !phone.matches("^\\+256\\d{9}$")) {
            score -= 10;
        }
        
        if (yearOfEstablishment == null || yearOfEstablishment < 2020) {
            score -= 5;
        }
        
        return Math.max(0, score);
    }
    
    private String determineRiskLevel(int validationScore) {
        if (validationScore >= 90) {
            return "low";
        } else if (validationScore >= 70) {
            return "medium";
        } else {
            return "high";
        }
    }
    
    private List<String> generateRecommendations(Map<String, Object> vendorData, int validationScore) {
        List<String> recommendations = new ArrayList<>();
        
        if (validationScore < 90) {
            recommendations.add("Consider providing additional business documentation");
        }
        
        if (validationScore < 80) {
            recommendations.add("Verify your business address and contact information");
        }
        
        if (validationScore < 70) {
            recommendations.add("Contact support for manual verification process");
        }
        
        return recommendations;
    }
    
    /**
     * Health check endpoint
     */
    @GetMapping("/health")
    public ResponseEntity<Map<String, Object>> healthCheck() {
        Map<String, Object> response = new HashMap<>();
        response.put("status", "healthy");
        response.put("service", "vendor-validation");
        response.put("timestamp", System.currentTimeMillis());
        return ResponseEntity.ok(response);
    }
}

/**
 * Alternative implementation using Spring Boot with more detailed validation
 */
/*
@RestController
@RequestMapping("/api/vendor")
public class VendorValidationController {
    
    @Autowired
    private VendorValidationService validationService;
    
    @PostMapping("/validate")
    public ResponseEntity<VendorValidationResponse> validateVendor(@RequestBody VendorValidationRequest request) {
        try {
            VendorValidationResult result = validationService.validateVendor(request);
            return ResponseEntity.ok(new VendorValidationResponse(result));
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR)
                .body(new VendorValidationResponse(false, "Validation error: " + e.getMessage()));
        }
    }
}

@Data
@AllArgsConstructor
public class VendorValidationRequest {
    private String businessName;
    private String email;
    private String phone;
    private String address;
    private Integer yearOfEstablishment;
    private String contact;
}

@Data
@AllArgsConstructor
public class VendorValidationResponse {
    private boolean success;
    private String message;
    private List<String> errors;
    private VendorValidationData data;
    
    public VendorValidationResponse(VendorValidationResult result) {
        this.success = result.isValid();
        this.message = result.getMessage();
        this.errors = result.getErrors();
        this.data = result.getData();
    }
}

@Data
@AllArgsConstructor
public class VendorValidationData {
    private int validationScore;
    private String riskLevel;
    private List<String> recommendations;
    private String businessName;
    private String email;
    private long validationTimestamp;
}
*/ 