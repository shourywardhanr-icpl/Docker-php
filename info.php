<?php
// Basic system information
echo "<h1>Hello World!</h1>";
echo "<h2>PHP System Information</h2>";

// Server and PHP information section
echo "<h3>Server Information:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Server Name: " . $_SERVER['SERVER_NAME'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// PHP Configuration section
echo "<h3>PHP Configuration:</h3>";
echo "<p>display_errors: " . ini_get('display_errors') . "</p>";
echo "<p>max_execution_time: " . ini_get('max_execution_time') . "</p>";
echo "<p>memory_limit: " . ini_get('memory_limit') . "</p>";
echo "<p>upload_max_filesize: " . ini_get('upload_max_filesize') . "</p>";

// Database information (if available)
if (function_exists('mysqli_connect')) {
    echo "<h3>Database Support:</h3>";
    echo "<p>MySQL Support: Enabled</p>";
    echo "<p>MySQL Client Version: " . mysqli_get_client_info() . "</p>";
}

// Extensions information
echo "<h3>Loaded Extensions:</h3>";
echo "<ul>";
foreach (get_loaded_extensions() as $extension) {
    echo "<li>$extension</li>";
}
echo "</ul>";

// Environment variables
echo "<h3>Environment Variables:</h3>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

// Date and time information
echo "<h3>Date and Time Information:</h3>";
echo "<p>Current Server Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Timezone: " . date_default_timezone_get() . "</p>";

// PHP info in a more controlled format
echo "<h3>Detailed PHP Configuration:</h3>";
ob_start();
phpinfo(INFO_CONFIGURATION);
$phpinfo = ob_get_contents();
ob_end_clean();
$phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
echo $phpinfo;
?>
