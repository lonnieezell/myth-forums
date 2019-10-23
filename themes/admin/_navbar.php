<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum">Myth:Forums Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= has_uri('admin/forum') ? 'active' : '' ?>">
                    <a href="<?= route_to('forum-admin') ?>" class="nav-link">Forums</a>
                </li>
                <li class="nav-item <?= has_uri('admin/knowledge') ? 'active' : '' ?>">
                    <a href="#" class="nav-link">Knowledgebase</a>
                </li>
                <li class="nav-item <?= has_uri('admin/users') ? 'active' : '' ?>">
                    <a href="#" class="nav-link">Users & Groups</a>
                </li>
                <li class="nav-item <?= has_uri('admin/settings') ? 'active' : '' ?>">
                    <a href="#" class="nav-link">Settings</a>
                </li>
                <li class="nav-item <?= has_uri('admin/tools') ? 'active' : '' ?>">
                    <a href="#" class="nav-link">Tools</a>
                </li>
            </ul>
            <ul class="navbar-nav">
            <?php if (logged_in()) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= user()->avatar(60) ?>" class="avatar avatar-sm" />
                        <?= user()->username ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= route_to('logout') ?>">Logout</a>
                    </div>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a href="<?= route_to('login') ?>" class="nav-link">Login</a>
                </li>
            <?php endif ?>
            </ul>
        </div>
    </div>
</nav>


