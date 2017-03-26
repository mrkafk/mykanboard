<div class="page-header">
    <h2><?= t('Custom Fields') ?></h2>
</div>


<?php  $metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (empty($metadata)): ?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-40"><?= t('Key') ?></th>
        <th class="column-40"><?= t('Value') ?></th>
        <th class="column-20"><?= t('Action') ?></th>
    </tr>
    <?php foreach ($metadata as $key => $value): ?>
    <tr>
        <td><?= $key ?></td>
        <td><?= $value ?></td>
        <td>
            <ul>
                <li>
                    <?= $this->url->link(t('Remove'), 'MetadataController', 'confirmTask', array('plugin' => 'metadata','task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key ), false, 'popover') ?>
                </li>
                <li>
                    <?= $this->url->link(t('Edit'), 'MetadataController', 'editTask', array('plugin' => 'metadata','task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key ), false, 'popover') ?>
                </li>
            </ul>
        </td>
    </tr>
    <?php endforeach ?>
    </table>

@PLUG_ADDCSTFLD
<?= $this->render('metadata:task/form', array('task' => $task, 'project' => $project, 'form_headline' => t('Add Custom Field'), 'values' => array())) ?>
<?php endif ?>
