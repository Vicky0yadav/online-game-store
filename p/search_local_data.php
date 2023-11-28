<?php
// Read FDA JSON data
$jsonData = file_get_contents('./photo/data.json');

// Decode JSON data
$data = json_decode($jsonData, true);

// Check if decoding was successful
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding FDA JSON data: ' . json_last_error_msg());
}

// Initialize variables to store search query and results
$searchQuery = '';
$searchResults = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search query from the form
    $searchQuery = $_POST['search_query'];

    // Perform the search in the local data
    $searchResults = performLocalSearch($data, $searchQuery);
}

function performLocalSearch($data, $searchQuery) {
    $results = [];

    // Perform the search logic here
    foreach ($data['results'] as $result) {
        // Check if the search query matches any condition (modify this as needed)
        if (stripos($result['openfda']['generic_name'][0], $searchQuery) !== false) {
            $results[] = $result;
        }
    }

    return $results;
}

// Initialize variables to store search query and results
$searchQuery = '';
$searchResults = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search query from the form
    $searchQuery = $_POST['search_query'];

    // Read the JSON file line by line and decode incrementally
    $file = fopen('./photo/data.json', 'r');
    $data = [];

    while (!feof($file)) {
        $line = fgets($file);
        $decodedLine = json_decode($line, true);

        // Check if decoding was successful
        if ($decodedLine !== null && json_last_error() === JSON_ERROR_NONE) {
            $data[] = $decodedLine;
        } else {
            // Handle decoding error if needed
            // For example: die('Error decoding JSON data: ' . json_last_error_msg());
        }
    }

    fclose($file);

    // Perform the search in the local data
    $searchResults = performLocalSearch($data, $searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local FDA Data Search</title>
</head>
<body>
    <h2>Local FDA Data Search</h2>
    <form action="" method="post">
        <label for="search_query">Enter Search Query:</label>
        <input type="text" id="search_query" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Display search results
    if (!empty($searchResults)) {
        echo '<h3>Search Results:</h3>';
        foreach ($searchResults as $result) {
            echo '<strong>Drug Name:</strong> ' . $result['openfda']['generic_name'][0] . '<br>';
            // Add more fields as needed
            echo '<br>';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p>No results found for the given search query.</p>';
    }
    ?>
</body>
</html>
