<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Navigation\Business\Navigation;

use Generated\Shared\Transfer\NavigationTransfer;
use Spryker\Zed\Navigation\Business\Exception\NavigationNotFoundException;
use Spryker\Zed\Navigation\Persistence\NavigationQueryContainerInterface;

class NavigationUpdater implements NavigationUpdaterInterface
{

    /**
     * @var \Spryker\Zed\Navigation\Persistence\NavigationQueryContainerInterface
     */
    protected $navigationQueryContainer;

    /**
     * @param \Spryker\Zed\Navigation\Persistence\NavigationQueryContainerInterface $navigationQueryContainer
     */
    public function __construct(NavigationQueryContainerInterface $navigationQueryContainer)
    {
        $this->navigationQueryContainer = $navigationQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer
     */
    public function updateNavigation(NavigationTransfer $navigationTransfer)
    {
        $this->assertNavigationForUpdate($navigationTransfer);

        $navigationTransfer = $this->persistNavigation($navigationTransfer);

        return $navigationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return void
     */
    protected function assertNavigationForUpdate(NavigationTransfer $navigationTransfer)
    {
        $navigationTransfer->requireIdNavigation();
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer
     */
    protected function persistNavigation(NavigationTransfer $navigationTransfer)
    {
        $navigationEntity = $this->getNavigationEntityById($navigationTransfer);

        $navigationEntity->fromArray($navigationTransfer->modifiedToArray());
        $navigationEntity->save();

        $navigationTransfer->fromArray($navigationEntity->toArray(), true);

        return $navigationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\NavigationTransfer $navigationTransfer
     *
     * @throws \Spryker\Zed\Navigation\Business\Exception\NavigationNotFoundException
     *
     * @return \Orm\Zed\Navigation\Persistence\SpyNavigation
     */
    protected function getNavigationEntityById(NavigationTransfer $navigationTransfer)
    {
        $navigationEntity = $this->navigationQueryContainer
            ->queryNavigationById($navigationTransfer->getIdNavigation())
            ->findOne();

        if (!$navigationEntity) {
            throw new NavigationNotFoundException(sprintf(
                'Navigation entity not found with ID %d.',
                $navigationTransfer->getIdNavigation()
            ));
        }

        return $navigationEntity;
    }

}
