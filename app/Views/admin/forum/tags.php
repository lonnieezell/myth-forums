<?= $this->extend('master') ?>

<?= $this->section('pageHeader') ?>
    <span class="text-uppercase page-subtitle">Forums</span>
    <h3 class="page-title">Manage Tags</h3>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Primary Tags -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0">Primary Tags</h6>
                            <p class="text-muted">These form the structure of your forums, much like typical categories in other systems.</p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= route_to('forum-admin-new-tag') ?>?type=primary" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> New Tag</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <table class="table table-striped mb-0 text-left">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0" style="width: 4em">#</th>
                                <th scope="col" class="border-0" style="width: 3em">Color</th>
                                <th scope="col" class="border-0">Title</th>
                                <th scope="col" class="border-0">Slug</th>
                                <th scope="col" class="border-0">Description</th>
                                <th scope="col" class="border-0" style="width: 3em">Public</th>
                                <th scope="col" class="border-0" style="width: 7em">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($primaryTags) && count($primaryTags)) : ?>
                            <?php foreach ($primaryTags as $tag) : ?>
                                <?= view('admin/forum/_tag_row', ['tag' => $tag, 'depth' => 0]) ?>

                                <?php if (isset($tag->tags) && count($tag->tags)) : ?>
                                    <?php foreach ($tag->tags as $tag) : ?>
                                        <?= view('admin/forum/_tag_row', ['tag' => $tag, 'depth' => 1]) ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <div class="alert alert-info">
                                No primary tags found.
                            </div>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Tags -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0">Secondary Tags</h6>
                            <p class="text-muted">These are for micro-organization and assist in searches and general categorization.</p>
                        </div>
                        <div class="col-auto">
                            <a href="<?= route_to('forum-admin-new-tag') ?>?type=secondary" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> New Tag</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <table class="table table-striped mb-0 text-left">
                        <thead class="bg-light">
                        <tr>
                            <th scope="col" class="border-0" style="width: 4em">#</th>
                            <th scope="col" class="border-0" style="width: 3em">Color</th>
                            <th scope="col" class="border-0">Title</th>
                            <th scope="col" class="border-0">Slug</th>
                            <th scope="col" class="border-0">Description</th>
                            <th scope="col" class="border-0" style="width: 3em">Public</th>
                            <th scope="col" class="border-0" style="width: 7em">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($secondaryTags) && count($secondaryTags)) : ?>
                            <?php foreach ($secondaryTags as $tag) : ?>
                                <?= view('admin/forum/_tag_row', ['tag' => $tag, 'depth' => 0]) ?>

                                <?php if (isset($tag->tags) && count($tag->tags)) : ?>
                                    <?php foreach ($tag->tags as $tag) : ?>
                                        <?= view('admin/forum/_tag_row', ['tag' => $tag, 'depth' => 1]) ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <div class="alert alert-info">
                                No secondary tags found.
                            </div>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
