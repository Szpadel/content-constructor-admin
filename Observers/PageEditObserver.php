<?php

namespace MageSuite\ContentConstructorAdmin\Observers;

use Magento\Cms\Model\Page;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;

class PageEditObserver implements ObserverInterface
{
    /**
     * @var \MageSuite\ContentConstructorAdmin\Repository\Xml\XmlToComponentConfigurationMapper
     */
    protected $xmlToComponentConfigurationMapper;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $cacheTypeList;

    /**
     * @var \MageSuite\ContentConstructorAdmin\Repository\Xml\ComponentConfigurationToXmlMapper
     */
    protected $configurationToXmlMapper;

    public function __construct(
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \MageSuite\ContentConstructorAdmin\Repository\Xml\ComponentConfigurationToXmlMapper $configurationToXmlMapper,
        \MageSuite\ContentConstructorAdmin\Repository\Xml\XmlToComponentConfigurationMapper $xmlToComponentConfigurationMapper
    )
    {
        $this->cacheTypeList = $cacheTypeList;
        $this->configurationToXmlMapper = $configurationToXmlMapper;
        $this->xmlToComponentConfigurationMapper = $xmlToComponentConfigurationMapper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var RequestInterface $request */
        $request = $observer->getData('request');
        /** @var Page $page */
        $page = $observer->getData('page');

        $data = $request->getPostValue();

        if (isset($data['components']) && !empty($data['components'])) {
            $components = json_decode($data['components'], true);
            $existingComponents = $page->getContentConstructorContent();

            $page->setContent('');

            if (!empty($components) || !empty($existingComponents)) {
                $page->setContentConstructorContent(json_encode($components));
            }
        }
    }
}
