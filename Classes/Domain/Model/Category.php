<?php

namespace Nng\Nnhelpers\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

/**
 * This model represents a category (for anything).
 */
class Category extends AbstractEntity
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var \Nng\Nnhelpers\Domain\Model\Category|null
     */
    protected $parent;

    /**
     * Gets the title.
     *
     * @return string the title, might be empty
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title the title to set, may be empty
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Gets the description.
     *
     * @return string the description, might be empty
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description to set, may be empty
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Gets the parent category.
     *
     * @return \Nng\Nnhelpers\Domain\Model\Category|null the parent category
     */
    public function getParent()
    {
        if ($this->parent instanceof LazyLoadingProxy) {
            $this->parent->_loadRealInstance();
        }
        return $this->parent;
    }

    /**
     * Sets the parent category.
     *
     * @param \Nng\Nnhelpers\Domain\Model\Category $parent the parent category
     */
    public function setParent(\Nng\Nnhelpers\Domain\Model\Category $parent)
    {
        $this->parent = $parent;
    }
}
