<?php
    $conn = mysqli_connect('localhost', 'root', '', 'clinic');
    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['date'];
        $insert = mysqli_query($conn, "INSERT INTO `appointment`(fullname, email, phone, date)
        VALUE('$name', '$email', '$phone', '$date')");
        if($insert) {
            $message = "Thêm cuộc hẹn thành công";
            echo '<div id="successModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Thông báo</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>Thêm cuộc hẹn thành công</p>
                        </div>
                      </div>
                    </div>
                  </div>';
        }
        else {
            $message = "Thêm cuộc hẹn thất bại";
            echo '<div id="failureModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Thông báo</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>Thêm cuộc hẹn thất bại</p>
                        </div>
                      </div>
                    </div>
                  </div>';
        }
    }
?>

<section class="booking" id="booking">
    <h1 class="heading">Đặt lịch hẹn</h1>
    <form action="" method="post">
        <span>Tên của bạn:</span>
        <input type="text" name="name" placeholder="Nhập tên của bạn" class=box>
        <span>Email:</span>
        <input type="email" name="email" placeholder="Nhập email" id="" class="box">
        <span>Điện thoại:</span>
        <input type="text" name="phone" placeholder="Nhập số điện thoại" class="box">
        <span>Chọn ngày:</span>
        <input type="date" name="date" class="box">
        <input type="submit" name="submit" value="Đặt lịch ngay" class="link-btn">
    </form>
</section>

<script>
    <?php if(isset($message)) { ?>
        <?php if($message == "Thêm cuộc hẹn thành công") { ?>
            $('#successModal').modal('show');
        <?php } else { ?>
            $('#failureModal').modal('show');
        <?php } ?>
    <?php } ?>
</script>