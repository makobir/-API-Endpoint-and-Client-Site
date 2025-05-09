🔐 Licensing API Documentation
Overview
This documentation covers:
The API endpoint used to validate licenses.
How to integrate license verification on a client site.
Error handling and sample responses.

🧩 1. API Endpoint (Central Licensing Server)
Endpoint
bash
POST /api/license/verify
Full URL (example):


https://licensing.example.com/api/license/verify
Headers
Header	Value
Content-Type	application/json
Accept	application/json

Request Body
json
{
  "api_key": "your-api-key",
  "license_key": "your-license-key",
  "domain": "clientdomain.com"
}
Response
✅ Success
json
Copy
Edit
{
  "status": "valid",
  "message": "License verified successfully.",
  "expires_at": "2026-01-01"
}
❌ Failure
json
Copy
Edit
{
  "status": "invalid",
  "message": "License key is expired or invalid."
}
HTTP Status Codes
Code	Description
200	License is valid
401	Unauthorized / Invalid
400	Bad Request
429	Too Many Requests (rate limit)
500	Server error

🖥️ 2. Client Site Integration
How It Works
On each page load or periodically, the client site sends a request to the API to verify the license. If verification fails, the site displays a license update message.

Example (PHP - CodeIgniter style)
php
Copy
Edit
function check_license()
{
    $api_url = "https://licensing.example.com/api/license/verify";
    
    $data = [
        'api_key' => 'YOUR_API_KEY',
        'license_key' => 'YOUR_LICENSE_KEY',
        'domain' => $_SERVER['HTTP_HOST']
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($data),
            'timeout' => 5
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);

    if ($result === FALSE) {
        show_error("License check failed. Please try again later.");
    }

    $response = json_decode($result, true);

    if ($response['status'] !== 'valid') {
        echo "<h3>Your license is invalid or expired. Please contact support.</h3>";
        exit;
    }

    // Continue loading the site...
}
Call this function in a constructor or a hook to ensure license validation before loading any content.

Security Tips
Use HTTPS for all requests.

Never expose the license key or API key to client-side JavaScript.

Set rate limits on your API to prevent abuse.

Log all license requests and failures for audit.
