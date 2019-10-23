<?= $this->extend('master') ?>

<?= $this->section('content') ?>
    <h1>Forum Management</h1>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
    <?= $this->render('admin/forum/_sidebar') ?>
<?= $this->endSection() ?>
