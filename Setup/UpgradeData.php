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
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
        $blockHtmlContent = <<<HTML
<div class="block">
    <div class="accordion-ui-title">Orders and Shipping</div>
    <div class="accordion-ui">
        <h3 class="label">What shipping methods are available and how much does shipping cost?</h3>
        <div class="content">You may choose from standard (1-5 day), 2nd day, or next day shipping. Shipping costs vary by your ship-to location and are the standard rates charged by the carrier for the method you select. The carrier we use may vary, though we will always use a shipping method that meets the standard, 2nd day, or next day expectation you select.</div>
        <h3 class="label">When will I receive my order?</h3>
        <div class="content">Please allow time for us to process and prepare your order, and time for delivery once shipped. Processing time varies by product and takes longer for customized products. Delivery time varies by the shipping method you select and your distance from our fulfillment location.</div>
        <h3 class="label">Where can I track my package?</h3>
        <div class="content">Your shipping confirmation email contains the tracking number for your order. Alternatively, you may log in to shop.cancer.org and click on My Account. Then go to My Orders to find tracking numbers for your order(s).</div>
        <h3 class="label">How can I pay for my order? </h3>
        <div class="content">All orders must be paid by credit card or PayPal. For credit card orders, you card will be authorized at the time your order is placed, then charged when your order ships. For PayPal orders, your PayPal account will be charged at the time your order is placed.</div>
        <h3 class="label">Will I be charged sales tax on my order?</h3>
        <div class="content">You will either be charged sales tax, or you will be responsible for paying a use tax to your state. Although non-profit organizations are exempt from corporate income taxes, they must collect and remit sales tax no differently than for-profit companies. </div>
        <h3 class="label">Can I place an order for delivery outside the United States?</h3>
        <div class="content">At this time, we do not fulfill orders to countries outside the United States.</div>
    </div>
</div>
<div class="block">
    <div class="accordion-ui-title">Customer Service</div>
    <div class="accordion-ui">
        <h3 class="label">How Do I Contact Customer Service about my order?</h3>
        <div class="content">If you have any questions concerning your order, please contact us at 888.XXX.XXXX. Our Customer Service Team is available Monday through Friday from 9:00 a.m. to 5:00 p.m. Eastern Standard Time (EST). To expedite service, please have your order number ready. </div>
        <h3 class="label">How can I change or cancel my order?</h3>
        <div class="content">To change or cancel an order, please contact us immediately at 888.XXX.XXXX. We will take all reasonable steps to accommodate your request. Please note that if your order is for a customized product that has already been produced, or if your order has already shipped, we will not be able to make changes.</div>
        <h3 class="label">Can I return or exchange merchandise?</h3>
        <div class="content">We strive to satisfy our customers. If your order contains defective merchandise, please contact us at 888.XXX.XXXX to arrange for replacement merchandise or a refund. You may return or exchange items for other reasons as well, though we ask you to please understand that you will be responsible for shipping costs.</div>
    </div>
</div>
<div class="block">
    <div class="accordion-ui-title">Product Customization</div>
    <div class="accordion-ui">
        <h3 class="label">How do I make use of the Product Customization tools on the website?</h3>
        <div class="content">For a complete description of how to customize products, please view our Product Customization Help page.</div>
        <h3 class="label">How do I use my custom product to raise funds for my event or team?</h3>
        <div class="content">When you create your custom design, you will associate it to your event (for Making Strides Against Breast Cancer) or team (for Relay For Life). After that the proceeds from sales (price minus cost) will flow to your fundraising event or team dashboard. <br><br>
        Please note that the current event year ends August 31, 2017 for Relay For Life or December 31, 2017 for Making Strides. After that date, items may still be purchased, but proceeds will no longer flow to your 2017 event fundraising goals.”.</div>
    </div>
