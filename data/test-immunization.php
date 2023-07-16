<?php
// Read the JSON data from the file
$data = file_get_contents('immunization.json');

// Decode the JSON data
$immunizations = json_decode($data, true);

// Get the immunization ID from the URL
$immunization_id = $_GET['id'];

// Find the immunization record with the matching ID
$immunization = null;
foreach ($immunizations as $record) {
    if ($record['identifier'] == $immunization_id) {
        $immunization = $record;
        break;
    }
}

// Display the immunization record
if ($immunization) {
    echo "<h2>Immunization record for ID $immunization_id:</h2>";
    echo "<ul>";
    echo "<li>Patient: {$immunization['patient']}</li>";
    echo "<li>Vaccine Code: {$immunization['vaccineCode']}</li>";
    echo "<li>Status: {$immunization['status']}</li>";
    echo "<li>Date: {$immunization['occurrenceDateTime']}</li>";
    echo "</ul>";
} else {
    echo "<p>No immunization record found for ID $immunization_id</p>";
}
?>
