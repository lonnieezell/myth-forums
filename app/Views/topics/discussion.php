<?= $this->extend('single') ?>

<?= $this->section('content') ?>

    <div class="topic">
        <div class="row">
            <div class="col-sm-2">
                <img src="<?= $topic->author->avatar(120) ?>" alt="<?= esc($topic->author->username, 'attr') ?>" class="avatar-lg">
            </div>
            <div class="col">

                <div class="topic-header">
                    <h1 class="topic-title"><?= esc($topic->title) ?></h1>

                    <div class="meta">
                        By <a href="<?= $topic->author->link() ?>"><?= $topic->author->username ?></a> on <?= $topic->created_at->format('M j, Y') ?>
                    </div>
                </div>

                <div class="topic-body">
                    <?= $topic->html ?? esc($topic->body, 'html') ?>
                </div>

            </div>
        </div>
    </div>

    <?= $this->include('forums/_new_post') ?>


<?= $this->endSection() ?>
