package com.example.vendorvalidation.controller;

import com.example.vendorvalidation.model.VendorApplication;
import com.example.vendorvalidation.service.ApplicationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

@RestController
@RequestMapping("/api")
@CrossOrigin(origins = "*")
public class ApplicationController {
    @Autowired
    private ApplicationService service;

    @GetMapping("/test")
    public ResponseEntity<String> test() {
        return ResponseEntity.ok("API is working! Server is running.");
    }

    @PostMapping("/apply")
    public ResponseEntity<String> uploadApplication(
            @RequestParam("application") MultipartFile application,
            @RequestParam("complianceCertificate") MultipartFile complianceCertificate,
            @RequestParam("bankStatement") MultipartFile bankStatement,
            @RequestParam("email") String email) {
        System.out.println("Received POST request to /api/apply");
        System.out.println("Application file: " + application.getOriginalFilename());
        System.out.println("Compliance Certificate: " + complianceCertificate.getOriginalFilename());
        System.out.println("Bank Statement: " + bankStatement.getOriginalFilename());
        System.out.println("Vendor email: " + email);

        if (application.isEmpty() || complianceCertificate.isEmpty() || bankStatement.isEmpty() || email == null || email.isEmpty()) {
            return ResponseEntity.badRequest().body("All three files and email are required.");
        }
        
        // Check file types for all three files
        String appFilename = application.getOriginalFilename().toLowerCase();
        String complianceFilename = complianceCertificate.getOriginalFilename().toLowerCase();
        String bankFilename = bankStatement.getOriginalFilename().toLowerCase();
        
        if (!appFilename.endsWith(".pdf") && !appFilename.endsWith(".docx")) {
            return ResponseEntity.badRequest().body("Unsupported file type for application. Only PDF and DOCX are allowed. Received: " + application.getOriginalFilename());
        }
        if (!complianceFilename.endsWith(".pdf") && !complianceFilename.endsWith(".docx")) {
            return ResponseEntity.badRequest().body("Unsupported file type for compliance certificate. Only PDF and DOCX are allowed. Received: " + complianceCertificate.getOriginalFilename());
        }
        if (!bankFilename.endsWith(".pdf") && !bankFilename.endsWith(".docx")) {
            return ResponseEntity.badRequest().body("Unsupported file type for bank statement. Only PDF and DOCX are allowed. Received: " + bankStatement.getOriginalFilename());
        }
        
        try {
            // Extract text from all three files
            String applicationText = service.extractTextFromFile(application);
            String complianceText = service.extractTextFromFile(complianceCertificate);
            String bankText = service.extractTextFromFile(bankStatement);
            
            // Analyze each document
            String applicationFeedback = service.analyzeText(applicationText);
            String complianceFeedback = service.analyzeComplianceCertificate(complianceText);
            
            // Create combined feedback
            StringBuilder combinedFeedback = new StringBuilder();
            combinedFeedback.append("Application Form: ").append(applicationFeedback).append("\n");
            combinedFeedback.append("Compliance Certificate: ").append(complianceFeedback).append("\n");
            combinedFeedback.append("Bank Statement: Processed successfully.");
            
            // Check if all validations pass
            boolean applicationPassed = applicationFeedback.contains("looks good");
            boolean compliancePassed = complianceFeedback.contains("meets all requirements");
            
            VendorApplication app = new VendorApplication();
            app.setEmail(email);
            app.setExtractedText(applicationText);
            app.setFeedback(combinedFeedback.toString());
            
            if (applicationPassed && compliancePassed) {
                service.scheduleVisit(app);
                service.sendEmail(email, "Application Status", "Congratulations! Your application passed. A visit has been scheduled.");
                // Send notification to company
                System.out.println("Sending approval notification to company...");
                service.sendEmail("uptrendclothing09@gmail.com", "New Vendor Application - Approved", 
                    "A new vendor application has been approved:\n\n" +
                    "Vendor Email: " + email + "\n" +
                    "Application Status: Approved\n" +
                    "Feedback: " + combinedFeedback.toString());
                System.out.println("Company notification sent for approved application.");
                return ResponseEntity.ok("Application passed. Visit scheduled. Feedback: " + combinedFeedback.toString());
            } else {
                service.sendEmail(email, "Application Status", "We regret to inform you that your application did not pass validation. Feedback: " + combinedFeedback.toString());
                // Send notification to company
                System.out.println("Sending rejection notification to company...");
                service.sendEmail("uptrendclothing09@gmail.com", "New Vendor Application - Rejected", 
                    "A new vendor application was received but rejected:\n\n" +
                    "Vendor Email: " + email + "\n" +
                    "Application Status: Rejected\n" +
                    "Feedback: " + combinedFeedback.toString());
                System.out.println("Company notification sent for rejected application.");
                return ResponseEntity.badRequest().body("Application failed validation. Feedback: " + combinedFeedback.toString());
            }
        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
            e.printStackTrace();
            return ResponseEntity.status(500).body("Error processing application: " + e.getMessage());
        }
    }

