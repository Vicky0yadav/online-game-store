<?php
// Function to perform the OpenFDA API request
function performOpenFDASearch($searchQuery) {
    // Specify the OpenFDA API endpoint for drug labels
    $apiEndpoint = 'https://api.fda.gov/drug/label.json';
    

    // Define query parameters including the search query
    $queryParameters = [
        'limit' => 2,
        'search' => $searchQuery,
    ];

    // Construct the API URL with query parameters
    $apiUrl = $apiEndpoint . '?' . http_build_query($queryParameters);

    // Make the API request
    $response = file_get_contents($apiUrl);

    // Check if the request was successful
    if ($response !== false) {
        // Decode JSON response
        $searchResults = json_decode($response, true);

        // Check if decoding was successful
        if ($searchResults === null && json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Error decoding OpenFDA JSON data: ' . json_last_error_msg()];
        }

        return $searchResults;
    } else {
        return ['error' => 'Error accessing OpenFDA API'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search query from the form
    $searchQuery = $_POST['search_query'];

    // Perform the OpenFDA search
    $searchResults = performOpenFDASearch($searchQuery);

    // Display the search results or an error message
    if (isset($searchResults['error'])) {
        echo '<p>Error: ' . htmlspecialchars($searchResults['error']) . '</p>';
    } else {
        // Display search results
        echo '<h3>Search Results:</h3>';
        foreach ($searchResults['results'] as $result) {
            echo '<strong>Drug Name:</strong> ' . $result['openfda']['generic_name'][0] . '<br>';
            echo '<strong>Manufacturer:</strong> ' . $result['openfda']['manufacturer_name'][0] . '<br>';
            echo '<strong>Indications and Usage:</strong> ' . $result['indications_and_usage'][0] . '<br>';
            echo '<strong>Warnings:</strong> ' . $result['warnings'][0] . '<br>';
            echo '<br>';
        }
    }
}
?>