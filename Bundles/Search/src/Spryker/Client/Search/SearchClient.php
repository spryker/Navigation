<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Search;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method SearchFactory getFactory()
 */
class SearchClient extends AbstractClient
{

    /**
     * @return \Elastica\Index
     */
    public function getIndexClient()
    {
        return $this->getFactory()->createIndexClient();
    }

}
