package com.example.vendorvalidation.service;

import com.example.vendorvalidation.model.VendorApplication;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.apache.poi.xwpf.usermodel.XWPFDocument;
import org.apache.poi.xwpf.extractor.XWPFWordExtractor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.UUID;
import java.security.SecureRandom;

@Service
public class ApplicationService {
    @Autowired
    private JavaMailSender mailSender;

    public VendorApplication parsePdf(MultipartFile file) throws IOException {
        PDDocument document = PDDocument.load(file.getInputStream());
        String text = new PDFTextStripper().getText(document);
        document.close();
        VendorApplication app = new VendorApplication();
        app.setExtractedText(text);
        // Dummy parsing logic (replace with real extraction)
        app.setName("Demo Vendor");
        app.setRevenue(150000);
        app.setHasBankruptcy(false);
        app.setHasCriminalRecord(false);
        app.setHasValidLicense(true);
        return app;
    }

    public VendorApplication parseDocx(MultipartFile file) throws IOException {
        XWPFDocument docx = new XWPFDocument(file.getInputStream());
        XWPFWordExtractor extractor = new XWPFWordExtractor(docx);
        String text = extractor.getText();
        docx.close();
        VendorApplication app = new VendorApplication();
        app.setExtractedText(text);
        // Dummy parsing logic (replace with real extraction)
        app.setName("Demo Vendor");
        app.setRevenue(150000);
        app.setHasBankruptcy(false);
        app.setHasCriminalRecord(false);
        app.setHasValidLicense(true);
        return app;
    }

    public String analyzeText(String text) {
        // Simple analysis: check for keywords and length
        if (text == null || text.isEmpty()) {
            return "Document is empty.";
        }
        StringBuilder feedback = new StringBuilder();
        if (text.length() < 100) {
            feedback.append("Document is too short. ");
        }
        if (!text.toLowerCase().contains("vendor")) {
            feedback.append("Missing keyword: vendor. ");
        }
        if (feedback.length() == 0) {
            feedback.append("Document looks good.");
        }
        return feedback.toString();
    }

    public String analyzeComplianceCertificate(String text) {
        if (text == null || text.isEmpty()) {
            return "Compliance certificate is empty.";
        }
        StringBuilder feedback = new StringBuilder();
        String lowerText = text.toLowerCase();
        
        // Check for compliance keyword
        if (!lowerText.contains("compliance")) {
            feedback.append("Missing keyword: compliance. ");
        }
        
        // Check for state compliance
        if (!lowerText.contains("state compliance") && !lowerText.contains("state regulation")) {
            feedback.append("Missing state compliance requirements. ");
        }
        
        // Check for URSB (Uganda Registration Services Bureau)
        if (!lowerText.contains("ursb") && !lowerText.contains("uganda registration services bureau")) {
            feedback.append("Missing URSB registration. ");
        }
        
        // Check for industrial guidelines
        if (!lowerText.contains("industrial guideline") && !lowerText.contains("industrial standard") && 
            !lowerText.contains("industry guideline") && !lowerText.contains("industry standard")) {
            feedback.append("Missing industrial guidelines compliance. ");
        }
        
        if (feedback.length() == 0) {
            feedback.append("Compliance certificate meets all requirements.");
        }
        return feedback.toString();
    }

    public boolean validate(VendorApplication app) {
        String feedback = analyzeText(app.getExtractedText());
        app.setFeedback(feedback);
        return feedback.contains("looks good");
    }

    public void scheduleVisit(VendorApplication app) {
        System.out.println("Visit scheduled for: " + app.getName());
    }

    public void sendEmail(String to, String subject, String body) {
        if (to == null || to.isEmpty() || subject == null || subject.isEmpty() || body == null || body.isEmpty()) {
            System.out.println("Email not sent: missing to, subject, or body.");
            return;
        }
        try {
            SimpleMailMessage message = new SimpleMailMessage();
            message.setTo(to);
            message.setSubject(subject);
            message.setText(body);
            message.setFrom("uptrendclothing09@gmail.com"); // Use your actual Gmail address
            mailSender.send(message);
            System.out.println("Sent email to: " + to + " | Subject: " + subject);
        } catch (Exception e) {
            System.out.println("Error sending email to " + to + ": " + e.getMessage());
            e.printStackTrace();
        }
    }

    public VendorApplication registerVendor(String businessName, String address, String contact, String email, int yearOfEstablishment,
                                           MultipartFile applicationForm, MultipartFile complianceCertificate, MultipartFile bankStatement, String password) throws IOException {
        VendorApplication app = new VendorApplication();
        app.setBusinessName(businessName);
        app.setAddress(address);
        app.setContact(contact);
        app.setEmail(email);
        app.setYearOfEstablishment(yearOfEstablishment);
        // app.setPassword(password); // Uncomment if you want to store the password
        
        // Extract and analyze compliance certificate
        String complianceText = extractTextFromFile(complianceCertificate);
        String complianceFeedback = analyzeComplianceCertificate(complianceText);
        
        double financialPosition = extractFinancialPosition(bankStatement);
        app.setFinancialPosition(financialPosition);
        app.setName(businessName);
        app.setExtractedText(complianceText);
        app.setFeedback(complianceFeedback);
        return app;
    }

    public String extractTextFromFile(MultipartFile file) throws IOException {
        String filename = file.getOriginalFilename().toLowerCase();
        System.out.println("Processing file: " + filename + ", Size: " + file.getSize() + " bytes");
        
        try {
            if (filename.endsWith(".pdf")) {
                System.out.println("Attempting to parse PDF file...");
                PDDocument document = PDDocument.load(file.getInputStream());
                String text = new PDFTextStripper().getText(document);
                document.close();
                System.out.println("PDF parsed successfully. Text length: " + text.length());
                return text;
            } else if (filename.endsWith(".docx")) {
                System.out.println("Attempting to parse DOCX file...");
                XWPFDocument docx = new XWPFDocument(file.getInputStream());
                XWPFWordExtractor extractor = new XWPFWordExtractor(docx);
                String text = extractor.getText();
                docx.close();
                System.out.println("DOCX parsed successfully. Text length: " + text.length());
                return text;
            } else if (filename.endsWith(".txt")) {
                System.out.println("Processing text file...");
                String text = new String(file.getInputStream().readAllBytes(), "UTF-8");
                System.out.println("Text file processed. Text length: " + text.length());
                return text;
            } else {
                System.out.println("Unsupported file type: " + filename);
                return ""; // For unsupported file types
            }
        } catch (Exception e) {
            System.out.println("Error processing file " + filename + ": " + e.getMessage());
            // If PDF parsing fails, return a message indicating the issue
            if (filename.endsWith(".pdf")) {
                return "Error: Invalid or corrupted PDF file. Please ensure the file is a valid PDF document. File size: " + file.getSize() + " bytes. Error: " + e.getMessage();
            }
            throw new IOException("Error processing file " + filename + ": " + e.getMessage(), e);
        }
    }

    private double extractFinancialPosition(MultipartFile bankStatement) {
        // Simulate extraction. In real code, parse the file and extract the value.
        // For now, always return 15,000,000
        return 15000000;
    }
} 