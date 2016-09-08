<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch;

use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductSearchConfig extends AbstractBundleConfig
{

    /**
     * @return \Generated\Shared\Transfer\FacetConfigTransfer[]
     */
    public function getFilterTypeConfigs()
    {
        return [
            'single-select' => (new FacetConfigTransfer())
                ->setType(SearchConstants::FACET_TYPE_ENUMERATION)
                ->setFieldName(PageIndexMap::STRING_FACET)
                ->setIsMultiValued(false),

            'multi-select' => (new FacetConfigTransfer())
                ->setType(SearchConstants::FACET_TYPE_ENUMERATION)
                ->setFieldName(PageIndexMap::STRING_FACET)
                ->setIsMultiValued(true),

            'range' => (new FacetConfigTransfer())
                ->setType(SearchConstants::FACET_TYPE_RANGE)
                ->setFieldName(PageIndexMap::INTEGER_FACET)
                ->setIsMultiValued(false),

            'price-range' => (new FacetConfigTransfer())
                ->setType(SearchConstants::FACET_TYPE_PRICE_RANGE)
                ->setFieldName(PageIndexMap::INTEGER_FACET)
                ->setIsMultiValued(false),
        ];
    }

}
