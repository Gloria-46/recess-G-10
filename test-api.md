# Vendor Validation API Test Guide

## Current API Endpoint
- **URL**: `http://localhost:8080/api/apply`
- **Method**: POST
- **Content-Type**: multipart/form-data

## Test Steps

### Using Postman:
1. Open Postman
2. Create new request: **POST** `http://localhost:8080/api/apply`
3. Go to **Body** tab
4. Select **form-data**
5. Add key: `file` (Type: File)
6. Upload any PDF file
7. Click **Send**

### Using curl:
```bash
curl -X POST -F "file=@path/to/your/file.pdf" http://localhost:8080/api/apply
```

## Expected Response
- **Success**: "Application passed. Visit scheduled."
- **Failure**: "Application failed validation."
- **Error**: "Error processing application: [error message]"

## Current Dummy Data (for testing)
- Name: "Demo Vendor"
- Revenue: $150,000
- Bankruptcy: false
- Criminal Record: false
- Valid License: true

**Result**: Should pass validation and schedule a visit. 