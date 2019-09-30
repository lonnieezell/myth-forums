<?= $this->extend('single') ?>

<?= $this->section('content') ?>

    <div class="topic-header">
        <h1 class="topic-title"><?= esc($topic->title) ?></h1>

        <div class="meta">
            By Author Name on <?= $topic->created_at->format('M j, Y') ?>
        </div>
    </div>

    <div class="topic">


        <?= $topic->html ?? esc($topic->body, 'html') ?>
    </div>

<?= $this->endSection() ?>
