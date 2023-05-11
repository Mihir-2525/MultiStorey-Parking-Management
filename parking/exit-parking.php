<div class="container-demo">
    <div class="row-demo">
        <?php for ($i = 1; $i <= 18; $i++) { ?>
            <input class="slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>
    <!-- Divider -->
    <div class="bim"></div>

    <div class="row-demo">
        <?php for ($i = 19; $i <= 34; $i++) { ?>
            <input class="slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>
    <div class="row-demo">
        <?php for ($i = 35; $i <= 50; $i++) { ?>
            <input class="r-slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>

    <div class="bim"></div>

    <div class="row-demo">
        <?php for ($i = 51; $i <= 66; $i++) { ?>
            <input class="slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>
    <div class="row-demo">
        <?php for ($i = 67; $i <= 82; $i++) { ?>
            <input class="r-slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>

    <div class="bim"></div>

    <div class="row-demo">
        <?php for ($i = 83; $i <= 100; $i++) { ?>
            <input class="r-slot <?= in_array($i, $data["slot_no"] ?? []) ? "" : "occupied" ?>" type="button" id="a<?= $i ?>" value="A<?= $i ?>" class="btn type-demo btn-primary" <?php if ((in_array($i, $data["slot_no"] ?? []))) : ?> data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" <?php endif; ?>>
        <?php } ?>
    </div>
</div>