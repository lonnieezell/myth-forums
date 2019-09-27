<?= $this->extend('master') ?>

<?= $this->section('content') ?>

    <?php if (isset($topics) && count($topics)) : ?>

    <?php else : ?>
        <div class="alert alert-info">
            No Topics were found. You should <a href="<?= route_to('new_topic') ?>">start one</a> today.
        </div>
    <?php endif ?>

<?= $this->endSection() ?>
