<?= $this->include('_head') ?>

<?= $this->include('_navbar') ?>

<?= $this->include('_notices') ?>

<div class="container-fluid">
    <br>

    <div class="row">

        <!-- Sidebar -->
        <div class="col-sm-2">
            <a href="<?= route_to('new_topic') ?>" class="btn btn-block btn-primary">Start new Topic</a>
        </div>

        <!-- Main Content Column -->
        <div class="col">
            <?php $this->renderSection('content') ?>
        </div>
    </div>
</div>

<?= $this->include('_foot') ?>
