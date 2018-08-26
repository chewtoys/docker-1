<?php

/**
 * Class AffinitasTrackingSDK
 *
 * DUMMY
 *
 * Usage:
 *
 * <?php
 * $atrk = new AffinitasTrackingSDK();
 *
 * // In <head></head>
 * echo $atrk->pixel(AffinitasTrackingSDK::SITE_FIRST, AffinitasTrackingSDK::POSITION_HEAD);
 *
 * // After <body>
 * echo $atrk->pixel(AffinitasTrackingSDK::SITE_FIRST, AffinitasTrackingSDK::POSITION_TOP_OF_BODY);
 *
 * // Before </body>
 * echo $atrk->pixel(AffinitasTrackingSDK::SITE_FIRST, AffinitasTrackingSDK::POSITION_BOTTOM_OF_BODY);
 *
 */
class AffinitasTrackingSDK
{
    const
        SITE_FIRST = 'SITE_FIRST',
        SITE_SECOND = 'SITE_SECOND',
        SITE_ONEPAGE = 'SITE_ONEPAGE',

        POSITION_HEAD = 'HEADER',
        POSITION_TOP_OF_BODY = 'MIDDLE_TOP_OF_PAGE',
        POSITION_BOTTOM_OF_BODY = 'BOTTOM_OF_PAGE';

    protected $_appDomainConfig = false;

    /**
     * @var array AppDomain list according to host
     */
    static protected $_appDomains = array(
        array('id' => -1, 'host' => 'localhost')
    );

    /**
     * Constructor. Automatically tries to find the appDomain configuration according to HTTP_HOST.
     */
    public function __construct()
    {
        $this->_appDomainConfig = self::$_appDomains[0];
    }

    public function getCidParamValue()
    {
        return '#';
    }

    /**
     * Loads and returns the pixels for the given siteId and position.
     *
     * @param int $siteId SiteId from Const
     * @param string $position Position from Const
     * @return string
     */
    public function pixel($siteId, $position)
    {
        if (preg_match('/[A-Z]+_[A-Z]+_[0-9]+_[^_]+_[^_]+_[^_]+_(.*)/', $this->getCidParamValue(), $regs)) {
            $cidFreetext = $regs[1];
        } else {
            $cidFreetext = '';
        }
        return '<!-- '.htmlspecialchars('PIXEL FOR SITE '.$siteId.' ON POSITION '.$position.' (CID-Freetext: \''.$cidFreetext.'\'').' -->';
    }

    /**
     * Tries to write the CID cookie and returns the CID-Service's pixel URL.
     *
     * @return string
     */
    public function cid()
    {
        // Since Trakken i.m.o. MUST be called with a CID parameter, we skip the CID handling if it's not present
        return '#';

    }
}