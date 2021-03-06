<?php

namespace MageSuite\ContentConstructorAdmin\Observers;

class BrandEditObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \MageSuite\ContentConstructorAdmin\Repository\Xml\ComponentConfigurationToXmlMapper
     */
    protected $configurationToXmlMapper;

    public function __construct(\MageSuite\ContentConstructorAdmin\Repository\Xml\ComponentConfigurationToXmlMapper $configurationToXmlMapper)
    {
        $this->configurationToXmlMapper = $configurationToXmlMapper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $params = $observer->getData('params');

        /** @var \MageSuite\BrandManagement\Model\Brands $brand */
        $brand = $observer->getData('brand');

        if (isset($params['components']) && !empty($params['components'])) {
            $components = json_decode($params['components'], true);

            $layoutUpdateXml = $this->configurationToXmlMapper->map($components, $brand->getLayoutUpdateXml());

            $brand->setLayoutUpdateXml($layoutUpdateXml);
        }
    }
}
