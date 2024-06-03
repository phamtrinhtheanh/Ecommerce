<?php
session_start();
$host = "localhost";
$db = "hmisphp";
$username = "root";
$password = "";
$mysqli = new mysqli($host, $username, $password, $db);
if (isset($_POST['add_appointment'])) {

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
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    if (!isset($pat_fname) || empty($pat_fname)) {
        $err = "Fullname required";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $pat_fname)) {
        $err = "Fullname should only contain letters and spaces";
    }
    if (!isset($pat_phone)) {
        $err = "Phone required";
    }
    if (!isset($pat_add) || empty($pat_add)) {
        $err = "Address required";
    }
    $stmt->bind_param('sssssssss', $pat_number, $pat_fname, $pat_gender, $pat_dob, $pat_add, $pat_phone, $app_date, $pat_desc, $app_slot);
    if (!isset($err)) {
        $stmt->execute();
        $err = "Book successfully";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../src/inc/patient/header.php'; ?>

<body>
    <?php include __DIR__ . '/../src/inc/patient/nav.php'; ?>
    <section class="home" id="home">
        <div class="container">
            <div class="row min-vh-100 align-items-center">
                <div class="content text-center text-md-left">
                    <h3>Hãy đặt lịch vì sức khỏe của bạn!</h3>
                    <p>Phòng khám đa khoa Thế Anh cung cấp dịch vụ đặt lịch khám bệnh và chăm sóc sức khỏe trực tuyến
                        với chất lượng hàng đầu Việt Nam.</p>
                    <a href="" class="link-btn">Đặt lịch ngay</a>
                </div>
            </div>
        </div>
    </section>
    <?php include __DIR__ . "/../src/inc/patient/booking.php" ?>

    <?php include __DIR__ . '/../src/inc/patient/footer.php'; ?>
</body>

</html>