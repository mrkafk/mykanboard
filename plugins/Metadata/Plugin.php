<?php

namespace Kanboard\Plugin\Metadata;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base {

    public function initialize() {
        //Project
        $this->template->hook->attach('template:project:sidebar', 'metadata:project/sidebar');

        //Task
        $this->template->hook->attach('template:task:sidebar:information', 'metadata:task/sidebar');
        $this->template->hook->attach('template:board:task:icons', 'metadata:task/footer_icon');

        //@PLUG_CF
        $this->template->hook->attach('template:task:details:bottom', 'metadata:task/details',  array('variable' => 'foobar',));

        //User
        $this->template->hook->attach('template:user:sidebar:information', 'metadata:user/sidebar');


        // Add link to new plugin settings
        //$this->template->hook->attach('template:config:sidebar', 'Metadata:config/sidebar');

        $this->eventManager->register('model:task:creation:after', 'After task has been created');

        //@PLUG_CF_MD_EVENTS

        $this->hook->on('model:task:creation:after', array($this, 'checkTaskDefaultCustomFields'));
        $this->hook->on('model:task:modification:after_update', array($this, 'checkTaskDefaultCustomFields'));


    }

    public function checkTaskDefaultCustomFields(array &$values)
    {
            $task_id = $values['task_id'];
            if($task_id) {
                $this->logger->info('TASK_CREATE '.json_encode($values));
            }
            else {
                $this->logger->info('TASK_UPDATE '.json_encode($values));
                $task_id = $values['updated_task_id'];
            }
            $project_id = $values['project_id'];
            $project_metadata = $this->projectMetadataModel->getAll($project_id);
            $this->logger->info('projectMetadataModel: '.json_encode($project_metadata));
            $category_id = $values['category_id'];
            $category_name = $this->categoryModel->getNameById($category_id);
            // $categories_list = $this->categoryModel->getList($project_id);
            // $this->logger->info('category_id: '.$category_id);
            // $this->logger->info('category_name: '.$category_name);
            $this->addTaskDefaultCustomFields($task_id, $category_name, $project_metadata);
    }

    public function addTaskDefaultCustomFields($task_id, $category_name, $project_metadata )
    {
            foreach($project_metadata as $k => $v) {
                // $this->logger->info('p_m: k '.$k.' v '.$v);
                $cat_name_len = strlen($category_name);
                if(strncasecmp($k, $category_name, $cat_name_len) === 0) {
                    // $custom_field_name = substr($k, $cat_name_len+1, strlen($k));
                    // $this->logger->info('BINGO: category_name '.$category_name.' k '.$k.' v '.$v.' custom_field_name '.$custom_field_name);
                    if(!$this->taskMetadataModel->exists($task_id, $k)) {
                        $this->logger->info('FIELD NOT FOUND: k '.$k);
                        $this->taskMetadataModel->save($task_id, [$k => $v]);
                    }
                }
            }
    }

    public function onStartup()
    {
        // Translation
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses() {
        return array(
            'Plugin\Metadata\Model' => array(
                'MetadataTypeModel',
            )
        );
    }

    public function getPluginName() {
        return 'Metadata';
    }

    public function getPluginDescription() {
        return t('Manage Metadata');
    }

    public function getPluginAuthor() {
        return 'BlueTeck + Daniele Lenares';
    }

    public function getPluginVersion() {
        return '1.0.33.1';
    }

    public function getPluginHomepage() {
        return 'https://github.com/BlueTeck/kanboard_plugin_metadata';
    }

}
