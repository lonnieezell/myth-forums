<hr>
<form action="<?= route_to('post-reply', $topic->slug) ?>" method="post">
    <?= csrf_field() ?>

    <div class="post-form">
        <div class="row">
            <div class="col-sm-2">
                <img src="<?= user()->avatar(60) ?>" alt="<?= esc(user()->username, 'attr') ?>" class="avatar">
            </div>
            <div class="col">
                <h3>Leave a Reply</h3>

                <textarea class="form-control" name="body" rows="10"></textarea>

            </div>
        </div>
        <div class="text-right">
            <input type="submit" class="btn btn-outline-success" value="Post Reply">
        </div>
    </div>
</form>
