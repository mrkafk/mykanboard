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


    /**
     * Get file location
     *
     * @access protected
     * @param  string $filename
     * @return string
     */
    protected function getFileLocation($filename)
    {
            return implode(DIRECTORY_SEPARATOR, array(ROOT_DIR, 'plugins', 'Metadata', 'doc', $filename));
    }

    /**
     * Get base URL for Markdown links
     *
     * @access protected
     * @param  string $filename
     * @return string
     */
    protected function getFileBaseUrl($filename)
    {
        $path = $this->getFileLocation($filename);
        $url = implode('/', array('plugins', 'Metadata', 'doc', $filename));
        return $this->helper->url->base().$url;
    }

}
