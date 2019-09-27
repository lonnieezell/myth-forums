<?= $this->include('_head') ?>

<?= $this->include('_navbar') ?>

<div class="container">
    <br>

    <div class="row">

        <!-- Sidebar -->
        <div class="col-sm-3">
            <a href="<?= route_to('new_topic') ?>" class="btn btn-block btn-primary">Start new Topic</a>
        </div>

        <!-- Main Content Column -->
        <div class="col">
            <?php $this->renderSection('content') ?>
        </div>
    </div>
</div>

<?= $this->include('_foot') ?>
