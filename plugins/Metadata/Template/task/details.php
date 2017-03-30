<div class="page-header">
    <h2><?= t('Category and Custom Fields') ?></h2>
</div>


<?php  $metadata = $this->task->taskMetadataModel->getAll($task['id']);

$project_id = $task['project_id'];
$category_id = $task['category_id'];
$category_name = $this->task->categoryModel->getNameById($category_id);
$all_project_categories = $this->task->categoryModel->getAll($project_id);
$inapplicable_categories = array();
foreach($all_project_categories as $cat) {
    $cat_name = $cat['name'];
    if(strcmp($cat_name, $category_name) != 0)
        array_push($inapplicable_categories, $cat_name);
}

// $this->task->logger->info('TASK_CUSTOM_FIELDS all_project_categories '.json_encode($all_project_categories).' category_name '.json_encode($category_name)
// .' inapplicable_categories '.json_encode($inapplicable_categories));


if (empty($metadata)): ?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-40"><?= t('Key') ?></th>
        <th class="column-40"><?= t('Value') ?></th>
        <th class="column-20"><?= t('Action') ?></th>
    </tr>
    <?php
    foreach ($metadata as $key => $value):
        $cf_cat = explode('_', $key)[0];
        if(in_array($cf_cat, $inapplicable_categories)) {
            $this->task->logger->info('TASK_CUSTOM_FIELDS skip displaying task metadata for this category '.json_encode($category_name).' key '.json_encode($key));
            continue;
        }
    ?>
    <tr>
        <td>
        <?php
        $prefix = substr($key, 0, strlen($category_name));
        if($prefix === $category_name): ?>
            <span style="color:grey"><?=$prefix?>_</span><?= substr($key, strlen($cf_cat) + 1) ?>
        <?php else: ?>
            <?= $key ?>
        <?php endif ?>

        </td>

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

<!--@PLUGIN_CUSTOM_FIELDS-->
<?= $this->render('metadata:task/form', array('task' => $task, 'project' => $project, 'form_headline' => t('Add Custom Field'), 'values' => array())) ?>

<?= $this->url->icon('life-ring', t('Documentation on Category and Custom Fields'), 'MetadataDocumentationController', 'show', array('plugin' => 'metadata', 'file' => 'custom-fields')) ?>

<?php endif ?>
