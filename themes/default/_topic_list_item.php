<div class="topic row">
    <div class="col">
        <p class="title">
            <a href="/forum/discussion/<?= $topic->slug ?>">
                <?= esc($topic->title, 'html') ?>
            </a>
        </p>
        <p class="meta">
            posted <?= $topic->created_at->humanize() ?>
        </p>
    </div>
</div>
