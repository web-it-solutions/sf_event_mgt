<?php

/*
 * This file is part of the Extension "sf_event_mgt" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfEventMgt\Controller;

use DERHANSEN\SfEventMgt\Domain\Model\Dto\UserRegistrationDemand;
use DERHANSEN\SfEventMgt\Utility\PageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * UserRegistrationController
 */
class UserRegistrationController extends AbstractController
{
    /**
     * Shows a list of all registration of the current frontend user
     */
    public function listAction()
    {
        $demand = $this->createUserRegistrationDemandObjectFromSettings($this->settings);
        $demand->setUser($this->registrationService->getCurrentFeUserObject());
        $registrations = $this->registrationRepository->findRegistrationsByUserRegistrationDemand($demand);
        $this->view->assign('registrations', $registrations);
    }

    /**
     * Creates an user registration demand object with the given settings
     *
     * @param array $settings The settings
     *
     * @return \DERHANSEN\SfEventMgt\Domain\Model\Dto\UserRegistrationDemand
     */
    protected function createUserRegistrationDemandObjectFromSettings(array $settings): UserRegistrationDemand
    {
        /** @var \DERHANSEN\SfEventMgt\Domain\Model\Dto\UserRegistrationDemand $demand */
        $demand = GeneralUtility::makeInstance(UserRegistrationDemand::class);
        $demand->setDisplayMode($settings['userRegistration']['displayMode']);
        $demand->setStoragePage(PageUtility::extendPidListByChildren(
            $settings['userRegistration']['storagePage'] ?? '',
            $settings['userRegistration']['recursive'] ?? 0
        ));
        $demand->setOrderField($settings['userRegistration']['orderField']);
        $demand->setOrderDirection($settings['userRegistration']['orderDirection']);

        return $demand;
    }
}
