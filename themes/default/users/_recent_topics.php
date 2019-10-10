<h3>Recent Discussions</h3>

<?php if(isset($topics) && count($topics)) : ?>
    <?php foreach ($topics as $topic) : ?>
        <?= $this->setData(['topic' => $topic])->include('forums/_topic_list_item') ?>
    <?php endforeach ?>
<?php else : ?>
    <div class="alert alert-warning">No recent topics started.</div>
<?php endif ?>