    @PostMapping("/vendor/register")
    public ResponseEntity<?> registerVendor(
            @RequestParam("businessName") String businessName,
            @RequestParam("address") String address,
            @RequestParam("contact") String contact,
            @RequestParam("email") String email,
            @RequestParam("yearOfEstablishment") int yearOfEstablishment,
            @RequestParam("applicationForm") MultipartFile applicationForm,
            @RequestParam("complianceCertificate") MultipartFile complianceCertificate,
            @RequestParam("bankStatement") MultipartFile bankStatement,
            @RequestParam("password") String password) {
        try {
            VendorApplication app = service.registerVendor(businessName, address, contact, email, yearOfEstablishment,
                    applicationForm, complianceCertificate, bankStatement, password);
            
            // Check financial position
            if (app.getFinancialPosition() < 10000000) {
                // Send rejection email to vendor
                service.sendEmail(email, "Application Status - Rejected", 
                    "Dear " + businessName + ",\n\nYour vendor application has been received but was rejected due to insufficient financial position.\n\n" +
                    "Required: UGX 10,000,000\nYour position: UGX " + app.getFinancialPosition() + "\n\nPlease ensure your financial position meets the minimum requirement before reapplying.");
                
                                // Send notification to company
                service.sendEmail("uptrendclothing09@gmail.com", "New Vendor Application - Rejected",
                    "A new vendor application was received but rejected:\n\n" +
                    "Business: " + businessName + "\nEmail: " + email + "\nContact: " + contact + "\n" +
                    "Reason: Insufficient financial position (UGX " + app.getFinancialPosition() + ")");
                
                return ResponseEntity.badRequest().body("Financial position must be greater than UGX 10,000,000. Yours: UGX " + app.getFinancialPosition());
            }
            
            // Check compliance requirements
            String complianceFeedback = app.getFeedback();
            if (!complianceFeedback.contains("meets all requirements")) {
                // Send rejection email to vendor
                service.sendEmail(email, "Application Status - Rejected", 
                    "Dear " + businessName + ",\n\nYour vendor application has been received but was rejected due to compliance issues.\n\n" +
                    "Compliance Issues:\n" + complianceFeedback + "\n\nPlease ensure your compliance certificate meets all requirements before reapplying.");
                
                                // Send notification to company
                service.sendEmail("uptrendclothing09@gmail.com", "New Vendor Application - Rejected",
                    "A new vendor application was received but rejected:\n\n" +
                    "Business: " + businessName + "\nEmail: " + email + "\nContact: " + contact + "\n" +
                    "Reason: Compliance certificate issues - " + complianceFeedback);
                
                return ResponseEntity.badRequest().body("Compliance certificate issues: " + complianceFeedback);
            }
            
            // Application approved - send success emails
            service.sendEmail(email, "Application Status - Approved", 
                "Dear " + businessName + ",\n\nCongratulations! Your vendor application has been approved.\n\n" +
                "Application Details:\n" +
                "- Business Name: " + businessName + "\n" +
                "- Financial Position: UGX " + app.getFinancialPosition() + "\n" +
                "- Compliance Status: All requirements met\n\n" +
                "You will receive further instructions for onboarding shortly.");
            
                        // Send notification to company
            service.sendEmail("uptrendclothing09@gmail.com", "New Vendor Application - Approved",
                "A new vendor application has been approved:\n\n" +
                "Business: " + businessName + "\nEmail: " + email + "\nContact: " + contact + "\n" +
                "Address: " + address + "\nYear Established: " + yearOfEstablishment + "\n" +
                "Financial Position: UGX " + app.getFinancialPosition() + "\n" +
                "Compliance Status: All requirements met");
            
            return ResponseEntity.ok().body(new java.util.HashMap<String, Object>() {{
                put("financialPosition", app.getFinancialPosition());
                put("complianceFeedback", complianceFeedback);
                put("message", "Registration successful. All compliance requirements met. Check your email for confirmation.");
            }});
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error processing registration: " + e.getMessage());
        }
    }
} 