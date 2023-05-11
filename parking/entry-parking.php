<div class="container-demo">
    <?php
    $rows = array(
        array(1, 18),
        array(19, 34),
        array(35, 50),
        array(51, 66),
        array(67, 82),
        array(83, 100)
    );
    foreach ($rows as $index => $row) {
    ?>
        <div class="row-demo">
            <?php for ($i = $row[0]; $i <= $row[1]; $i++) {
                if (($row[0] >= 1 && $row[0] <= 34) || ($row[0] >= 51 && $row[0] <= 66)) { ?>
                    <input class="slot <?= in_array($i, $data["slot_no"] ?? []) ? "occupied" : "" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if (!(in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
                <?php
                } else { ?>
                    <input class="r-slot <?= in_array($i, $data["slot_no"] ?? []) ? "occupied" : "" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if (!(in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
            <?php
                }
            } ?>
        </div>
        <?php if (($index != 1) && ($index != 3) && ($row[1] != 100)) { ?>
            <div class="bim"></div>
        <?php } ?>
    <?php } ?>
</div>