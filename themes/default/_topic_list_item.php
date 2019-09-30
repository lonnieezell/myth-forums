<div class="topic row">
    <div class="col">
        <p class="title">
            <a href="/forum/discussion/<?= $topic->slug ?>">
                <?= esc($topic->title) ?>
            </a>
        </p>
        <p class="meta">
            posted <?= $topic->created_at->humanize() ?>
            by <a href="/users/<?= esc($topic->username) ?>"><?= esc($topic->username) ?></a>
        </p>
    </div>
</div>
