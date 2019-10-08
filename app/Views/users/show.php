<?= $this->extend('single') ?>

<?= $this->section('content') ?>

    <div class="jumbotron">
        <h1><?= $user->username ?></h1>

        <?php if (! empty($user->ageString)) : ?>
            <p class="lead"><?= esc($user->ageString) ?></p>
        <?php endif ?>

        <?php if (! empty($user->locationString)) : ?>
            <p class="lead"><?= esc($user->locationString()) ?></p>
        <?php endif ?>
    </div>

<?= $this->endSection() ?>
