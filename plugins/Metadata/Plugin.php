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

        //@PLUG_MMM
        $this->template->hook->attach('template:task:details:bottom', 'metadata:task/details',  array('variable' => 'foobar',));

        //User
        $this->template->hook->attach('template:user:sidebar:information', 'metadata:user/sidebar');


        // Add link to new plugin settings
        //$this->template->hook->attach('template:config:sidebar', 'Metadata:config/sidebar');

        $this->logger->info('START434');

        $this->eventManager->register('model:task:creation:after', 'After task has been created');

        //@PLUG_MD_EVENTS
        $this->hook->on('model:task:creation:prepare', array($this, 'beforeSave'));

        $this->hook->on('model:task:creation:after', array($this, 'afterSave'));


    }

    public function beforeSave(array &$values)
    {
        $values = $this->dateParser->convert($values, array('due_date'));
            $this->logger->info('TASK_BEFORESAVE999');
            $this->logger->info($values);

    }

    public function afterSave(array &$values)
    {
            $this->logger->info('TASK_CREATE_AFTER888');
            $this->logger->info($values);
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
