<?php
// Specify the OpenFDA API endpoint for drug labels
$apiEndpoint = 'https://api.fda.gov/drug/label.json';

// Initialize variables to store search query and results
$searchQuery = '';
$searchResults = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search query from the form
    $searchQuery = $_POST['search_query'];

    // Define query parameters including the search query
    $queryParameters = [
        'limit' => 10,
        'search' => $searchQuery,
    ];

    // Construct the API URL with query parameters
    $apiUrl = $apiEndpoint . '?' . http_build_query($queryParameters);

    // Make the API request with error handling
    $context = stream_context_create(['http' => ['ignore_errors' => true]]);
    $response = file_get_contents($apiUrl, false, $context);

    // Check for HTTP errors
    if ($response === false) {
        die('Error accessing OpenFDA API');
    }

    // Decode JSON response
    $searchResults = json_decode($response, true);

    // Check if decoding was successful
    if ($searchResults === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding OpenFDA JSON data: ' . json_last_error_msg());
    }
}

// Function to get field value safely
function getFieldValue($result, $field) {
    return isset($result[$field]) ? $result[$field][0] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenFDA Search</title>
</head>
<body>
    <h2>OpenFDA Search</h2>
    <form action="" method="post">
        <label for="search_query">Enter Search Query:</label>
        <input type="text" id="search_query" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Display search results
    if (!empty($searchResults['results'])) {
        echo '<h3>Search Results:</h3>';
        foreach ($searchResults['results'] as $result) {
            echo '<strong>Drug Name:</strong> ' . getFieldValue($result, 'generic_name') . '<br>';
            echo '<strong>Manufacturer:</strong> ' . getFieldValue($result, 'manufacturer_name') . '<br>';
            echo '<strong>Indications and Usage:</strong> ' . nl2br(getFieldValue($result, 'indications_and_usage')) . '<br>';
            echo '<strong>Warnings:</strong> ' . nl2br(getFieldValue($result, 'warnings')) . '<br>';
            echo '<br>';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p>No results found for the given search query.</p>';
    }
    ?>
</body>
</html>
