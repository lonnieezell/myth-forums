<?= $this->extend('single') ?>

<?= $this->section('content') ?>

<form action="<?= route_to('save_new_topic') ?>" method="post" class="horizon">
    <?= csrf_field() ?>

    <!-- Title -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="title">Topic Title</label>
        <div class="col">
            <input type="text" name="title" class="form-control" value="<?= old('title') ?>">
        </div>
    </div>

    <!-- Title -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="body">Your Message</label>
        <div class="col">
            <textarea name="body" class="form-control" rows="10"><?= old('body') ?></textarea>
        </div>
    </div>

    <hr>

    <!-- Parser to User -->
    <div class="form-group row">
        <label for="parser" class="col-sm-2 col-form-label">Body Format</label>
        <div class="col-2">
            <select name="parser" class="form-control">
                <?php foreach($parsers as $parser => $class) : ?>
                    <option value="<?= $parser ?>"><?= $parser ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <hr>

    <div class="text-right">
        <input type="submit" class="btn btn-outline-success" value="Save Topic">
    </div>

</form>

<?= $this->endSection() ?>
