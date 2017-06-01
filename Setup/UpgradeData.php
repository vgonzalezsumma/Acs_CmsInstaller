<?php

namespace Acs\CmsInstaller\Setup;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var PageInterfaceFactory
     */
    protected $pageInterfaceFactory;

    /**
     * @var BlockRepositoryInterface
     */
    protected $blockRepository;
    /**
     * @var BlockInterfaceFactory
     */
    protected $blockInterfaceFactory;

    /**
     * @var BlockInterface
     */
    protected $blockInterface;

    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var EavSetupFactory
     */
    protected $writeInterface;

    protected $setup;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory,
        BlockInterface $blockInterface,
        EavSetupFactory $eavSetupFactory,
        WriterInterface $writerInterface,
        PageRepositoryInterface $pageRepository,
        PageInterfaceFactory $pageInterfaceFactory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
        $this->blockInterface = $blockInterface;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->writerInterface = $writerInterface;
        $this->pageRepository = $pageRepository;
        $this->pageInterfaceFactory = $pageInterfaceFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;
        $this->setup->startSetup();


        // Example CMS Block Call
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
        $blockHtmlContent = <<<HTML
<h3 class="label">Refunds</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Exchanges</h3>
<div class="content">
    Habitasse varius cubilia eros aliquam integer ullamcorper malesuada vulputate ac a a nascetur mi accumsan scelerisque faucibus inceptos a hac fermentum rhoncus semper a scelerisque nisi a parturient. Mi pulvinar parturient tristique est neque parturient nunc suspendisse torquent porttitor ullamcorper dui ullamcorper litora vestibulum a gravida pretium quis nam mauris aliquam bibendum. Vulputate a at lobortis massa eu potenti suspendisse elementum ac tempus vestibulum venenatis magnis mollis facilisi parturient per mi. Venenatis id ridiculus tempus id lorem felis amet a a diam a volutpat eu a et habitasse pretium eu quisque dolor a. Bibendum blandit cubilia montes nisi ultrices parturient mi consectetur sed ullamcorper mus senectus at consectetur hac nam a posuere condimentum adipiscing dui donec vivamus dictumst eget aliquet parturient. Taciti tempus in elit vulputate orci conubia proin consectetur vulputate porttitor ridiculus porttitor mauris cum consequat nisl curae a nisl habitant adipiscing. 
    Metus vestibulum lobortis a hac cubilia mollis pulvinar vestibulum consectetur primis netus magna volutpat vestibulum libero vel parturient a blandit pretium a curabitur parturient. Suspendisse duis a vestibulum inceptos augue condimentum ornare adipiscing curabitur etiam mauris ullamcorper ullamcorper vestibulum cum placerat lectus. Nisl lobortis commodo morbi hac ullamcorper at porttitor ante mollis morbi habitant orci ridiculus phasellus nullam suspendisse ullamcorper et. <br> <br>
    Litora neque parturient consectetur facilisis a erat diam morbi euismod adipiscing senectus condimentum adipiscing phasellus ad scelerisque velit habitasse senectus imperdiet quam ante dictumst. Dis nascetur a lectus aptent nam at turpis torquent nam scelerisque pulvinar ullamcorper condimentum non magna a potenti nisl bibendum imperdiet vestibulum eros consectetur. Laoreet phasellus vestibulum curae laoreet luctus rutrum aliquam mi placerat a a parturient a condimentum suspendisse est sodales adipiscing vestibulum arcu ut cubilia.  <br> <br>
    Dolor fermentum himenaeos est massa hac arcu nullam imperdiet at mollis cras fusce dignissim vestibulum porttitor velit suspendisse tempor nunc ac natoque a nunc condimentum adipiscing a ullamcorper. Arcu semper lacinia duis libero amet velit suspendisse donec integer cras mauris consectetur consectetur nisl rhoncus a condimentum. Consectetur habitasse dapibus vestibulum facilisi dictum mauris dis mattis dis lectus ullamcorper penatibus vestibulum ullamcorper potenti montes a parturient leo scelerisque nec malesuada faucibus adipiscing molestie. <br> <br>
</div>
<h3 class="label">Placing Orders</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Resetting Passwords</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Canceling Orders</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
HTML;
            $this->createCmsBlock('cms-block-help', $blockHtmlContent, 'Help');

        $blockHtmlContent = <<<HTML
