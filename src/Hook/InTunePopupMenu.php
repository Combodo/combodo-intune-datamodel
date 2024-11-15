<?php
/*
 * @copyright   Copyright (C) 2010-2025 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\InTune\Hook;

use iPopupMenuExtension;
use MetaModel;
use PhysicalDevice;
use URLButtonItem;

class InTunePopupMenu implements iPopupMenuExtension
{
    const MODULE_NAME = 'combodo-intune-datamodel';
    const DIRECT_ACCESS = 'direct_access';
    const INTUNE_DEFAULT_MENU_ICON = 'fas fa-cloud-upload-alt';

    /** @inheritdoc  */
    public static function EnumItems($iMenuId, $param) : array
    {
        $aResult = array();
        switch($iMenuId) // Type of menu in which to add menu items
        {
            case iPopupMenuExtension::MENU_OBJLIST_ACTIONS: // $param is a DBObjectSet
            case iPopupMenuExtension::MENU_OBJLIST_TOOLKIT: // $param is a DBObjectSet
                break;

            case iPopupMenuExtension::MENU_OBJDETAILS_ACTIONS: // $param is a DBObject
                $oObj = $param;

                if ($oObj instanceof PhysicalDevice) {
                    // Add URL toward InTune objects if object has an intuneid attribute
                    $sClass = get_class($oObj);
                    if (MetaModel::IsValidAttCode($sClass, 'intuneid')) {
                        $aDirectAccessParams = MetaModel::GetModuleSetting(static::MODULE_NAME, static::DIRECT_ACCESS, array());
                        if (!empty($aDirectAccessParams) && array_key_exists('label', $aDirectAccessParams) && array_key_exists('url', $aDirectAccessParams)) {
                            $sLabel = $aDirectAccessParams['label'];
                            $sUrl = $aDirectAccessParams['url'];
                            if (($sUrl != '') && ($sLabel != '')) {
                                // Build URL
                                $sUrl = str_replace('$intuneid$', $oObj->Get('intuneid'), $sUrl);

                                // Build tooltip
                                $sTooltip = array_key_exists('tooltip', $aDirectAccessParams) ? $aDirectAccessParams['tooltip'] : '';

                                // Build icon
                                $sIcon = array_key_exists('icon', $aDirectAccessParams) ? $aDirectAccessParams['icon'] : static::INTUNE_DEFAULT_MENU_ICON;

                                // Build target page
                                $sTarget = array_key_exists('target', $aDirectAccessParams) ? $aDirectAccessParams['target'] : '_blank';

                                $oButton = new URLButtonItem('intune_datamodel', $sLabel, $sUrl, $sTarget);
                                $oButton->SetIconClass('fab fa-github-alt');
                                $oButton->SetTooltip($sTooltip);
                                $aResult[] = $oButton;
                            }
                        }
                    }
                }
                break;

            case iPopupMenuExtension::MENU_DASHBOARD_ACTIONS: // $param is a Dashboard
            default:
                break;
        }

        return $aResult;
    }
}