package com.example.vendorvalidation.model;

public class VendorApplication {
    private String name;
    private double revenue;
    private boolean hasBankruptcy;
    private boolean hasCriminalRecord;
    private boolean hasValidLicense;
    private String email;
    private String extractedText;
    private String feedback;
    private String businessName;
    private String address;
    private String contact;
    private int yearOfEstablishment;
    private double financialPosition;

    public String getName() { return name; }
    public void setName(String name) { this.name = name; }

    public double getRevenue() { return revenue; }
    public void setRevenue(double revenue) { this.revenue = revenue; }

    public boolean isHasBankruptcy() { return hasBankruptcy; }
    public void setHasBankruptcy(boolean hasBankruptcy) { this.hasBankruptcy = hasBankruptcy; }

    public boolean isHasCriminalRecord() { return hasCriminalRecord; }
    public void setHasCriminalRecord(boolean hasCriminalRecord) { this.hasCriminalRecord = hasCriminalRecord; }

    public boolean isHasValidLicense() { return hasValidLicense; }
    public void setHasValidLicense(boolean hasValidLicense) { this.hasValidLicense = hasValidLicense; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }

    public String getExtractedText() { return extractedText; }
    public void setExtractedText(String extractedText) { this.extractedText = extractedText; }

    public String getFeedback() { return feedback; }
    public void setFeedback(String feedback) { this.feedback = feedback; }

    public String getBusinessName() { return businessName; }
    public void setBusinessName(String businessName) { this.businessName = businessName; }

    public String getAddress() { return address; }
    public void setAddress(String address) { this.address = address; }

    public String getContact() { return contact; }
    public void setContact(String contact) { this.contact = contact; }

    public int getYearOfEstablishment() { return yearOfEstablishment; }
    public void setYearOfEstablishment(int yearOfEstablishment) { this.yearOfEstablishment = yearOfEstablishment; }

    public double getFinancialPosition() { return financialPosition; }
    public void setFinancialPosition(double financialPosition) { this.financialPosition = financialPosition; }
} 