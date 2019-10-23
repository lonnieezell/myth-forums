<?= $this->include('_head') ?>

<?= $this->include('_navbar') ?>

<?= $this->include('_notices') ?>

<div class="container-fluid">
    <br>

    <div class="row">

        <!-- Sidebar -->
        <div class="col-sm-2 sidebar">
            <?= $this->renderSection('sidebar') ?>
        </div>

        <!-- Main Content Column -->
        <div class="col">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<?= $this->include('_foot') ?>
