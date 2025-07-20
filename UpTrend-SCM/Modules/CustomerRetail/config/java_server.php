<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Java Server Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the Java validation server
    | that handles vendor validation criteria.
    |
    */

    'url' => env('SPRING_API_URL', 'http://localhost:8080/api') . '/validate-vendor',
    
    'timeout' => env('JAVA_SERVER_TIMEOUT', 30),
    
    'enabled' => env('JAVA_SERVER_ENABLED', true),
    
    /*
    |--------------------------------------------------------------------------
    | Validation Settings
    |--------------------------------------------------------------------------
    |
    | Configure validation behavior when Java server is unavailable
    |
    */
    
    'continue_on_failure' => env('JAVA_SERVER_CONTINUE_ON_FAILURE', true),
    
    'log_errors' => env('JAVA_SERVER_LOG_ERRORS', true),
    
    /*
    |--------------------------------------------------------------------------
    | Expected Response Format
    |--------------------------------------------------------------------------
    |
    | The expected response format from the Java server
    |
    */
    
    'expected_response' => [
        'success' => 'boolean',
        'message' => 'string',
        'errors' => 'array',
        'data' => 'array|object|null',
    ],
]; 