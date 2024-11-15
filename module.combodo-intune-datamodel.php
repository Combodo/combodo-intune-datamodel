<?php
/**
 * @copyright   Copyright (C) 2010-2025 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

SetupWebPage::AddModule(
    __FILE__, // Path to the current file, all other file names are relative to the directory containing this file
    'combodo-intune-datamodel/1.0.0',
    array(
        // Identification
        //
        'label' => 'InTune Datamodel',
        'category' => 'business',

        // Setup
        //
        'dependencies' => array(
            'itop-config-mgmt/3.2.0',
            'itop-endusers-devices/3.2.0',
        ),
        'mandatory' => false,
        'visible' => true,

        // Components
        //
        'datamodel' => array(
            'src/Hook/InTunePopupMenu.php',
        ),
        'webservice' => array(
        ),
        'data.struct' => array(
        ),
        'data.sample' => array(
        ),

        // Documentation
        //
        'doc.manual_setup' => '',
        'doc.more_information' => '',

        // Default settings
        //
        'settings' => array(
            'direct_access' => array(
                'label' => 'InTune',
                'url' => 'https://intune.microsoft.com/#view/Microsoft_Intune_Devices/DeviceSettingsMenuBlade/~/overview/mdmDeviceId/$intuneid$',
                'icon' => 'fas fa-cloud-upload-alt',
                'tooltip' => 'Lookup managed devices directly in InTune',
            ),
        ),
    )
);

