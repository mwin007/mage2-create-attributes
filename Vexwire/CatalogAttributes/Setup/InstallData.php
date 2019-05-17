<?php
namespace Vexwire\CatalogAttributes\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * Set factory
     *
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    private $attributeSetFactory;
    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory             $eavSetupFactory
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * Function install
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $defaultAttributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);




        /********* BEGIN: Create Default Attribute SET ********* */

        /** @var \Magento\Eav\Model\Entity\Attribute\Set $attributeSet */
        $attributeSetName = "Vexwire Attribute Set";
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setEntityTypeId($entityTypeId)->load($attributeSetName, 'attribute_set_name');
        if ($attributeSet->getId()) {
            throw new AlreadyExistsException(__('Attribute Set already exists.'));
        }
        $attributeSet->setAttributeSetName($attributeSetName)->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($defaultAttributeSetId)->save();

        // Get the attribute group
        $attributeGroupId = $eavSetup->getAttributeGroupId(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            'General'
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_type',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire Type',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ 'Cell Phone', 'Tablet', 'Watch', ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_type',
            '1' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_model',
            [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Vexwire Model',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_model',
            '2' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_brand',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire Brand',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ 'Apple', 'Samsung' ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_brand',
            '3' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_carrier',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire Carrier',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ 'ATT', 'Boost', 'Sprint', 'T-Mobile', 'Verizon', 'Other' ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_carrier',
            '4' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_capacity',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire Capacity',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ '32GB', '64GB', '128GB', '256GB' ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_capacity',
            '5' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_os',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire OS',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ 'iOS', 'Android' ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_os',
            '6' // Sort Order
        );
        /********* END ********* */

        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'vw_attribute_condition',
            [
                'type' => 'varchar',
                'input' => 'select',
                'label' => 'Vexwire Condition',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                'option' => [
                    'values' => [ 'New', 'Like New', 'Refurbished', 'Manufacture Refurbished', 'Used' ]
                ]
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'vw_attribute_carrier',
            '7' // Sort Order
        );
        /********* END ********* */


        $setup->endSetup();


    }
}