</div>
<div class="block">
    <div class="accordion-ui-title">My Account</div>
    <div class="accordion-ui">
        <h3 class="label">Do I need to create an account to shop?</h3>
        <div class="content">You may check out as a guest on Shop.Cancer.org. We will still need your email address so that we can send you order and shipping confirmation emails. We recommend that you create an though since this will enable you to see your order history, easily find and print receipts, and find your tracking information in a single location. To customize a product, you will be required to have an account.</div>
        <h3 class="label">How do I create an account?</h3>
        <div class="content">
            First, determine whether you already have an account. Shop.Cancer.org participates in the American Cancer Society’s single sign-on program called Society Account. Here is a list of websites that use Society Account:
            <ul class="bullets with-padding">
                <li>Making Strides Against Breast Cancer (<a href="http://makingstrideswalk.org" target="_blank">makingstrideswalk.org</a>)</li>
                <li>Relay For Life (<a href="http://relayforlife.org" target="_blank">relayforlife.org</a>)</li>
                <li>ACS Mobile Fundraising (<a href="http://acsfundraising.cancer.org" target="_blank">acsfundraising.cancer.org</a>, ACS Mobile App)</li>
                <li>Relay Nation (<a href="http://relaynation.org" target="_blank">relaynation.org</a>)</li>
                <li>DeterminNation (<a href="http://determination.acsevents.org" target="_blank">determination.acsevents.org</a>)</li>
                <li>Active For Life (<a href="http://activeforlife.org" target="_blank">activeforlife.org</a>)</li>
                <li>Service Match (<a href="http://servicematch.cancer.org" target="_blank">servicematch.cancer.org</a>)</li>
                <li>Volunteer Learning Center (<a href="http://volunteerlearning.cancer.org" target="_blank">volunteerlearning.cancer.org</a>)</li>
                <li>Societysource (<a href="http://mysocietysource.org" target="_blank">mysocietysource.org</a>)</li>
            </ul>
        </div>
        <h3 class="label">If you already have an account to sign into Relay For Life or Making Strides Against Breast Cancer, you should use that same account to sign into Shop.Cancer.org.</h3>
        <div class="content">If you do not yet have a Society Account, go to the <a href="https://accounts.cancer.org/register" target="_blank">Create My Society Account</a> page and follow the instructions.</div>
        <h3 class="label">I forgot my password, how can I reset it?</h3>
        <div class="content">Please go to the <a href="https://accounts.cancer.org/forgotpassword" target="_blank">Forgot Password</a> tool and follow the instructions.</div>
    </div>
</div>
HTML;
            $this->createCmsBlock('cms-block-help', $blockHtmlContent, 'Help');

        $blockHtmlContent = <<<HTML
<h3 class="label">How do I design a custom team shirt?</h3>
<div class="content">We have prepared a&nbsp;series of videos you can watch to see the design process illustrated. <video preload="none" controls="controls" src="{{media url="wysiwyg/video/1920x1080.mp4"}}"></video> You may follow the simple version to add your team name to the back of your shirts, or you may follow the videos on how to create a fully custom shirt design.</div>
<h3 class="label">I have an .eps file or a .psd&nbsp;file I want to use for my shirt, but those formats aren&rsquo;t accepted in the design tool. What should I do?</h3>
<div class="content">An .eps file or a .psd&nbsp;file with can be opened into Photoshop,&nbsp;then&nbsp;saved as a .png. This will format the file so that it can be uploaded to a shirt design. Also, if your image has a transparent background, this will maintain the transparency in your shirt design.&nbsp;</div>
<h3 class="label">I have an image file that is a low resolution that I want to use for my shirt. Can I still use it?</h3>
<div class="content">If the image is low resolution you may still use it. However, the quality of the final product may not be what you&rsquo;re looking for. For quality assurance, please use images that are high enough resolution to produce a quality product.</div>
<h3 class="label">My image has a white background that I don&rsquo;t want to appear on my shirt. How can I make the image appear flush against the shirt?</h3>
<div class="content">You may be able to use widely available tools including MS Paint and Microsoft Word to remove the unwanted background. <video preload="none" controls="controls" src="{{media url="wysiwyg/video/1920x1080.mp4"}}"></video></div>
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