<h3 class="label">Refunds</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Exchanges</h3>
<div class="content">
    Habitasse varius cubilia eros aliquam integer ullamcorper malesuada vulputate ac a a nascetur mi accumsan scelerisque faucibus inceptos a hac fermentum rhoncus semper a scelerisque nisi a parturient. Mi pulvinar parturient tristique est neque parturient nunc suspendisse torquent porttitor ullamcorper dui ullamcorper litora vestibulum a gravida pretium quis nam mauris aliquam bibendum. Vulputate a at lobortis massa eu potenti suspendisse elementum ac tempus vestibulum venenatis magnis mollis facilisi parturient per mi. Venenatis id ridiculus tempus id lorem felis amet a a diam a volutpat eu a et habitasse pretium eu quisque dolor a. Bibendum blandit cubilia montes nisi ultrices parturient mi consectetur sed ullamcorper mus senectus at consectetur hac nam a posuere condimentum adipiscing dui donec vivamus dictumst eget aliquet parturient. Taciti tempus in elit vulputate orci conubia proin consectetur vulputate porttitor ridiculus porttitor mauris cum consequat nisl curae a nisl habitant adipiscing. 
    Metus vestibulum lobortis a hac cubilia mollis pulvinar vestibulum consectetur primis netus magna volutpat vestibulum libero vel parturient a blandit pretium a curabitur parturient. Suspendisse duis a vestibulum inceptos augue condimentum ornare adipiscing curabitur etiam mauris ullamcorper ullamcorper vestibulum cum placerat lectus. Nisl lobortis commodo morbi hac ullamcorper at porttitor ante mollis morbi habitant orci ridiculus phasellus nullam suspendisse ullamcorper et. <br> <br>
    Litora neque parturient consectetur facilisis a erat diam morbi euismod adipiscing senectus condimentum adipiscing phasellus ad scelerisque velit habitasse senectus imperdiet quam ante dictumst. Dis nascetur a lectus aptent nam at turpis torquent nam scelerisque pulvinar ullamcorper condimentum non magna a potenti nisl bibendum imperdiet vestibulum eros consectetur. Laoreet phasellus vestibulum curae laoreet luctus rutrum aliquam mi placerat a a parturient a condimentum suspendisse est sodales adipiscing vestibulum arcu ut cubilia.  <br> <br>
    Dolor fermentum himenaeos est massa hac arcu nullam imperdiet at mollis cras fusce dignissim vestibulum porttitor velit suspendisse tempor nunc ac natoque a nunc condimentum adipiscing a ullamcorper. Arcu semper lacinia duis libero amet velit suspendisse donec integer cras mauris consectetur consectetur nisl rhoncus a condimentum. Consectetur habitasse dapibus vestibulum facilisi dictum mauris dis mattis dis lectus ullamcorper penatibus vestibulum ullamcorper potenti montes a parturient leo scelerisque nec malesuada faucibus adipiscing molestie. <br> <br>
</div>
HTML;
            $this->createCmsBlock('cms-block-designtool-help', $blockHtmlContent, 'Designtool Help');
/*
        $blockHtmlContent = <<<HTML
uiju
HTML;
            $this->createCmsPage('cms-test5', $blockHtmlContent, 'lalalalal');*/
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $blockHtmlContent = <<<HTML
<h3 class="label">Refunds</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Exchanges</h3>
<div class="content">
    Habitasse varius cubilia eros aliquam integer ullamcorper malesuada vulputate ac a a nascetur mi accumsan scelerisque faucibus inceptos a hac fermentum rhoncus semper a scelerisque nisi a parturient. Mi pulvinar parturient tristique est neque parturient nunc suspendisse torquent porttitor ullamcorper dui ullamcorper litora vestibulum a gravida pretium quis nam mauris aliquam bibendum. Vulputate a at lobortis massa eu potenti suspendisse elementum ac tempus vestibulum venenatis magnis mollis facilisi parturient per mi. Venenatis id ridiculus tempus id lorem felis amet a a diam a volutpat eu a et habitasse pretium eu quisque dolor a. Bibendum blandit cubilia montes nisi ultrices parturient mi consectetur sed ullamcorper mus senectus at consectetur hac nam a posuere condimentum adipiscing dui donec vivamus dictumst eget aliquet parturient. Taciti tempus in elit vulputate orci conubia proin consectetur vulputate porttitor ridiculus porttitor mauris cum consequat nisl curae a nisl habitant adipiscing. 
    Metus vestibulum lobortis a hac cubilia mollis pulvinar vestibulum consectetur primis netus magna volutpat vestibulum libero vel parturient a blandit pretium a curabitur parturient. Suspendisse duis a vestibulum inceptos augue condimentum ornare adipiscing curabitur etiam mauris ullamcorper ullamcorper vestibulum cum placerat lectus. Nisl lobortis commodo morbi hac ullamcorper at porttitor ante mollis morbi habitant orci ridiculus phasellus nullam suspendisse ullamcorper et. <br> <br>
    Litora neque parturient consectetur facilisis a erat diam morbi euismod adipiscing senectus condimentum adipiscing phasellus ad scelerisque velit habitasse senectus imperdiet quam ante dictumst. Dis nascetur a lectus aptent nam at turpis torquent nam scelerisque pulvinar ullamcorper condimentum non magna a potenti nisl bibendum imperdiet vestibulum eros consectetur. Laoreet phasellus vestibulum curae laoreet luctus rutrum aliquam mi placerat a a parturient a condimentum suspendisse est sodales adipiscing vestibulum arcu ut cubilia.  <br> <br>
    Dolor fermentum himenaeos est massa hac arcu nullam imperdiet at mollis cras fusce dignissim vestibulum porttitor velit suspendisse tempor nunc ac natoque a nunc condimentum adipiscing a ullamcorper. Arcu semper lacinia duis libero amet velit suspendisse donec integer cras mauris consectetur consectetur nisl rhoncus a condimentum. Consectetur habitasse dapibus vestibulum facilisi dictum mauris dis mattis dis lectus ullamcorper penatibus vestibulum ullamcorper potenti montes a parturient leo scelerisque nec malesuada faucibus adipiscing molestie. <br> <br>
