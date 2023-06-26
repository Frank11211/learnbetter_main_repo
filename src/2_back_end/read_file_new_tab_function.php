<?php

    include "../3_database/db_connection.php";

    // Get the file ID from the query string
    $file_id = $_GET['file_id'];

    // Prepare the SQL statement using a parameterized query
    $sql_query = "SELECT upload_file FROM learnbetter_upload WHERE id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("s", $file_id);
    $stmt->execute();
    $stmt->bind_result($upload_file);
    $stmt->fetch();
    $stmt->close();

    // Retrieve the file data from the database based on the file ID
    $query = "SELECT upload_file FROM learnbetter_upload WHERE id = $file_id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $file_data = $row['upload_file'];

    // Extract the file name and file extension from the file data
    $file_info = pathinfo($file_data);
    $file_name = $file_info['basename'];
    $file_extension = strtolower($file_info['extension']);

    // Replace spaces with underscores in the file name
    $file_name = str_replace(' ', '_', $file_name);

    // Define an array of supported file extensions
    $supported_extensions = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'wps');

    // Check if the file extension is supported
    if (in_array($file_extension, $supported_extensions)) {
        // Determine the Content-Type based on the file extension
        if ($file_extension === 'pdf') {
            $content_type = 'application/pdf';
        } elseif ($file_extension === 'doc' || $file_extension === 'docx') {
            $content_type = 'application/msword';
        } elseif ($file_extension === 'xls' || $file_extension === 'xlsx') {
            $content_type = 'application/vnd.ms-excel';
        }

        // Set the Content-Type header
        header('Content-Type: ' . $content_type);
        // Set the Content-Disposition header to open the file in the browser
        header('Content-Disposition: inline; filename="' . $file_name . '"');
        header('Accept-Ranges: bytes');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Enconding: binary');


        // Output the file data
        echo $file_data;
    } else {
        // Handle error or show appropriate message
        echo 'Invalid file type. Only PDF, Word, and Excel files are supported.';
    }

?>
