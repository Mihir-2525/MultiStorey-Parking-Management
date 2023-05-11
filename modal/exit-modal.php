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
                        <div class="dlt-ticket">
                            <div class="box">
                                <table>
                                    <tr>
                                        <th><span>Slot Number</span></th>
                                        <td><input type="number" max="<?= $i ?>" min="<?= $i ?>" name="slotno" required></td>
                                        <input type="hidden" name="slot_no" value="<?= $i ?>">
                                    </tr>
                                    <!-- <tr>
                                <th><span>hlo</span></th>
                                <td><input type="text" class="input-focus"></td>
                            </tr> -->
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #242333;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Submit" class="btn btn-primary" name="dlt">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>