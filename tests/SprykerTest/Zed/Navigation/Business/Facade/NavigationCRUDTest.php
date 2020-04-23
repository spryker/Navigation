<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Navigation\Business\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\NavigationTransfer;
use Propel\Runtime\Exception\PropelException;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Zed\Navigation\Business\NavigationFacade;
use Spryker\Zed\Navigation\Persistence\NavigationQueryContainer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Navigation
 * @group Business
 * @group Facade
 * @group NavigationCRUDTest
 * Add your own group annotations below this line
 */
class NavigationCRUDTest extends Unit
{
    /**
     * @var \Spryker\Zed\Navigation\Business\NavigationFacade
     */
    protected $navigationFacade;

    /**
     * @var \Spryker\Zed\Navigation\Persistence\NavigationQueryContainer
     */
    protected $navigationQueryContainer;

    /**
     * @var \SprykerTest\Zed\Navigation\NavigationBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->navigationFacade = new NavigationFacade();
        $this->navigationQueryContainer = new NavigationQueryContainer();
    }

    /**
     * @return void
     */
    public function testCreateNewNavigationPersistsToDatabase(): void
    {
        $navigationTransfer = $this->createNavigationTransfer('test-navigation-1', 'Test navigation 1', true);

        $navigationTransfer = $this->navigationFacade->createNavigation($navigationTransfer);

        $this->assertGreaterThan(0, $navigationTransfer->getIdNavigation());
    }

    /**
     * @return void
     */
    public function testUpdateExistingNavigationPersistsToDatabase(): void
    {
        $navigationEntity = $this->tester->createNavigationEntity('test-navigation-1', 'Test navigation 1', true);

        $navigationTransfer = new NavigationTransfer();
        $navigationTransfer
            ->setIdNavigation($navigationEntity->getIdNavigation())
            ->setName('Test navigation 1 (edited)');

        $updatedNavigationTransfer = $this->navigationFacade->updateNavigation($navigationTransfer);

        $this->assertSame('Test navigation 1 (edited)', $updatedNavigationTransfer->getName(), 'Name should have changed when updating navigation.');
        $this->assertSame('test-navigation-1', $updatedNavigationTransfer->getKey(), 'Returned navigation transfer should contain non-updated data as well.');
    }

    /**
     * @return void
     */
    public function testReadExistingNavigationReadsFromDatabase(): void
    {
        $navigationEntity = $this->tester->createNavigationEntity('test-navigation-1', 'Test navigation 1', true);

        $navigationTransfer = new NavigationTransfer();
        $navigationTransfer->setIdNavigation($navigationEntity->getIdNavigation());

        $navigationTransfer = $this->navigationFacade->findNavigation($navigationTransfer);

        $this->assertSame($navigationEntity->getKey(), $navigationTransfer->getKey(), 'Key read from database should match expected value.');
        $this->assertSame($navigationEntity->getName(), $navigationTransfer->getName(), 'Name read from database should match expected value.');
        $this->assertSame($navigationEntity->getIsActive(), $navigationTransfer->getIsActive(), 'Active status read from database should match expected value.');
    }

    /**
     * @return void
     */
    public function testDeleteExistingNavigationDeletesFromDatabase(): void
    {
        $navigationEntity = $this->tester->createNavigationEntity('test-navigation-1', 'Test navigation 1', true);

        $navigationTransfer = new NavigationTransfer();
        $navigationTransfer->setIdNavigation($navigationEntity->getIdNavigation());

        $this->navigationFacade->deleteNavigation($navigationTransfer);

        $actualCount = $this->navigationQueryContainer
            ->queryNavigationById($navigationEntity->getIdNavigation())
            ->count();

        $this->assertSame(0, $actualCount, 'Navigation entity should not be in database.');
    }