</div>
<h3 class="label">Placing Orders</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Resetting Passwords</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Canceling Orders</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
HTML;
            $this->createCmsBlock('cms-block-help', $blockHtmlContent, 'Help');

            $blockHtmlContent = <<<HTML
<h3 class="label">Refunds</h3>
<div class="content">
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
</div>
<h3 class="label">Exchanges</h3>
<div class="content">
    Habitasse varius cubilia eros aliquam integer ullamcorper malesuada vulputate ac a a nascetur mi accumsan scelerisque faucibus inceptos a hac fermentum rhoncus semper a scelerisque nisi a parturient. Mi pulvinar parturient tristique est neque parturient nunc suspendisse torquent porttitor ullamcorper dui ullamcorper litora vestibulum a gravida pretium quis nam mauris aliquam bibendum. Vulputate a at lobortis massa eu potenti suspendisse elementum ac tempus vestibulum venenatis magnis mollis facilisi parturient per mi. Venenatis id ridiculus tempus id lorem felis amet a a diam a volutpat eu a et habitasse pretium eu quisque dolor a. Bibendum blandit cubilia montes nisi ultrices parturient mi consectetur sed ullamcorper mus senectus at consectetur hac nam a posuere condimentum adipiscing dui donec vivamus dictumst eget aliquet parturient. Taciti tempus in elit vulputate orci conubia proin consectetur vulputate porttitor ridiculus porttitor mauris cum consequat nisl curae a nisl habitant adipiscing. 
    Metus vestibulum lobortis a hac cubilia mollis pulvinar vestibulum consectetur primis netus magna volutpat vestibulum libero vel parturient a blandit pretium a curabitur parturient. Suspendisse duis a vestibulum inceptos augue condimentum ornare adipiscing curabitur etiam mauris ullamcorper ullamcorper vestibulum cum placerat lectus. Nisl lobortis commodo morbi hac ullamcorper at porttitor ante mollis morbi habitant orci ridiculus phasellus nullam suspendisse ullamcorper et. <br> <br>
    Litora neque parturient consectetur facilisis a erat diam morbi euismod adipiscing senectus condimentum adipiscing phasellus ad scelerisque velit habitasse senectus imperdiet quam ante dictumst. Dis nascetur a lectus aptent nam at turpis torquent nam scelerisque pulvinar ullamcorper condimentum non magna a potenti nisl bibendum imperdiet vestibulum eros consectetur. Laoreet phasellus vestibulum curae laoreet luctus rutrum aliquam mi placerat a a parturient a condimentum suspendisse est sodales adipiscing vestibulum arcu ut cubilia.  <br> <br>
    Dolor fermentum himenaeos est massa hac arcu nullam imperdiet at mollis cras fusce dignissim vestibulum porttitor velit suspendisse tempor nunc ac natoque a nunc condimentum adipiscing a ullamcorper. Arcu semper lacinia duis libero amet velit suspendisse donec integer cras mauris consectetur consectetur nisl rhoncus a condimentum. Consectetur habitasse dapibus vestibulum facilisi dictum mauris dis mattis dis lectus ullamcorper penatibus vestibulum ullamcorper potenti montes a parturient leo scelerisque nec malesuada faucibus adipiscing molestie. <br> <br>
