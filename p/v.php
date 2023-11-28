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
        'limit' => 1,
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
            die('Error decoding OpenFDA JSON data: ' . json_last_error_msg());
        }
    } else {
        die('Error accessing OpenFDA API');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenFDA Search</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('./photo/c.jpg'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        h2 {
            text-align: center;
            padding: 20px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        label {
            font-size: 18px;
            color: #fff;
        }

        input {
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .search-results {
            text-align: center;
            margin-top: 20px;
        }

        .search-results strong {
            font-size: 16px;
            color: #3498db;
        }
    </style>
</head>
<body>
    <h2> Information About Drugs & Medicines</h2>
    <form action="" method="post">
        <label for="search_query"> Enter Search Query :</label>
        <input type="text" id="search_query" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Display search results
    if (!empty($searchResults['results'])) {
        echo '<div class="search-results">';
        echo '<h3>Search Results:</h3>';
        foreach ($searchResults['results'] as $result) {
         //  echo '<strong>Drug Name:</strong> ' . $result['openfda']['generic_name'][0] . '<br>';
          // echo '<strong>Manufacturer:</strong> ' . $result['openfda']['manufacturer_name'][0] . '<br>';
            echo '<strong>Indications and Usage:</strong> ' . $result['indications_and_usage'][0] . '<br>';
            echo '<strong>Warnings:</strong> ' . (is_array($result['warnings']) ? implode(", ", $result['warnings']) : $result['warnings']) . '<br>';
            
            // Additional Fields
            $additionalFields = [
                'purpose',
                'keep_out_of_reach_of_children',
                'dosage_and_administration',
                'stop_use',
                'storage_and_handling',
                'package_label_principal_display_panel'
            ];

            foreach ($additionalFields as $field) {
                if (isset($result[$field])) {
                    echo '<strong>' . ucwords(str_replace('_', ' ', $field)) . ':</strong> ' . (is_array($result[$field]) ? implode(", ", $result[$field]) : $result[$field]) . '<br>';
                }
            }

            echo '<br>';
        }
        echo '</div>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p>No results found for the given search query.</p>';
    }
    ?>
</body>
</html>
