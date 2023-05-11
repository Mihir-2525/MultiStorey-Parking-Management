<div class="display" style="margin-top: 15px;display: flex;align-items: center;flex-direction: column;">
    <div class="Button-collection">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#entry" aria-expanded="false" aria-controls="collapseExample">Entry Data</button>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#exit" aria-expanded="false" aria-controls="collapseExample">Exit Data</button>
    </div>
    <div class="collapse" id="entry">
        <!-- Entry Data -->
        <div class="display-data">
            <?php
            $sql = "SELECT * FROM `parking` WHERE `floor` = 0 ORDER BY `entrytime` DESC LIMIT 3";
            $result = mysqli_query($conn, $sql);
            // Check if there is a matching record
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    // $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="ticket">
                        <h1>Slot Number: <?= $row['slot_no']; ?></h1>
                        <table>
                            <tr>
                                <td>Vehicle Number:</td>
                                <td><?= $row['vh_no']; ?></td>
                            </tr>
                            <tr>
                                <td>Mobile no:</td>
                                <td><?= $row['mobile_no']; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><?= $row['mail']; ?></td>
                            </tr>
                            <tr>
                                <td>Entry Time:</td>
                                <td><?= $row['entrytime']; ?></td>
                            </tr>
                        </table>
                    </div>
            <?php
                }
            } else {
                echo "All Slots are empty";
            }

            ?>
        </div>
    </div>
    <div class="collapse" id="exit">
        <!-- Exit Data -->
        <div class="display-data">
            <?php
            $sql = "SELECT * FROM `parking_data` ORDER BY `exittime` DESC LIMIT 3";
            $result1 = mysqli_query($conn, $sql);
            // Check if there is a matching record
            if (mysqli_num_rows($result1) > 0) {
                while ($row = $result1->fetch_assoc()) {
                    // $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="ticket">
                        <h1>Slot Number: <?= $row['slot_no']; ?></h1>
                        <h4 style="display: flex;justify-content: center;">Floor : <?= $row['floor'] ?></h4>
                        <table>
                            <tr>
                                <td>Vehicle Number:</td>
                                <td><?= $row['vh_no']; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><?= $row['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Mobile no:</td>
                                <td><?= $row['mobile_no']; ?></td>
                            </tr>
                            <tr>
                                <td>Entry Time:</td>
                                <td><?= $row['entrytime']; ?></td>
                            </tr>
                            <tr>
                                <td>Exit Time:</td>
                                <td><?= $row['exittime']; ?></td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td><?= $row['price']; ?></td>
                            </tr>
                        </table>
                    </div>
            <?php
                }
            } else {
            }

            // Close Connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>