</div>
HTML;
            $this->createCmsBlock('cms-block-designtool-help', $blockHtmlContent, 'Designtool Help');

            $blockHtmlContent = <<<HTML
<div class="no-orders-dashboardTab-message-block">
<div class="no-orders-dashboardTab-message-container">
<p class="message">You have no recent orders.</p>
</div>
</div>
HTML;
            $this->createCmsBlock('no-orders-dashboardTab-message', $blockHtmlContent, 'My Account Dashboard Tab - No Recent Orders Message');

            $blockHtmlContent = <<<HTML
<div class="no-designs-dashboardTab-message-block">
<div class="no-designs-dashboardTab-message-container">
<p class="message">You have no recent designs. <a class="action primary" href="#customizer"> Create a design now.</a></p>
</div>
</div>
HTML;
            $this->createCmsBlock('no-designs-dashboardTab-message', $blockHtmlContent, ' My Account Dashboard Tab - No Recent Designs Message');

            $blockHtmlContent = <<<HTML
<div class="no-orders-ordersTab-message-block">
<div class="no-orders-ordersTab-message-container">
<p class="message">You have no recent orders.</p>
</div>
</div>
HTML;
            $this->createCmsBlock('no-orders-ordersTab-message', $blockHtmlContent, 'My Account Orders Tab - No Recent Orders Message');

            $blockHtmlContent = <<<HTML
<div class="no-designs-designsTab-message-block">
<div class="no-designs-designsTab-message-container">
<p class="message">You have no recent designs. <a class="action primary" href="#">Create a design now.</a></p>
</div>
</div>
HTML;
            $this->createCmsBlock('no-designs-designsTab-message', $blockHtmlContent, ' My Account Designs Tab - No Recent Designs Message');

            $blockHtmlContent = <<<HTML
<div class="no-funds-dashboardTab-message-block">
<div class="no-funds-dashboardTab-message-container">
<p class="message">You have no recent funds.</p>
</div>
</div>
HTML;
            $this->createCmsBlock('no-funds-dashboardTab-message', $blockHtmlContent, 'My Account Dashboard Tab - No Recent Funds Message');
            /*
                    $blockHtmlContent = <<<HTML
            uiju
            HTML;
                        $this->createCmsPage('cms-test5', $blockHtmlContent, 'lalalalal');*/
        }
        $this->setup->endSetup();
    }

    public function setConfigData($path, $value){
        $this->writerInterface->save($path, $value);
    }

    public function createAttributeProduct($attrId, $options){

        // Options Example
        /*[
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Input Label',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => 0,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ]*/

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        $this->createAttribute($eavSetup);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            $attrId,
            $options
        );
    }

    /**
     * Create CMS blocks
     */
    public function createCmsBlock($id, $html = '', $title = '', $stores = [0])
    {        
        try {
            $cmsBlock = $this->blockRepository->getById($id);
            if ($title){
                $cmsBlock->setTitle($title);
            }
            if ($html){
                $cmsBlock->setContent($html);
            }
            
        } catch (NoSuchEntityException $ex) {
            $cmsBlock = $this->blockInterfaceFactory->create();
            
            $cmsBlock->setTitle($title)
                     ->setIdentifier($id)
                     ->setStores($stores)
                     ->setContent($html);        
        }
        
        $this->blockRepository->save($cmsBlock);
    }

    public function createCmsPage($id, $html = '', $title = '' , $extraOptions = [], $stores = [0])
    {
         try {
            $cmsPage = $this->pageRepository->getById($id);
            if ($html){
                $cmsPage->setContent($html);
            }
            if ($title){
                $cmsPage->setTitle($title);
            }            
        } catch (NoSuchEntityException $ex) {
            $cmsPage = $this->pageInterfaceFactory->create();
            $cmsPage->setIdentifier($id)
                ->setTitle($title)
                ->setContent($html)
                ->setMetaTitle($title)
                ->setMetaKeywords($title)
                ->setMetaDescription($title)
                ->setPageLayout('1column')
                ->setLayoutUpdateXml('')
                ->setStores($stores)
                ->setIsActive(true);
        }

        if (count($extraOptions)){
            $data = $cmsPage->getData();
            foreach ($extraOptions as $key => $value){
                $data[$key] = $value;
            }
            $cmsPage->setData($data);
        }

        $this->pageRepository->save($cmsPage);
    }

}