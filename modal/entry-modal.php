<?php for ($i = 1; $i <= 100; $i++) { ?>
    <div class="modal fade" id="exampleModal<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #242333;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Slot - <?= $i ?></h1>
                    <button type="button" class="btn-close" style="background-color: #4d4b5d50;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="modal-body">
                        <div class="book-ticket">
                            <div class="box">
                                <table id="ticket-table">
                                    <input type="hidden" name="slot_no" value="<?= $i ?>">
                                    <tr>
                                        <th><span>Vehicle Number</span></th>
                                        <td><input type="text" style="width: 150px;" pattern="^[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}$" maxlength="10" name="vno" required></td>
                                    </tr>
                                    <tr>
                                        <th><span>Mobile Number</span></th>
                                        <td><input type="tel" pattern="[6-9]{3}[0-9]{7}" maxlength="10" name="mno" style="width: 150px;" required></td>
                                    </tr>
                                    <tr>
                                        <th><span>Email</span></th>
                                        <td><input type="email" name="email" required></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #242333;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Submit" class="btn btn-primary" name="submit_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>