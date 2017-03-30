<?php

namespace Kanboard\Plugin\Metadata\Controller;

use Kanboard\Controller\DocumentationController;

/**
 * Metadata
 *
 * @package controller
 * @author  BlueTeck
 */
class MetadataDocumentationController extends DocumentationController {

    public function show()
    {
        $this->logger->info('METADATADOCUMENTATIONCONTROLLER SHOW');
        $page = $this->request->getStringParam('file', 'index');

        if (!preg_match('/^[a-z0-9\-]+/', $page)) {
            $page = 'index';
        }

        $filename = $this->getPageFilename($page);
        $this->response->html($this->helper->layout->app('doc/show', $this->render($filename)));
    }

    /**
     * Get Markdown file according to the current language
     *
     * @access protected
     * @param  string $page
     * @return string
     */
    protected function getPageFilename($page)
    {
        $this->logger->info('METADATADOCUMENTATIONCONTROLLER GETPAGEFILENAME');
        return implode(DIRECTORY_SEPARATOR, array(ROOT_DIR, 'plugins', 'Metadata', 'doc', 'en_US', 'custom-fields.markdown'));
    }

}
