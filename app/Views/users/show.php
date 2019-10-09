<?= $this->extend('single') ?>

<?= $this->section('content') ?>

    <div class="jumbotron row">

        <div class="col-sm-2">
            <img src="<?= $user->avatar(240) ?>" alt="<?= esc($user->username) ?>" class="avatar avatar-lg">
        </div>
        <div class="col">
            <h1><?= $user->username ?></h1>

            <?php if (! empty($user->ageString)) : ?>
                <p class="lead"><?= esc($user->ageString) ?></p>
            <?php endif ?>

            <?php if (! empty($user->locationString())) : ?>
                <p class="lead"><?= esc($user->locationString()) ?></p>
            <?php endif ?>

            <?= esc($user->setting('bio'), 'html') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <ul class="list-unstyled">
                <li>
                    <a href="#">
                        <i class="far fa-comment"></i>
                        <?= $user->topicCount ?? 0 ?> Discussions
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="far fa-comment"></i>
                        <?= $user->postCount ?? 0 ?> Posts
                    </a>
                </li>
            </ul>

            <hr>

            <ul class="list-unstyled">
                <li><b>Joined: </b> <?= $user->created_at->format('M j, Y') ?></li>
                <li><b>Last Seen: </b> <?= $user->updated_at->humanize() ?></li>
            </ul>

        </div>

        <div class="col">
            <h2>Recent Stuff</h2>
        </div>
    </div>

<?= $this->endSection() ?>
