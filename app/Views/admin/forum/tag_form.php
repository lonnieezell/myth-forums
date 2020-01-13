<?= $this->extend('master') ?>

<?= $this->section('pageHeader') ?>
    <span class="text-uppercase page-subtitle">Forum - Tags</span>
    <h3 class="page-title"><?= ucfirst($pageType) ?> Tag</h3>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card col-sm-6">
        <div class="card-body">

            <form action="<?= isset($tag) ? route_to('forum-admin-update-tag', $tag->id) : route_to('forum-admin-save-tag') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col">
                        <!-- Tag Type -->
                        <div class="form-group">
                            <label for="is_structural">Tag Type</label>
                            <select name="is_structural" class="form-control col-sm-3">
                                <option value="1" <?= old('is_structural', $tag->is_structural ?? 0) == 1 ? 'selected' : '' ?>>Primary</option>
                                <option value="0" <?= old('is_structural', $tag->is_structural ?? 0) == 0 ? 'selected' : '' ?>>Secondary</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <br><br>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="public" id="public" <?= isset($tag) && $tag->public ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="public">Public</label>
                        </div>
                    </div>
                </div>

                <?php if($tagType == 'primary') : ?>
                    <!-- Available Parents -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="parent_id">Parent</label>
                            <select name="parent_id" class="form-control">
                                <option value="0">No parent</option>
                                <?php if(isset($tags) && count($tags)) : ?>
                                    <?php foreach ($tags as $row) : ?>
                                        <option value="<?= $row->id ?>" <?= old('parent_id', $tag->parent_id ?? 0) == $row->id ? 'selected' : ''  ?>>
                                            <?= $row->title ?>
                                        </option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title', isset($tag) ? esc($tag->title, 'attr') : '') ?>">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= old('title', isset($tag) ? esc($tag->description) : '') ?></textarea>
                </div>

                <br>

                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" name="color" value="<?= old('color', isset($tag) ? $tag->color : '') ?>">
                </div>

                <hr>

                <div class="text-right">
                    <a href="<?= route_to('forum-admin-tags') ?>" class="btn btn-link">Cancel</a>
                    <input type="submit" value="Save Tag" class="btn btn-primary">
                </div>
            </form>

        </div>
    </div>


<?= $this->endSection() ?>

