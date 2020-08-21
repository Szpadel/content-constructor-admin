<?php

namespace MageSuite\ContentConstructorAdmin\Test\Unit\Block\Adminhtml\ContentConstructor;

class CmsPageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\ContentConstructorAdmin\Block\Adminhtml\ContentConstructor\CmsPage
     */
    protected $block;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryStub;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configurationProvider;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->configurationProvider = $this->getMockBuilder(\MageSuite\ContentConstructorAdmin\Block\Adminhtml\ContentConstructor\ConfigurationProvider::class)->getMock();
        $this->registryStub = $this->getMockBuilder(\Magento\Framework\Registry::class)->getMock();

        /** @var \MageSuite\ContentConstructorAdmin\Block\Adminhtml\ContentConstructor\CmsPage $block */
        $this->block = $this->objectManager->create(
            \MageSuite\ContentConstructorAdmin\Block\Adminhtml\ContentConstructor\CmsPage::class,
            [
                'configurationProvider' => $this->configurationProvider,
                'registry' => $this->registryStub
            ]
        );
    }

    public function testItReturnsCorrectConfiguratorUrl()
    {
        $this->assertEquals(
            'http://localhost/index.php/contentconstructor/component/configurator/type/{/component_type}',
            $this->block->getConfiguratorEndpointUrl()
        );
    }

    public function testItReturnsCorrectRestTokenEndpointUrl()
    {
        $this->assertEquals(
            'http://localhost/index.php/contentconstructor/token/generator/',
            $this->block->getRestTokenEndpoint()
        );
    }

    public function testItReturnsCorrectImageEndpointUrl()
    {
        $this->assertEquals(
            'http://localhost/index.php/contentconstructor/image/show/image/{/encoded_image}',
            $this->block->getImageEndpoint()
        );
    }

    public function testItReturnsCorrectCategoryDataProviderEntpointUrl() {
        $this->assertEquals(
            'http://localhost/index.php/contentconstructor/category/provider/',
            $this->block->getCategoryDataProviderEndpoint()
        );
    }

    public function testItReturnsCorrectUploaderUrl()
    {
       $url = $this->block->getUploaderUrl();

       if(method_exists($this, 'assertStringContainsString')) {
           $this->assertStringContainsString('http://localhost/index.php/backend/cms/wysiwyg_images/index/key/', $url);
       } else {
           $this->assertContains('http://localhost/index.php/backend/cms/wysiwyg_images/index/key/', $url);
       }
    }

    public function testItReturnsCorrectAdminPrefix()
    {
        $url = $this->block->getAdminPrefix();

        if(method_exists($this, 'assertStringContainsString')) {
            $this->assertStringContainsString('backend', $url);
        } else {
            $this->assertContains('backend', $url);
        }
    }

    public function testItReturnsCorrectJsonRepresentationOfConfiguration()
    {
        $this->configurationProvider->method('getExistingComponentsConfiguration')->willReturn(json_encode([['type' => 'headline', 'id' => '1']]));

        $this->assertEquals(
            '[{"type":"headline","id":"1"}]',
            $this->block->getExistingComponentsConfiguration()
        );
    }

    public function testItReturnsCorrectPageType() {
        $this->configurationProvider->method('getPageType')->willReturn('cms_page_form.cms_page_form');

        $this->assertEquals('cms_page_form.cms_page_form', $this->block->getPageType());
    }
}
