<tr>
    <td><?= $tag->id ?></td>
    <td class="text-center"><div class="color-swatch" style="background: <?= $tag->color ?? '#ffffff' ?>"></div></td>
    <td><?= $depth > 0 ? str_repeat('&mdash;', $depth) .' ' : '' ?><?= esc($tag->title) ?></td>
    <td><?= esc($tag->slug) ?></td>
    <td><?= esc($tag->description) ?></td>
    <td class="text-center"><?= $tag->public ? 'Y' : 'N' ?></td>
    <td class="text-center">
        <a href="<?= route_to('forum-admin-edit-tag', $tag->id) ?>">Edit</a>
    </td>
</tr>
