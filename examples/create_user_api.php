<?php

declare(strict_types=1);

// Example contract only. Replace the endpoint and payload with values from the project OpenAPI spec.
// Run only against an authorized test environment.

$baseUrl = rtrim((string) getenv('API_BASE_URL'), '/');
$token = (string) getenv('API_TOKEN');

if ($baseUrl === '' || $token === '') {
    throw new RuntimeException('Set API_BASE_URL and API_TOKEN for the API example.');
}

$payload = [
    'email' => 'aqa.user@example.test',
    'password' => 'TestPassword123!',
    'firstName' => 'AQA',
    'lastName' => 'User',
];

$curl = curl_init($baseUrl . '/api/users');
if ($curl === false) {
    throw new RuntimeException('Could not initialize cURL.');
}

curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
    ],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_THROW_ON_ERROR),
]);

$responseBody = curl_exec($curl);
if ($responseBody === false) {
    $error = curl_error($curl);
    curl_close($curl);
    throw new RuntimeException('API request failed: ' . $error);
}

$statusCode = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

if ($statusCode !== 201) {
    throw new RuntimeException(sprintf('Expected HTTP 201, received HTTP %d: %s', $statusCode, $responseBody));
}

$response = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
if (!is_array($response) || !isset($response['id'], $response['email'])) {
    throw new RuntimeException('Expected JSON response containing id and email.');
}

if ($response['email'] !== $payload['email']) {
    throw new RuntimeException('The response email does not match the request.');
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL;
