<?php
session_start();
include __DIR__ . '/../config/database.php';
include __DIR__ . "/libs/helpers.php";
include __DIR__ . "/libs/validation.php";
$error = [];
$input = [];
$valid = false;
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);
if ($request_method == "POST") {
    $pat_fname = $_POST['pat_fullname'];
    $pat_gender = $_POST['pat_gender'];
    $pat_number = $_POST['pat_number'];
    $pat_phone = $_POST['pat_phone'];
    $pat_add = $_POST['pat_add'];
    $pat_dob = date_create_from_format('d/m/Y', $_POST['pat_dob'])->format('Y-m-d');
    $app_date = date_create_from_format('d/m/Y', $_POST['app_date'])->format('Y-m-d');
    $app_slot = $_POST['app_slot'] ?? "";
    $pat_desc = $_POST['pat_desc'];



    $query = "INSERT INTO my_appointment (app_number, pat_fullname, pat_gender, pat_dob, pat_add, pat_phone, app_date, pat_desc, app_slot) 
          VALUES (:app_number, :pat_fullname, :pat_gender, :pat_dob, :pat_add, :pat_phone, :app_date, :pat_desc, :app_slot)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':app_number', $pat_number);
    $stmt->bindParam(':pat_fullname', $pat_fname);
    $stmt->bindParam(':pat_gender', $pat_gender);
    $stmt->bindParam(':pat_dob', $pat_dob);
    $stmt->bindParam(':pat_add', $pat_add);
    $stmt->bindParam(':pat_phone', $pat_phone);
    $stmt->bindParam(':app_date', $app_date);
    $stmt->bindParam(':pat_desc', $pat_desc);
    $stmt->bindParam(':app_slot', $app_slot);

    if ($pat_fname == 'Linh' && $stmt->execute()) {
        $_SESSION['input'] = $_POST;
        $_SESSION['error'] = "Failed to add appointment. Please try again.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        $input['pat_fullname'] = $pat_fname;
        $input['pat_gender'] = $pat_gender;
        $input['pat_number'] = $pat_number;
        $input['pat_phone'] = $pat_phone;
        $input['pat_add'] = $pat_add;
        $input['pat_dob'] = $_POST['pat_dob'];
        $input['app_date'] = $_POST['app_date'];
        $input['app_slot'] = $_POST['app_slot'];
        $input['pat_desc'] = $pat_desc;
        $error[] = "Failed to add appointment. Please try again.";
    }
} elseif ($request_method == "GET") {
    unset($_SESSION['input']);
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Anh Clinic</title>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/daterangepicker.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/inc/patient/booking.php'; ?>
</body>

</html>