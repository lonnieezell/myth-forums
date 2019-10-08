<?= $this->extend('single') ?>

<?= $this->section('content') ?>

    <div class="jumbotron row">

        <div class="col-sm-2">
            <img src="<?= $user->avatar() ?>" alt="<?= esc($user->username) ?>" class="avatar avatar-lg">
        </div>
        <div class="col">
            <h1><?= $user->username ?></h1>

            <?php if (! empty($user->ageString)) : ?>
                <p class="lead"><?= esc($user->ageString) ?></p>
            <?php endif ?>

            <?php if (! empty($user->locationString())) : ?>
                <p class="lead"><?= esc($user->locationString()) ?></p>
            <?php endif ?>
        </div>
    </div>

<?= $this->endSection() ?>
