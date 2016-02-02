<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Acl\Business\Model;

use Generated\Shared\Transfer\RuleTransfer;
use Generated\Shared\Transfer\RolesTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Spryker\Shared\Acl\AclConstants;

interface RuleInterface
{

    /**
     * @param \Generated\Shared\Transfer\RuleTransfer $ruleTransfer
     *
     * @throws \Spryker\Zed\Acl\Business\Exception\RuleNotFoundException
     *
     * @return mixed
     */
    public function addRule(RuleTransfer $ruleTransfer);

    /**
     * @param \Generated\Shared\Transfer\RuleTransfer $RuleTransfer
     *
     * @throws \Spryker\Zed\Acl\Business\Exception\RuleNotFoundException
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    public function save(RuleTransfer $RuleTransfer);

    /**
     * @param int $idRule
     *
     * @return bool
     */
    public function hasRule($idRule);

    /**
     * @param int $idRole
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    public function getRoleRules($idRole);

    /**
     * @param \Generated\Shared\Transfer\RolesTransfer $roles
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    public function findByRoles(
        RolesTransfer $roles,
        $bundle = AclConstants::VALIDATOR_WILDCARD,
        $controller = AclConstants::VALIDATOR_WILDCARD,
        $action = AclConstants::VALIDATOR_WILDCARD
    );

    /**
     * @param int $idGroup
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    public function getRulesForGroupId($idGroup);

    /**
     * @param int $id
     *
     * @throws \Spryker\Zed\Acl\Business\Exception\RuleNotFoundException
     *
     * @return \Generated\Shared\Transfer\RuleTransfer
     */
    public function getRuleById($id);

    /**
     * @param int $id
     *
     * @throws \Spryker\Zed\Acl\Business\Exception\RuleNotFoundException
     *
     * @return bool
     */
    public function removeRuleById($id);

    /**
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function isIgnorable($bundle, $controller, $action);

    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @throws \Spryker\Zed\User\Business\Exception\UserNotFoundException
     */
    public function registerSystemUserRules(UserTransfer $userTransfer);

    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function isAllowed(UserTransfer $userTransfer, $bundle, $controller, $action);

}
