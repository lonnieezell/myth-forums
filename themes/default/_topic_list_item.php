<div class="topic row">
    <div class="col-sm-1">
        <img src="<?= $topic->author->avatar(60) ?>" alt="<?= esc($topic->username, 'attr') ?>" class="avatar">
    </div>
    <div class="col">
        <p class="title">
            <a href="/forum/discussion/<?= $topic->slug ?>">
                <?= esc($topic->title) ?>
            </a>
        </p>
        <p class="meta">
            posted <?= $topic->created_at->humanize() ?>
            by <a href="/members/<?= esc($topic->username) ?>"><?= esc($topic->username) ?></a>
        </p>
        <p class="snippet"><?= $topic->snippet() ?></p>
    </div>
</div>


