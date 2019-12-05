<div class="nav-wrapper">
    <?php if (isset($mainMenu)) : ?>
        <ul class="nav flex-column">
        <?php foreach($mainMenu->getItems() as $item) : ?>
            <li class="nav-item">
                <a href="<?= $item->getUrl() ?>" class="nav-link"><?= $item->getTitle() ?></a>
            </li>
        <?php endforeach ?>
        </ul>
    <?php endif ?>
</div>
