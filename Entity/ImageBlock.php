<?php

namespace Mdespeuilles\BlockBundle\Entity;

use AppBundle\Entity\Traits\Image1Trait;
use Mdespeuilles\LanguageBundle\Entity\Traits\LanguageEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ImageBlock
 *
 * @ORM\Table(name="image_block")
 * @ORM\Entity(repositoryClass="Mdespeuilles\BlockBundle\Repository\ImageBlockRepository")
 * @Vich\Uploadable
 */
class ImageBlock
{
    use Image1Trait;
    use LanguageEntity;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ImageBlock
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

