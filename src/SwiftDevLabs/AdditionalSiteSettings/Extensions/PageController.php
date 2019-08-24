<?php

/**
 * PageController
 *
 * @package SwiftDevLabs\AdditionalSiteSettings\Extensions
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\AdditionalSiteSettings\Extensions;

use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

class PageController extends Extension
{
    public function onAfterInit()
    {
        $trackingId = SiteConfig::current_site_config()->GoogleAnalyticsTrackingID;

        if (Director::isLive() && $trackingId) {
            Requirements::javascript("https://www.googletagmanager.com/gtag/js?id={$trackingId}", [
                'async' => true,
            ]);

            Requirements::javascriptTemplate('jinjie/silverstripe-additional-sitesettings: templates/javascript/ga.js', [
                'TrackingID'    => $trackingId,
            ]);
        }
    }
}
