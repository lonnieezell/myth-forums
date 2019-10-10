<?= $this->extend('single') ?>

<?= $this->section('content') ?>
    <h1>My Account</h1>

    <br>

    <form action="<?= route_to('account') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-sm-6">
                <fieldset>
                    <legend>About Me</legend>

                    <!-- Date of Birth -->
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control col-sm-6" value="<?= old('dob', isset($user) ? $user->setting('dob') : '') ?>">
                    </div>

                    <!-- DOB Privacy -->
                    <div class="form-group">
                        <label for="dob_privacy">Date of Birth Privacy</label>
                        <select name="dob_privacy" class="form-control">
                            <option value="1" <?= old('dob_privacy', isset($user) && $user->setting('dob_privacy')) == 1 ? 'selected' : '' ?>>Display Age and Date of Birth</option>
                            <option value="2" <?= old('dob_privacy', isset($user) && $user->setting('dob_privacy')) == 2 ? 'selected' : '' ?>>Hide Age and Date of Birth</option>
                            <option value="3" <?= old('dob_privacy', isset($user) && $user->setting('dob_privacy')) == 3 ? 'selected' : '' ?>>Display Age Only</option>
                        </select>
                    </div>

                    <br>

                    <!-- URL -->
                    <div class="form-group">
                        <label for="website">Website URL</label>
                        <input type="url" name="website" class="form-control" maxlength="255" value="<?= old('website', isset($user) ? esc($user->setting('website'), 'attr') : '') ?>">
                    </div>

                    <br>

                    <!-- Location -->
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-control" value="<?= old('location', isset($user) ? esc($user->setting('location'), 'attr') : '') ?>">
                        <p class="small text-muted">Where in the world do you live? </p>
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <select name="country" class="form-control">
                            <option value="0">Select a country...</option>
                            <?php if (isset($countries)) : ?>
                                <?php foreach ($countries as $country) : ?>
                                    <option value="<?= $country->code ?>" <?= old('country', isset($user) ? $user->setting('country') : '') == $country->code ? 'selected' : '' ?>>
                                        <?= $country->name ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>

                    <!-- Bio -->
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea name="bio" class="form-control" rows="10"><?= old('bio', isset($user) ? esc($user->setting('bio')) : '') ?></textarea>
                    </div>

                </fieldset>
            </div>

            <div class="col-sm-6">
                <fieldset>
                    <legend>Options</legend>

                    <!-- Show Online -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="show_online" id="show_online" <?= old('show_online', isset($user) && $user->setting('show_online')) == 1 ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="show_online">Show when I'm online</label>
                    </div>

                    <!-- Auto-Subscribe -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="auto_subscribe" id="auto_subscribe" <?= old('auto_subscribe', isset($user) && $user->setting('auto_subscribe')) == 1 ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="auto_subscribe">Auto-subscribe to discussions I reply to.</label>
                    </div>

                    <!-- Allow PM -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="allow_pm" id="allow_pm" <?= old('allow_pm', isset($user) && $user->setting('allow_pm')) == 1 ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="allow_pm">Allow private messages</label>
                    </div>

                    <hr>

                    <!-- Parser -->
                    <div class="form-group">
                        <label for="country">Post Markup Parser</label>
                        <select name="parser" class="form-control">
                            <option value="0">Select a parser...</option>
                            <option value="Markdown" <?= old('parser', $user->setting('parser')) == 'Markdown' ? 'selected' : '' ?>>Markdown</option>
                            <option value="BBCode" <?= old('parser', $user->setting('parser')) == 'BBCode' ? 'selected' : '' ?>>BBCode</option>
                        </select>
                        <p class="small text-muted">Specifies the markup you can use when editing long text fields.</p>
                    </div>

                </fieldset>
            </div>
        </div>

        <hr>

        <div class="text-right">
            <input type="submit" class="btn btn-primary" value="Save Account Settings">
        </div>
    </form>
<?= $this->endSection() ?>
