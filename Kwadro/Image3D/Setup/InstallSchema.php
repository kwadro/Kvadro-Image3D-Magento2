<?php

namespace Kvadro\Image3D\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Kvadro\Image3D\Api\Data\KvadroDataInterface;
use Kvadro\Image3D\Api\Data\KvadroPaymentPlanInterface;
use Kvadro\Image3D\Api\Data\KvadroSyncJobInterface;
use Kvadro\Image3D\Api\Data\KvadroSyncDataInterface;
use Kvadro\Image3D\Api\Data\KvadroParamsRuleInterface;
use Kvadro\Image3D\Api\Data\KvadroSyncJobParamsInterface;
use Kvadro\Image3D\Api\Data\KvadroImageParamsInterface;

/**
 * Class InstallSchema
 * @package Mageplaza\Blog\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('kvadro_tech_kvadro3D_user')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_user'))
                ->addColumn(KvadroDataInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Post ID')
                ->addColumn(KvadroDataInterface::DATA_TOKEN, Table::TYPE_TEXT, 255, ['nullable => false'], 'SyncJob Token')
                ->addColumn(KvadroDataInterface::DATA_ALIASES, Table::TYPE_TEXT, 255, [], 'User Aliases')
                ->addColumn(KvadroDataInterface::DATA_PLAN, Table::TYPE_INTEGER, null, [], 'User Payment Plan')
                ->addColumn(KvadroDataInterface::DATA_VIEW_PARAMS, Table::TYPE_TIMESTAMP, null, [], 'User Updated At')
                ->addColumn(KvadroDataInterface::DATA_CREATE_AT, Table::TYPE_TIMESTAMP, null, [], 'User Updated At')
                ->addColumn(KvadroDataInterface::DATA_UPDATE_AT, Table::TYPE_TIMESTAMP, null, [], 'User Updated At')
                ->addColumn(KvadroDataInterface::DATA_STATUS, Table::TYPE_INTEGER, null, [], 'User Status')
                ->setComment('Kvadro User Table');

            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('kvadro_tech_kvadro3D_payment_plan')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_payment_plan'))
                ->addColumn(KvadroPaymentPlanInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Post ID')
                ->addColumn(KvadroPaymentPlanInterface::DATA_VALUE, Table::TYPE_INTEGER, null, ['nullable => false'], 'Payment Plan value')
                ->addColumn(KvadroPaymentPlanInterface::DATA_LABEL, Table::TYPE_TEXT, 255, [], 'Payment Plan label')
                ->setComment('Kvadro Payment Plan Table');

            $installer->getConnection()->createTable($table);
        }



        if (!$installer->tableExists('kvadro_tech_kvadro3D_sync_job')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_sync_job'))
                ->addColumn(KvadroSyncJobInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Tag ID')
                ->addColumn(KvadroSyncJobInterface::DATA_JOB_ID, Table::TYPE_TEXT, 255, [], 'SyncJob ID ')
                ->addColumn(KvadroSyncJobInterface::DATA_STATUS, Table::TYPE_INTEGER, NULL, [], 'SyncJob Status ')
                ->addColumn(KvadroSyncJobInterface::DATA_UPDATE_AT, Table::TYPE_TIMESTAMP, null, [], 'SyncJob Updated At')
                ->addColumn(KvadroSyncJobInterface::DATA_CREATE_AT, Table::TYPE_TIMESTAMP, null, [], 'SyncJob Created At')
                ->addColumn(KvadroSyncJobInterface::DATA_USER_ID, Table::TYPE_INTEGER, null, [], 'SyncJob UserId')
                ->setComment('SyncJob Table');

            $installer->getConnection()->createTable($table);
        }


        if (!$installer->tableExists('kvadro_tech_kvadro3D_sync_job_params')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_sync_job_params'))
                ->addColumn(KvadroSyncJobParamsInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Tag ID')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_SET_PREVIEW_BASE,  Table::TYPE_INTEGER, NULL, [], 'SyncJobParams save  ID ')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_ADD_PREVIEW_TO_GALLERY,    Table::TYPE_INTEGER, NULL, [], 'SyncJobParams DATA_ADD_PREVIEW_TO_GALLERY ')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_USE_THUMBNALL_OF_BUTTON,   Table::TYPE_INTEGER, NULL,  [], 'SyncJobParams DATA_USE_THUMBNALL_OF_BUTTON')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_UPDATE_MANUAL_CHOICES,    Table::TYPE_INTEGER, NULL,  [], 'SyncJobParams DATA_UPDATE_MANUAL_CHOICES')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_AUTO_NEW_PRODUCT,    Table::TYPE_INTEGER, NULL,  [], 'SyncJobParams DATA_AUTO_NEW_PRODUCT')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_USER_ID, Table::TYPE_INTEGER, null, [], 'SyncJobParams UserId')
                ->setComment('SyncJob Table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('kvadro_tech_kvadro3D_image_params')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_image_params'))
                ->addColumn(KvadroImageParamsInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Tag ID')

                ->addColumn(KvadroImageParamsInterface::DATA_AUTORUN, Table::TYPE_INTEGER, NULL, [], 'ImageData DATA_AUTORUN ')
                ->addColumn(KvadroImageParamsInterface::DATA_ANALYTICS, Table::TYPE_INTEGER, NULL, [], 'ImageData DATA_ANALYTICS ')
                ->addColumn(KvadroImageParamsInterface::DATA_CLOSEBUTTON, Table::TYPE_INTEGER, NULL, [], 'ImageData DATA_CLOSEBUTTON ')
                ->addColumn(KvadroImageParamsInterface::DATA_HIDEFULLSCREEN, Table::TYPE_INTEGER, NULL, [], 'ImageData DATA_HIDEFULLSCREEN ')
                ->addColumn(KvadroSyncJobParamsInterface::DATA_USER_ID, Table::TYPE_INTEGER, null, [], 'SyncJobParams UserId')
                ->setComment('ImageData Table');

            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('kvadro_tech_kvadro3D_sync_data')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_sync_data'))
                ->addColumn(KvadroSyncJobInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Tag ID')
                ->addColumn(KvadroSyncDataInterface::DATA_PRODUCT_ID, Table::TYPE_INTEGER, NULL, [], 'SyncData DATA_PRODUCT_ID ')
                ->addColumn(KvadroSyncDataInterface::DATA_IMAGE_CODE_3D, Table::TYPE_TEXT, 255, [], 'SyncData DATA_IMAGE_CODE_3D ')
                ->addColumn(KvadroSyncDataInterface::DATA_IMAGE_URL_3D, Table::TYPE_TEXT, 255, [], 'SyncData DATA_IMAGE_URL_3D ')
                ->addColumn(KvadroSyncDataInterface::DATA_THUMBNALL_3D, Table::TYPE_TEXT, 255, [], 'SyncData DATA_THUMBNALL_3D ')
                ->addColumn(KvadroSyncDataInterface::DATA_JOB_ID, Table::TYPE_TEXT, 255, [], 'SyncData ID ')
                ->addColumn(KvadroSyncDataInterface::DATA_RESOURCE, Table::TYPE_TEXT, 255, [], 'SyncData DATA_RESOURCE ')
                ->addColumn(KvadroSyncDataInterface::DATA_UPDATE_AT, Table::TYPE_TIMESTAMP, null, [], 'SyncData Updated At')
                ->addColumn(KvadroSyncDataInterface::DATA_CREATE_AT, Table::TYPE_TIMESTAMP, null, [], 'SyncData Created At')
                ->setComment('SyncData Table');

            $installer->getConnection()->createTable($table);
        }


        if (!$installer->tableExists('kvadro_tech_kvadro3D_params_rule')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('kvadro_tech_kvadro3D_params_rule'))
                ->addColumn(KvadroParamsRuleInterface::ENTITY_ID, Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ], 'Tag ID')
                ->addColumn(KvadroParamsRuleInterface::DATA_NAME, Table::TYPE_TEXT, 55, [], 'Rule Id ')
                ->addColumn(KvadroParamsRuleInterface::DATA_TYPE, Table::TYPE_TEXT, 55, [], 'Rule Id ')
                ->addColumn(KvadroParamsRuleInterface::DATA_DEFAULT_VALUE, Table::TYPE_TEXT, 55, [], 'Rule Default Value')
                ->addColumn(KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL, Table::TYPE_INTEGER, null, [], 'Rule Reg Plan Level')
                ->addColumn(KvadroParamsRuleInterface::DATA_PAID, Table::TYPE_BOOLEAN, null, [], 'Rule Paid')
                ->addColumn(KvadroParamsRuleInterface::DATA_DESCRIPTION, Table::TYPE_TEXT, 255, [], 'Rule Description')
                ->addColumn(KvadroParamsRuleInterface::DATA_LABEL, Table::TYPE_TEXT, 255, [], 'Rule Label')
                ->setComment('Kvadro  Rule Params Table');

            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}