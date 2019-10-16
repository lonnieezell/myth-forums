<?php if (session('errors')) : ?>
    <div class="alert alert-danger">
        <div class="container">
            <?php foreach (session('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>

<?php if (session('error')) : ?>
    <div class="alert alert-danger">
        <div class="container">
            <?= session('error') ?>
        </div>
    </div>
<?php endif ?>

<?php if (session('message')) : ?>
    <div class="alert alert-success">
        <div class="container">
            <?= session('message') ?>
        </div>
    </div>
<?php endif ?>
