<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Navigation\Business;

use Generated\Shared\Transfer\NavigationTransfer;

/**
 * @method \Spryker\Zed\Navigation\Business\NavigationBusinessFactory getFactory()
 */
interface NavigationFacadeInterface
{

    /**
     * Specification:
     * - TODO: add specification
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer
     */
    public function createNavigation(NavigationTransfer $navigationTransfer);

    /**
     * Specification:
     * - TODO: add specification
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer
     */
    public function updateNavigation(NavigationTransfer $navigationTransfer);

    /**
     * Specification:
     * - TODO: add specification
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer|null
     */
    public function findNavigation(NavigationTransfer $navigationTransfer);

    /**
     * Specification:
     * - TODO: add specification
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return void
     */
    public function deleteNavigation(NavigationTransfer $navigationTransfer);

}
