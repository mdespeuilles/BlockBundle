<?php

namespace Mdespeuilles\BlockBundle\Entity;

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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="file_fields", fileNameProperty="image1Name")
     *
     * @var File
     */
    private $image1File;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $image1Name;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $image1UpdatedAt;


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
    
    public function setImage1File(File $image = null)
    {
        $this->image1File = $image;
        
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->image1UpdatedAt = new \DateTime('now');
        }
        
        return $this;
    }
    
    /**
     * @return File
     */
    public function getImage1File()
    {
        return $this->image1File;
    }
    
    public function setImage1Name($imageName)
    {
        $this->image1Name = $imageName;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getImage1Name()
    {
        return $this->image1Name;
    }
    
    /**
     * @return \DateTime
     */
    public function getImage1UpdatedAt()
    {
        return $this->image1UpdatedAt;
    }
    
    /**
     * @param \DateTime $image1UpdatedAt
     */
    public function setImage1UpdatedAt($image1UpdatedAt)
    {
        $this->image1UpdatedAt = $image1UpdatedAt;
    }
}

