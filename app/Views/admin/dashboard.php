<?= $this->extend('master') ?>

<?= $this->section('content') ?>
    <div class="jumbotron">
        <h1>Dashboard</h1>
        <p class="lead">Where Admins go to wreak vengeance.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    PHP - <?= phpversion() ?>
                </div>
                <div class="col-auto">
                    <?= $dbDriver .' - '. $dbVersion ?>
                </div>
                <div class="col-auto">
                    CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION  ?>
                </div>
                <div class="col-auto">
                    Environment: <?= ENVIRONMENT ?>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
