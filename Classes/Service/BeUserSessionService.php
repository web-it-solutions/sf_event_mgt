<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_event_mgt" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfEventMgt\Service;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class BeUserSessionService
{
    private const SESSION_KEY_PREFIX = 'sf_event_mgt-';

    /**
     * Saves the given data to the session
     */
    public function saveSessionData(string $key, mixed $data): void
    {
        $this->getBackendUser()->setAndSaveSessionData(self::SESSION_KEY_PREFIX . $key, $data);
    }

    /**
     * Returns the session data
     */
    public function getSessionData(string $key): mixed
    {
        return $this->getBackendUser()->getSessionData(self::SESSION_KEY_PREFIX . $key);
    }

    protected function getBackendUser(): ?BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'] ?? null;
    }
}
