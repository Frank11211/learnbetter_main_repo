<?php
    include "../3_database/db_connection.php";
 
    $cur_download_file = null;

    if(isset($_GET['downloaded_file'])) {
        $cur_download_file = $_GET['downloaded_file'];

        // Prepare the SQL statement using a parameterized query
        $sql_query = "SELECT upload_file FROM learnbetter_upload WHERE upload_file = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("s", $cur_download_file);
        $stmt->execute();
        $stmt->bind_result($upload_file);
        $stmt->fetch();
        $stmt->close();

        if ($upload_file) {
            // Set the appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $upload_file . '"');
            header('Content-Length: ' . filesize($upload_file));

            // Output the file data
            readfile($upload_file);
            exit();
        }
}
?>
