<section class="booking" id="booking">
  <div class="container">
    <h1 class="heading">Đặt lịch hẹn</h1>
    <form method="post">
      <!-- Line 1 -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4" class="col-form-label">Họ tên</label>
          <input type="text" name="pat_fullname" class="form-control" id="inputEmail4" value="<?php echo isset($_SESSION['input']['pat_fullname']) ? htmlspecialchars($_SESSION['input']['pat_fullname']) : ''; ?>"
            placeholder="Họ và tên bệnh nhân">
        </div>
        <div class="form-group col-md-4">
          <label class="col-form-label">Ngày sinh</label>
          <input type="text" name="pat_dob" id="demo" class="form-control" data-date-format="dd/MM/YYYY">
          <script>
            $(function () {
              var today = new Date();
              var dd = String(today.getDate()).padStart(2, '0');
              var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
              var yyyy = today.getFullYear();

              var todayString = dd + '/' + mm + '/' + yyyy;
              $('#demo').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "autoUpdateInput": true,
                "startDate": "01/01/1990",
                "endDate": "08/05/2026",
                "locale": {
                  "format": "DD/MM/YYYY",
                  "daysOfWeek": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                  "monthNames": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                  "firstDay": 1
                }
              }, function (start, end, label) {
                console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
              });
            });
          </script>
        </div>
        <div class=" col-md-2">
          <label class="col-form-label">Giới tính</label>
          <div class="dlex">
            <div class="form-check form-check-inline">
              <input type="radio" name="pat_gender" class="form-check-input form-control gender" id="maleRadio"
                value="Nam" checked>
              <label class="form-check-label" for="maleRadio">Nam</label>
            </div>
            <div class="form-check justify-content-center align-items-center form-check-inline">
              <input type="radio" name="pat_gender" class="form-check-input form-control gender" id="femaleRadio"
                value="Nữ">
              <label class="form-check-label" for="femaleRadio">Nữ</label>
            </div>
          </div>
        </div>
      </div>


      <!-- Line 2 -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputAddress" class="col-form-label">Địa chỉ</label>
          <input type="text" class="form-control" name="pat_add" id="inputAddress" placeholder="Địa chỉ thường trú">
        </div>
        <div class="form-group col-md-6">
          <label for="inputCity" class="col-form-label">Điện thoại</label>
          <input type="text" name="pat_phone" class="form-control" id="inputCity" placeholder="Số điện thoại">
        </div>
      </div>



      <div class="form-row">
        <div class="form-group col-md-2" style="display:none">
          <?php
          $length = 5;
          $app_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
          ?>
          <label for="inputZip" class="col-form-label">Appointment Number</label>
          <input type="text" name="pat_number" value="<?php echo $app_number; ?>" class="form-control" id="inputZip">
        </div>
      </div>


      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="appDate" class="col-form-label">Chọn ngày</label>
          <input type="text" name="app_date" id="appDate" class="form-control" data-date-format="dd/MM/YYYY"
            value="08/05/2024">
          <script>
            $(function () {
              var today = new Date();
              var dd = String(today.getDate()).padStart(2, '0');
              var mm = String(today.getMonth() + 1).padStart(2, '0'); 
              var yyyy = today.getFullYear();

              var todayString = dd + '/' + mm + '/' + yyyy;
              $('#appDate').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "autoUpdateInput": true,
                "startDate": todayString,
                "endDate": "08/05/2026",
                "locale": {
                  "format": "DD/MM/YYYY",
                  "daysOfWeek": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                  "monthNames": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                  "firstDay": 1
                }
              }, function (start, end, label) {
                console.log("New date range selected: " + start.format('YYYY-MM-DD'));

                var selectedDate = start.format('YYYY-MM-DD');

                //ajax
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "endpoint.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                  if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                      var timeslots = JSON.parse(xhr.responseText);
                      console.log("Received timeslots: ", timeslots);
                      displayTimeslotsOnUI(timeslots);
                    } else {
                      console.error("Error: " + xhr.status);
                    }
                  }
                };
                xhr.send("selected_date=" + selectedDate);
              });
            });

            function displayTimeslotsOnUI(timeslots) {
              var timeslotContainer = document.getElementById("timeslots");
              var slots = document.querySelectorAll('.timeslot');
              slots.forEach((item, index) => {
                var slotNumber = index + 1;
                if (timeslots.includes(String(slotNumber))) {
                  console.log(timeslots);
                  console.log(slotNumber);
                  item.classList.add('hide'); 
                }
                else {
                  item.classList.remove('hide');
                }
              });
            }
          </script>

        </div>
        <div class="form-group col-md-8">
          <label for="timeSlot" class="col-form-label">Chọn khung giờ</label>
          <?php
          $hours = array(
            array("time" => "07:00 - 08:00 ", "booked" => false),
            array("time" => "08:00 - 09:00 ", "booked" => false),
            array("time" => "09:00 - 10:00 ", "booked" => false),
            array("time" => "10:00 - 11:00 ", "booked" => false),
            array("time" => "11:00 - 12:00", "booked" => false),
            array("time" => "12:00 - 01:00", "booked" => false),
            array("time" => "01:00 - 02:00", "booked" => false),
            array("time" => "02:00 - 03:00", "booked" => false),
            array("time" => "03:00 - 04:00", "booked" => false),
            array("time" => "04:00 - 05:00", "booked" => false)
          );


          
          echo '<div class="container ">';

          echo '<div class="time-slots row" id="timeslots">';
          foreach ($hours as $index => $hour) {
            echo '<div class="col-md-2 timeslot">';
            echo '<input type="radio" ' . ($index == 0 ? 'checked' : '') . ' id="' . str_replace(" ", "-", $hour['time']) . '" name="app_slot" value="' . ($index + 1) . '">';
            echo '<label for="' . str_replace(" ", "-", $hour['time']) . '" class="' . ($hour['booked'] ? 'booked' : 'available') . '">' . $hour['time'] . '</label>';
            echo '</div>';
          }


          echo '</div>';
          echo '</div>';
          ?>


        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputAddress" class="col-form-label">Ghi chú</label>
          <textarea type="text" class="form-control" name="pat_desc" id="editor"></textarea>
        </div>
        <div id="timeslots col-md-6">
          <!-- Các timeslot sẽ được thêm vào đây từ AJAX -->
        </div>
      </div>

      <button type="submit" name="add_appointment" class="ladda-button link-btn" data-style="expand-right">Add
        Patient</button>

    </form>
  </div>

</section>