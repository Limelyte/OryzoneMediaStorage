<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Provider;

use Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Context\Context;

//use Symfony\Component\Form\FormBuilderInterface;

interface ProviderInterface
{
    /**
     * Content type for file based providers
     */
    const CONTENT_TYPE_FILE = 0;

    /**
     * Content type for providers who use integer ids (numerical ids, like vimeo)
     */
    const CONTENT_TYPE_INT = 1;

    /**
     * Content type for providers who use string ids (like youtube)
     */
    const CONTENT_TYPE_STRING = 2;

    /**
     * Gets the name of the provider
     *
     * @return string
     */
    public function getName();

    /**
     * Get the content type of the current provider
     *
     * @return int
     */
    public function getContentType();


    /**
     * Sets an array of options for the provider
     *
     * @param array $options
     * @return void
     */
    public function setOptions($options);

    /**
     * Detects if the current content is a new one (used in case of update)
     *
     * @param \Oryzone\MediaStorage\Model\Media $media
     *
     * @return boolean
     */
    public function hasChangedContent(Media $media);

    /**
     * Checks if the current provider supports a given Media
     *
     * @param mixed $content
     *
     * @return boolean
     */
    public function validateContent($content);

    /**
     * Executed each time a media is about to be saved, before the process method
     * Generally used to set metadata
     *
     * @param \Oryzone\MediaStorage\Model\Media     $media
     * @param \Oryzone\MediaStorage\Context\Context $context
     *
     * @return mixed
     */
    public function prepare(Media $media, Context $context);

    /**
     * Process the media to create a variant. Should return a <code>File</code> instance referring
     * the resulting file
     *
     * @param \Oryzone\MediaStorage\Model\Media              $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param \SplFileInfo                                   $source
     *
     * @return File|null
     */
    public function process(Media $media, VariantInterface $variant, \SplFileInfo $source = NULL);

    /**
     * Renders a variant to HTML code. Useful for twig (or other template engines) integrations
     *
     * @param \Oryzone\MediaStorage\Model\Media              $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param string|null                                    $url
     * @param array                                          $options
     *
     * @return string
     */
    public function render(Media $media, VariantInterface $variant, $url = NULL, $options = array());

    /**
     * Builds a form to handle the media
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $formBuilder
     * @param array $options
     * @return mixed
     */
    //public function buildMediaType(FormBuilderInterface $formBuilder, array $options = array());

    /**
     * Transforms a media (from a form)
     *
     * @param \Oryzone\MediaStorage\Model\Media $media
     * @return mixed
     */
    //public function transform(Media $media);

    /**
     * Removes any temp file stored by the current provider instance
     */
    public function removeTempFiles();

}