    /**
     * @return void
     */
    public function testDuplicateNavigationWillPersistTheSameNavigationAsExistingOne(): void
    {
        // Arrange
        $baseNavigationTransfer = $this->tester->createNavigation('test-key', 'Test navigation', true);
        $newNavigationTransfer = $this->createNavigationTransfer('test-navigation-1', 'Test navigation 1', true);
        $navigationNodeTransfer = $this->tester->createNavigationNode($baseNavigationTransfer->getIdNavigation());

        // Act
        $duplicatedNavigationTransfer = $this->navigationFacade->duplicateNavigation($newNavigationTransfer, $baseNavigationTransfer);

        // Assert
        $duplicatedNavigationNodeTransfer = $this->navigationFacade
            ->findNavigationTree($duplicatedNavigationTransfer)
            ->getNodes()[0]
            ->getNavigationNode();

        [$navigationNodeLocalizedAttributesTransfer1, $navigationNodeLocalizedAttributesTransfer2]
            = $navigationNodeTransfer->getNavigationNodeLocalizedAttributes();
        [$duplicatedNavigationNodeLocalizedAttributesTransfer1, $duplicatedNavigationNodeLocalizedAttributesTransfer2]
            = $duplicatedNavigationNodeTransfer->getNavigationNodeLocalizedAttributes();
        $this->assertEquals($newNavigationTransfer->getName(), $duplicatedNavigationTransfer->getName());
        $this->assertEquals($newNavigationTransfer->getKey(), $duplicatedNavigationTransfer->getKey());
        $this->assertEquals($duplicatedNavigationNodeTransfer->getIsActive(), $navigationNodeTransfer->getIsActive());
        $this->assertEquals(
            $duplicatedNavigationNodeLocalizedAttributesTransfer1->getExternalUrl(),
            $navigationNodeLocalizedAttributesTransfer1->getExternalUrl()
        );
        $this->assertEquals(
            $duplicatedNavigationNodeLocalizedAttributesTransfer1->getTitle(),
            $navigationNodeLocalizedAttributesTransfer1->getTitle()
        );
        $this->assertEquals(
            $duplicatedNavigationNodeLocalizedAttributesTransfer2->getExternalUrl(),
            $navigationNodeLocalizedAttributesTransfer2->getExternalUrl()
        );
        $this->assertEquals(
            $duplicatedNavigationNodeLocalizedAttributesTransfer2->getTitle(),
            $navigationNodeLocalizedAttributesTransfer2->getTitle()
        );
    }

    /**
     * @return void
     */
    public function testDuplicateNavigationWillThrowExceptionForNavigationDuplicatingWithExistentKey(): void
    {
        // Arrange
        $baseNavigationTransfer = $this->tester->createNavigation('test-key', 'Test navigation', true);
        $newNavigationTransfer = $this->createNavigationTransfer($baseNavigationTransfer->getKey(), 'test-navigation-1', true);

        // Assert
        $this->expectException(PropelException::class);
        $this->expectExceptionMessage('duplicate key value violates unique constraint "spy_navigation_key-unique-key"');

        // Act
        $this->navigationFacade->duplicateNavigation($newNavigationTransfer, $baseNavigationTransfer);
    }

    /**
     * @return void
     */
    public function testDuplicateNavigationWillThrowExceptionWithoutKey(): void
    {
        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->navigationFacade->duplicateNavigation(
            (new NavigationTransfer())->setName('Test 1'),
            (new NavigationTransfer())->setName('Test 2')
        );
    }

    /**
     * @return void
     */
    public function testDuplicateNavigationWillThrowExceptionWithoutName(): void
    {
        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->navigationFacade->duplicateNavigation(
            (new NavigationTransfer())->setKey('test_1'),
            (new NavigationTransfer())->setKey('test_2')
        );
    }

    /**
     * @param string $key
     * @param string $name
     * @param bool $isActive
     *
     * @return \Generated\Shared\Transfer\NavigationTransfer
     */
    protected function createNavigationTransfer(string $key, string $name, bool $isActive): NavigationTransfer
    {
        $navigationTransfer = new NavigationTransfer();
        $navigationTransfer
            ->setKey($key)
            ->setName($name)
            ->setIsActive($isActive);

        return $navigationTransfer;
    }
}
