<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Heartbeat\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method HeartbeatBusinessFactory getFactory()
 */
class HeartbeatFacade extends AbstractFacade
{

    /**
     * @return bool
     */
    public function isSystemAlive()
    {
        return $this->getFactory()->createDoctor()->doHealthCheck()->isPatientAlive();
    }

    /**
     * @return \Generated\Shared\Transfer\HealthReportTransfer
     */
    public function getReport()
    {
        return $this->getFactory()->createDoctor()->doHealthCheck()->getReport();
    }

    /**
     * @return HealthIndicatorReportTransfer
     */
    public function doPropelHealthCheck()
    {
        return $this->getFactory()->createPropelHealthIndicator()->doHealthCheck();
    }

    /**
     * @return HealthIndicatorReportTransfer
     */
    public function doSearchHealthCheck()
    {
        return $this->getFactory()->createSearchHealthIndicator()->doHealthCheck();
    }

    /**
     * @return HealthIndicatorReportTransfer
     */
    public function doSessionHealthCheck()
    {
        return $this->getFactory()->createSessionHealthIndicator()->doHealthCheck();
    }

    /**
     * @return HealthIndicatorReportTransfer
     */
    public function doStorageHealthCheck()
    {
        return $this->getFactory()->createStorageHealthIndicator()->doHealthCheck();
    }

}
