# Java Server Integration Guide

## Overview
Your Laravel application now includes integration with your Java validation server during the vendor registration process. The system will call your Java server to validate vendor criteria before completing the registration.

## Configuration

### 1. Environment Variables
Add these to your `.env` file:

```env
# Spring API Configuration
SPRING_API_URL=http://localhost:8080/api
JAVA_SERVER_TIMEOUT=30
JAVA_SERVER_ENABLED=true
JAVA_SERVER_CONTINUE_ON_FAILURE=true
JAVA_SERVER_LOG_ERRORS=true
```

### 2. Update Spring API URL
Replace `http://localhost:8080/api` with your actual Spring API URL.

## Expected Java Server API

Your Java server should implement an endpoint that accepts POST requests with the following format:

### Request Format
```json
{
    "business_name": "Fashion Store Ltd",
    "email": "vendor@example.com",
    "phone": "+256700000000",
    "address": "Kampala, Uganda",
    "year_of_establishment": 2020,
    "contact": "+256700000000"
}
```

### Expected Response Format
```json
{
    "success": true,
    "message": "Vendor validation successful",
    "errors": [],
    "data": {
        "validation_score": 85,
        "risk_level": "low",
        "recommendations": [
            "Consider providing additional business documentation"
        ],
        "business_name": "Fashion Store Ltd",
        "email": "vendor@example.com",
        "validation_timestamp": 1642234567890
    }
}
```

### Error Response Format
```json
{
    "success": false,
    "message": "Vendor validation failed",
    "errors": [
        "Business name must be at least 3 characters long",
        "Phone number must be in Uganda format (+256XXXXXXXXX)"
    ],
    "data": null
}
```

## Integration Points

### 1. API Registration
When a vendor registers via the API (`POST /api/vendor/register`), the system will:
1. Validate basic Laravel validation rules
2. Call your Java server for additional validation
3. Only create the vendor if both validations pass

### 2. Web Registration
When a vendor registers via the web form, the system will:
1. Validate form data
2. Call your Java server for validation
3. Show validation errors if any
4. Complete registration only if validation passes

## Error Handling

The system is designed to be resilient:

- **Java server unavailable**: Registration continues with a warning
- **Java server timeout**: Registration continues with a warning
- **Java server error**: Registration continues with a warning
- **Validation failed**: Registration is blocked with specific error messages

## Testing the Integration

### 1. Test with cURL
```bash
# Test vendor registration with Java validation
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

### 2. Test Java Server Directly
```bash
# Test your Java server directly
curl -X POST http://your-java-server:8080/api/validate-vendor \
  -H "Content-Type: application/json" \
  -d '{
    "business_name": "Test Store",
    "email": "test@example.com",
    "phone": "+256700000000",
    "address": "Kampala, Uganda",
    "year_of_establishment": 2020,
    "contact": "+256700000000"
  }'
```

## Monitoring

### 1. Logs
Check Laravel logs for Java server communication:
```bash
tail -f storage/logs/laravel.log | grep "Java validation"
```

### 2. Health Check
Your Java server should implement a health check endpoint:
```bash
curl http://your-java-server:8080/api/health
```

## Customization

### 1. Modify Validation Logic
Update the `validateWithJavaServer` method in:
- `app/Http/Controllers/Api/VendorController.php` (for API)
- `app/Http/Controllers/Vendor/AuthController.php` (for web)

### 2. Add Custom Validation Rules
In your Java server, implement your specific validation criteria:
- Business name uniqueness
- Financial stability checks
- Address verification
- Credit history validation
- Regulatory compliance checks

### 3. Response Processing
Modify how the Laravel application processes Java server responses in the validation methods.

## Troubleshooting

### Common Issues

1. **Java server not responding**
   - Check if Java server is running
   - Verify the URL in `.env`
   - Check network connectivity

2. **Timeout errors**
   - Increase `JAVA_SERVER_TIMEOUT` in `.env`
   - Optimize your Java server response time

3. **Validation not working**
   - Check Java server logs
   - Verify response format matches expected format
   - Test Java server endpoint directly

### Debug Mode
Enable detailed logging by setting:
```env
JAVA_SERVER_LOG_ERRORS=true
```

## Security Considerations

1. **HTTPS**: Use HTTPS for production communication
2. **Authentication**: Consider adding API keys or tokens
3. **Rate Limiting**: Implement rate limiting on your Java server
4. **Input Validation**: Validate all inputs on both servers
5. **Error Handling**: Don't expose sensitive information in error messages

## Performance Optimization

1. **Caching**: Cache validation results for repeated checks
2. **Async Processing**: Consider async validation for better UX
3. **Connection Pooling**: Use connection pooling for HTTP requests
4. **Timeout Management**: Set appropriate timeouts

## Example Java Server Implementation

See `JavaServerExample.java` for a complete example of how your Java server should implement the validation endpoint.

## Support

For issues with the integration:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Java server logs
3. Test endpoints individually
4. Verify configuration in `.env` file 