<?php

/**
 * SiteConfig
 *
 * @package SwiftDevLabs\AdditionalSiteSettings\Extensions
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\AdditionalSiteSettings\Extensions;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteConfig extends DataExtension
{
    private static $db = [
        // Google Analytics tracking id
        'GoogleAnalyticsTrackingID' => 'Varchar(11)',
    ];

    private static $many_many = [
        // Primary logo. Mainly used for header
        'Logo'          => Image::class,

        // Secondary logo. Optional. May be used for footer or a logo with a different background
        'SecondaryLogo' => Image::class,
    ];

    private static $owns = [
        'Logo',
        'SecondaryLogo',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        // Add logo fields to main
        $fields->addFieldToTab(
            'Root.Main',
            HeaderField::create('LogoHeader', 'Site Logos')
        );

        $fields->addFieldToTab(
            'Root.Main',
            UploadField::create('Logo')
                ->setIsMultiUpload(false)
        );

        $fields->addFieldToTab(
            'Root.Main',
            UploadField::create('SecondaryLogo')
                ->setIsMultiUpload(false)
        );

        // Google Analytics Tab
        $fields->insertBefore(
            $gaTab = Tab::create('GoogleAnalyticsTab', 'Google Analytics'),
            'Access'
        );

        $gaTab->push(TextField::create('GoogleAnalyticsTrackingID', 'Tracking ID'));
    }
}
