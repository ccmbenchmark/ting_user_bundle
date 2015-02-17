<?php
/***********************************************************************
 *
 * TingUserBundle
 * ==========================================
 *
 * Copyright (C) 2015 CCM Benchmark Group. (http://www.ccmbenchmark.com)
 *
 ***********************************************************************
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you
 * may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
 * implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 **********************************************************************/

namespace CCMBenchmark\TingUserBundle\Manager;


use CCMBenchmark\TingUserBundle\Model\User\UserRepository;
use FOS\UserBundle\Model\UserInterface;

class UserManager extends \FOS\UserBundle\Model\UserManager
{
    protected $userRepository = null;
    protected $userClass = '';

    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function setUserClass($userClass)
    {
        $this->userClass = $userClass;
    }

    /**
     * Deletes a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function deleteUser(UserInterface $user)
    {
        $this->userRepository->delete($user);
    }

    /**
     * Finds one user by the given criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findUserBy(array $criteria)
    {
        return $this->userRepository->getOneByCriteria($criteria);
    }

    /**
     * Returns a collection with all user instances.
     *
     * @return \Traversable
     */
    public function findUsers()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return 'AppBundle\User\User';
    }

    /**
     * Reloads a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function reloadUser(UserInterface $user)
    {
        /**
         * @var $newUser UserInterface
         */
        $newUser = $this->userRepository->getOneByCriteria(['email' => $user->getEmail()]);
        $user->setUsername($newUser->getUsername());
        $user->setUsernameCanonical($newUser->getUsernameCanonical());
        $user->setRoles($newUser->getRoles());
        $user->setEmailCanonical($newUser->getEmailCanonical());
        $user->setPassword($newUser->getPassword());
        $user->setConfirmationToken($newUser->getConfirmationToken());
        $user->setEnabled($newUser->isEnabled());
        $user->setLocked(!$newUser->isAccountNonLocked());
        $user->setSuperAdmin($newUser->isSuperAdmin());
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function updateUser(UserInterface $user)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->userRepository->save($user);
    }
}
