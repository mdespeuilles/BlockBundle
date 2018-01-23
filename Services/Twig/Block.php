<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 13/06/2016
 * Time: 15:36
 */

namespace Mdespeuilles\BlockBundle\Services\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Block extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * VotingSecureKey constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getBlock',  array($this, 'getBlock'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('getImageBlock',  array($this, 'getImageBlock'), array('is_safe' => array('html'))),
        );
    }
    
    /**
     * @param $id
     * @return null
     */
    public function getBlock($id)
    {
        $languagePrefix = $this->container->get('request_stack')->getCurrentRequest()->getLocale();
        $language = $this->container->get("mdespeuilles.entity.language")->findOneBy([
            'prefix' => $languagePrefix
        ]);
        /* @var \AppBundle\Entity\Block $block */
        $block = $this->container->get("mdespeuilles.entity.block")->findOneBy([
            "id" => $id,
            "language" => $language
        ]);
    
        $adminLink = false;
    
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $path = $this->container->get('router')->generate("easyadmin", [
                'entity' => 'Block',
                'id' => $block->getId(),
                'action' => 'edit'
            ]);
            $adminLink = "<a href=".$path." target='_blank' style='font-size: 12px;display: inline;'>edit</a>";
        }

        if (!$block) {
            $askedBlock = $this->container->get("mdespeuilles.entity.block")->find($id);
            foreach($askedBlock->getTranslations() as $translation) {
                if ($translation->getLanguage()->getPrefix() == $languagePrefix) {
                    return $translation->getBody().$adminLink;
                }
            }
        }

        return ($block) ? $block->getBody().$adminLink : null;
    }

    public function getImageBlock($id, $style = null)
    {
        $block = $this->container->get("mdespeuilles.entity.image_block")->find($id);
        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($block, 'image1File');
    
        $adminLink = false;
    
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $adminpath = $this->container->get('router')->generate("easyadmin", [
                'entity' => 'Block',
                'id' => $block->getId(),
                'action' => 'edit'
            ]);
            $adminLink = "<a href=".$adminpath." target='_blank' style='font-size: 12px;display: inline;'>edit</a>";
        }

        if ($style) {
            $imagineCacheManager = $this->container->get('liip_imagine.cache.manager');
            $path = $imagineCacheManager->getBrowserPath($path, $style);
        }

        $alt = $block->getTitle();

        return "<img src='$path' alt='$alt'/>" . $adminLink;
    }

    public function getName()
    {
        return 'getBlock';
    }
}