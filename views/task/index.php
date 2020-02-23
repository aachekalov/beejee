<div class="task-index">
    <h1>Задачи</h1>
    <div class="task-form">
        <form id="w0" action="/" method="post">
            <div class="form-group field-task-user required <?php if (count($model->errors)) print isset($model->errors['user']) ? 'has-error' : 'has-success'; ?>">
                <label class="control-label" for="task-user">Имя</label>
                <input type="text" id="task-user" class="form-control" name="user" maxlength="255" aria-required="true" <?php if (count($model->errors)) print 'value="' . $model->user . '"'; ?>>
                <div class="help-block"><?php if (isset($model->errors['user'])) print $model->errors['user']; ?></div>
            </div>
            <div class="form-group field-task-email required <?php if (count($model->errors)) print isset($model->errors['email']) ? 'has-error' : 'has-success'; ?>">
                <label class="control-label" for="task-email">E-mail</label>
                <input type="text" id="task-email" class="form-control" name="email" maxlength="255" aria-required="true" <?php if (count($model->errors)) print 'value="' . $model->email . '"'; ?>>
                <div class="help-block"><?php if (isset($model->errors['email'])) print $model->errors['email']; ?></div>
            </div>
            <div class="form-group field-task-description required <?php if (count($model->errors)) print isset($model->errors['description']) ? 'has-error' : 'has-success'; ?>">
                <label class="control-label" for="task-description">Текст задачи</label>
                <textarea id="task-description" class="form-control" name="description" maxlength="1024" aria-required="true"><?php if (count($model->errors)) print $model->description; ?></textarea>
                <div class="help-block"><?php if (isset($model->errors['description'])) print $model->errors['description']; ?></div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Добавить задачу</button>
            </div>
        </form>
    </div>
    <div id="w1" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><a class="<?= sortClass($sort, 'id') ?>" href="/task/index?page=<?= $currentPage ?>&sort=<?= sortDirection($sort, 'id') ?>">ID</a></th>
                    <th><a class="<?= sortClass($sort, 'user') ?>" href="/task/index?page=<?= $currentPage ?>&sort=<?= sortDirection($sort, 'user') ?>">Имя</a></th>
                    <th><a class="<?= sortClass($sort, 'email') ?>" href="/task/index?page=<?= $currentPage ?>&sort=<?= sortDirection($sort, 'email') ?>">E-mail</a></th>
                    <th><a class="<?= sortClass($sort, 'description') ?>" href="/task/index?page=<?= $currentPage ?>&sort=<?= sortDirection($sort, 'description') ?>">Текст задачи</a></th>
                    <th><a class="<?= sortClass($sort, 'done') ?>" href="/task/index?page=<?= $currentPage ?>&sort=<?= sortDirection($sort, 'done') ?>">Выполнено</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr data-id="<?= $item->id ?>">
                        <td><?= $item->id ?></td>
                        <td><?= htmlspecialchars($item->user) ?></td>
                        <td><?= htmlspecialchars($item->email) ?></td>
                        <td>
                            <div class="description-block <?php if ($item->edited) print "edited" ?>">
                                <span>
                                    <span class="description"><?= htmlspecialchars($item->description) ?></span>
                                    <span title="Отредактировано администратором" class="glyphicon edited glyphicon-edit"></span>
                                </span>
                                <a onclick="edit(this, <?= $item->id ?>)" title="Update" aria-label="Update" <?php if (!isset($_SESSION['admin'])) print 'style="display: none;"'; ?>><span class="glyphicon glyphicon-pencil"></span></a>
                            </div>
                            <div class="input-group mb-3 editor" style="display: none;">
                                <textarea type="text" class="form-control" placeholder="Task description" aria-label="Task description" aria-describedby="button-addon2"><?= htmlspecialchars($item->description) ?></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="sendDescription(this, <?= $item->id ?>)" type="button">Сохранить</button>
                                </div>
                            </div>
                        </td>
                        <td width="1%">
                            <span title="Выполнено!" class="glyphicon glyphicon-ok done" style="<?php if (!$item->done) print 'display: none;'; ?>"></span>
                            <button class="btn btn-primary make-done" onclick="makeDone(this, <?= $item->id ?>)" type="button" style="<?php if (!isset($_SESSION['admin']) || $item->done) print 'display: none;'; ?>">Пометить как выполненное</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $pageCount; $i++) { ?>
                <li <?php if ($i == $currentPage) print 'class="active"'; ?>>
                    <a href="/task/index?page=<?= $i ?><?php if (isset($sort)) print '&sort=' . $sort; ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php
function sortClass($sort, $name)
{
    return ($sort == $name ? 'asc' : ($sort == '-' . $name ? 'desc' : ''));
}

function sortDirection($sort, $name) {
    return $sort == $name ? '-' . $name : $name;
}
?>


<script>
var decodeHtmlEntity = function(str) {
  return str.replace(/&#(\d+);/g, function(match, dec) {
    return String.fromCharCode(dec);
  });
};

var encodeHtmlEntity = function(str) {
  var buf = [];
  for (var i=str.length-1;i>=0;i--) {
    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
  }
  return buf.join('');
};

function makeDone(button, id)
{
    var td = button.closest('td');
    $.ajax({
        url: '/task/makeDone',
        method: 'post',
        dataType: 'json',
        data: {'id': id},
        success: function(data) {
            td.querySelector('.done').style.display = 'block';
            td.querySelector('.make-done').style.display = 'none';
        },
        error: function() {
            alert('Произошла ошибка! Попробуйте обновить страницу и повторить');
        }
    });
}

function sendDescription(button, id)
{
    var newDescription = button.closest('.input-group').querySelector('textarea').value;
    var td = button.closest('td');
    $.ajax({
        url: '/task/updateDescription',
        method: 'post',
        dataType: 'json',
        data: {'id': id, 'description': newDescription},
        success: function(data) {
            td.querySelector('.description').innerHTML = encodeHtmlEntity(newDescription);
            td.querySelector('.editor').style.display = 'none';
            td.querySelector('.description-block').style.display = 'flex';
            td.querySelector('.description-block').classList.add('edited');
        },
        error: function() {
            td.querySelector('.editor').style.display = 'none';
            td.querySelector('.description-block').style.display = 'flex';
            alert('Произошла ошибка! Попробуйте обновить страницу и повторить');
        }
    });
}

function edit(elem, id)
{
    elem.closest("td").querySelector('.editor').style.display = 'block';
    elem.closest("td").querySelector('.description-block').style.display = 'none';
}
</script>
