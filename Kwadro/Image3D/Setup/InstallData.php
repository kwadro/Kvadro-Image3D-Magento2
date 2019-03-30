<?php

namespace Kvadro\Image3D\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Kvadro\Image3D\Api\Data\KvadroParamsRuleInterface;
use Kvadro\Image3D\Api\Data\KvadroPaymentPlanInterface;

class InstallData implements InstallDataInterface
{
    CONST USER_GUIDE_URL = "https://kvadro.com";

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $configInterface
    )
    {
        $this->_configInterface = $configInterface;
        try {
            $state->getAreaCode();
        } catch
        (\Exception $e) {
            $state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        }
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        //add default value save job params
        $default_data = [
            'auto_new_product          ' => 2,
            'update_manual_choices     ' => 2,
            'use_thumbnall_of_button   ' => 2,
            'add_preview_to_gallery    ' => 2,
            'set_preview_base          ' => 2,
        ];
        $default_data = json_encode($default_data, true);

        $this->_configInterface->saveConfig('kvadroadmin/general/savejobparams', $default_data, 'default', 0);

        // add url userguide
        $this->_configInterface->saveConfig('kvadroadmin/general/userguide_url', self::USER_GUIDE_URL, 'default', 0);

        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '0.0.1', '<')) {

            $select = $setup->getConnection()->select()->from(['c' => $setup->getTable('kvadro_tech_kvadro3D_payment_plan')]);
            $result = $setup->getConnection()->fetchAll($select);
            if (!$result){
                // Add data label payment plan
                $sampleData = $this->getSampleDataPaymentLabel();

                foreach ($sampleData as $sampleDatum) {
                    $setup->getConnection()->insert($setup->getTable('kvadro_tech_kvadro3D_payment_plan'), $sampleDatum);
                }
            }
            $select = $setup->getConnection()->select()->from(['c' => $setup->getTable('kvadro_tech_kvadro3D_params_rule')]);
            $result = $setup->getConnection()->fetchAll($select);
            if (!$result) {

                // Add data label params rule
                $sampleData = $this->getSampleDataRule();

                foreach ($sampleData as $sampleDatum) {
                    $setup->getConnection()->insert($setup->getTable('kvadro_tech_kvadro3D_params_rule'), $sampleDatum);
                }
            }

            $rule_save = $this->getRuleSaveData();

            $this->_configInterface->saveConfig('kvadroadmin/general/rule_save', $rule_save, 'default', 0);

        }
        $installer->endSetup();
    }

    protected function getRuleSaveData()
    {
        $result = [
            [
                'code' => 'auto_new_product',
                'label' => 'Autosync new/updated product',
                'default_value' => true,
            ],
            ['code' => 'update_manual_choices',
                'label' => 'Autosync new/updated product',
                'default_value' => true,
            ],
            ['code' => 'use_thumbnall_of_button',
                'label' => 'Use thumbnall instead of 3D button',
                'default_value' => true,
            ],
            ['code' => 'add_preview_to_gallery',
                'label' => 'Add preview image to gallery',
                'default_value' => true,
            ],
            ['code' => 'set_preview_base',
                'label' => 'Set Preview Image as Base',
                'default_value' => false,
            ],
        ];
        return json_encode($result);

    }

    protected function getSampleDataPaymentLabel()
    {
        $sampleData = [
            [
                KvadroPaymentPlanInterface::DATA_VALUE => 1,
                KvadroPaymentPlanInterface::DATA_LABEL => "free",
            ], [
                KvadroPaymentPlanInterface::DATA_VALUE => 10,
                KvadroPaymentPlanInterface::DATA_LABEL => "lite",
            ], [
                KvadroPaymentPlanInterface::DATA_VALUE => 20,
                KvadroPaymentPlanInterface::DATA_LABEL => "basic",
            ], [
                KvadroPaymentPlanInterface::DATA_VALUE => 30,
                KvadroPaymentPlanInterface::DATA_LABEL => "professional",
            ],

        ];
        return $sampleData;
    }

    protected function getSampleDataRule()
    {
        $sample_data = [
            [
                KvadroParamsRuleInterface::DATA_LABEL => 'autoRun',
                KvadroParamsRuleInterface::DATA_NAME => 'autoRun',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => FALSE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 0,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Start the player (widget) automatically or display the preview and play button
closeButton'
                ,
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'closeButton',
                KvadroParamsRuleInterface::DATA_NAME => 'closeButton',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'TRUE',
                KvadroParamsRuleInterface::DATA_PAID => FALSE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 0,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Show close button',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'logo',
                KvadroParamsRuleInterface::DATA_NAME => 'logo',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'TRUE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 20,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Show Kvadro logo',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'analytics',
                KvadroParamsRuleInterface::DATA_NAME => 'analytics',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'TRUE',
                KvadroParamsRuleInterface::DATA_PAID => FALSE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 0,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Enable analytics',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'autoRotate',
                KvadroParamsRuleInterface::DATA_NAME => 'autoRotate',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Start automatic rotation',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'autoRotateTime',
                KvadroParamsRuleInterface::DATA_NAME => 'autoRotateTime',
                KvadroParamsRuleInterface::DATA_TYPE => 'float',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => '10.0',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Rotation time of the full turn, seconds',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'autoRotateDelay',
                KvadroParamsRuleInterface::DATA_NAME => 'autoRotateDelay',
                KvadroParamsRuleInterface::DATA_TYPE => 'float',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => '2.0',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Delay if rotation was interrupted, seconds',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'autoRotateDir',
                KvadroParamsRuleInterface::DATA_NAME => 'autoRotateDir',
                KvadroParamsRuleInterface::DATA_TYPE => 'float',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => '1.0',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Autorotate direction (clockwise is 1, counter-clockwise is -1)',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'hideFullScreen',
                KvadroParamsRuleInterface::DATA_NAME => 'hideFullScreen',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => FALSE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 0,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Hide fullscreen view button',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'hideAutoRotateOpt',
                KvadroParamsRuleInterface::DATA_NAME => 'hideAutoRotateOpt',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Hide autorotate button',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'hideSettingsBtn',
                KvadroParamsRuleInterface::DATA_NAME => 'hideSettingsBtn',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Hide settings button',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'enableImageZoom',
                KvadroParamsRuleInterface::DATA_NAME => 'enableImageZoom',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'TRUE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Enable zoom',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'zoomQuality',
                KvadroParamsRuleInterface::DATA_NAME => 'zoomQuality',
                KvadroParamsRuleInterface::DATA_TYPE => 'integer',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 1,
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Zoom quality (SD is 1, HD is 2)',
            ],
            [KvadroParamsRuleInterface::DATA_LABEL => 'hideZoomOpt',
                KvadroParamsRuleInterface::DATA_NAME => 'hideZoomOpt',
                KvadroParamsRuleInterface::DATA_TYPE => 'boolean',
                KvadroParamsRuleInterface::DATA_DEFAULT_VALUE => 'FALSE',
                KvadroParamsRuleInterface::DATA_PAID => TRUE,
                KvadroParamsRuleInterface::DATA_REG_PLAN_LEVEL => 30,
                KvadroParamsRuleInterface::DATA_DESCRIPTION => 'Hide zoom button',
            ],

        ];
        return $sample_data;
    }
}