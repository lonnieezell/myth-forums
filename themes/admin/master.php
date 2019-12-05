<?= $this->include('_head') ?>

<div class="container-fluid">

    <div class="row">
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                    <div class="d-table m-auto">
                        <span class="d-none d-md-inline ml-1">Myth:Forums</span>
                    </div>
                </a>
                <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                    <i class="material-icons"></i>
                </a>
            </nav>

            <div class="nav-wrapper">
                <?= $this->include('_sidebar') ?>
            </div>
        </aside>

        <main class="main-content col-lg-10 col-md-9 col-sm-12 offset-lg-2 offset-md-3 p-0">

            <?= $this->include('_navbar') ?>

            <div class="main-content-container container-fluid">

                <?= $this->include('_notices') ?>

                <div class="page-header">
                    <?= $this->renderSection('pageHeader') ?>
                </div>

                <?= $this->renderSection('content') ?>

                <footer class="main-footer">
                    <?= $this->include('_foot') ?>
                </footer>
            </div>
        </main>
    </div>
</div>
