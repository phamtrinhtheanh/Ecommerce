<?php
// Check if the request is AJAX and if selected_date is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_date'])) {
    // Get the selected date from the POST request
    $selectedDate = $_POST['selected_date'];
    
    // Include your database configuration file
    $host="localhost";
    $db="hmisphp";
    $username="root";
    $password="";
    $mysqli = new mysqli($host, $username, $password, $db);


    $sql = "SELECT * FROM my_appointment WHERE DATE(app_date) = '$selectedDate'";
    $result = mysqli_query($mysqli, $sql);


    $bookedSlots = [];

    // Check if there are any booked slots
    if (mysqli_num_rows($result) > 0) {
        // Fetch booked slots from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Assuming you have a column named 'time_slot' in your appointment table
            $bookedSlots[] = $row['app_slot'];
        }
    }

    // Close the database connection
    mysqli_close($mysqli);

    // Return the booked slots as JSON
    echo json_encode($bookedSlots);
} else {
    // Return an error response if the request is invalid
    
}
