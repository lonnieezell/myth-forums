<div class="media topic-list-item">
    <img src="<?= $topic->author->avatar(60) ?>" alt="<?= esc($topic->username, 'attr') ?>"  class="align-self-start mr-3 avatar">
    <div class="media-body">
        <a href="<?= $topic->link() ?>">
            <h5 class="mt-0"><?= esc($topic->title) ?></h5>
        </a>
        <p class="meta">
            posted <?= $topic->created_at->humanize() ?>
            by <a href="<?= route_to('profile', esc($topic->username)) ?>"><?= esc($topic->username) ?></a>
        </p>
        <p class="snippet"><?= $topic->snippet() ?></p>
    </div>
</div>

