<?php

namespace Summa\Installers\Setup;

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
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
        $blockHtmlContent = <<<HTML
iuju
HTML;
            $this->createCmsBlock('cms-block-id3', $blockHtmlContent, 'lalalalala');

        $blockHtmlContent = <<<HTML
uiju
HTML;
            $this->createCmsPage('cms-test5', $blockHtmlContent, 'lalalalal');
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