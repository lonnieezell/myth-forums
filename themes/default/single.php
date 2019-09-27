<?= $this->include('_head') ?>

<?= $this->include('_navbar') ?>

<?= $this->include('_notices') ?>

<div class="container">
    <br>

    <?php $this->renderSection('content') ?>
</div>

<?= $this->include('_foot') ?>
