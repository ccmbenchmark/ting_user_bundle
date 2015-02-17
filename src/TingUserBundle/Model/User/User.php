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

namespace CCMBenchmark\TingUserBundle\Model\User;


use CCMBenchmark\Ting\Entity\NotifyProperty;
use CCMBenchmark\Ting\Entity\NotifyPropertyInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends \FOS\UserBundle\Model\User implements NotifyPropertyInterface, EquatableInterface
{
    use NotifyProperty;

    public function setId($id)
    {
        $this->propertyChanged('id', $this->id, $id);

        $this->id = $id;

        return $this;
    }

    public function setSalt($salt)
    {
        $this->propertyChanged('salt', $this->salt, $salt);

        $this->salt = $salt;

        return $this;
    }

    public function removeRole($role)
    {
        $oldRoles = $this->roles;
        parent::removeRole($role);
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function addRole($role)
    {
        $oldRoles = $this->roles;
        parent::addRole($role);
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function setUsername($username)
    {
        $this->propertyChanged('username', $this->username, $username);

        return parent::setUsername($username);
    }

    public function setUsernameCanonical($usernameCanonical)
    {
        $this->propertyChanged('usernameCanonical', $this->usernameCanonical, $usernameCanonical);

        return parent::setUsernameCanonical($usernameCanonical);
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function setCredentialsExpireAt(\DateTime $date = null)
    {
        $this->propertyChanged('credentialsExpireAt', $this->credentialsExpireAt, $date);

        return parent::setCredentialsExpireAt($date);
    }

    /**
     * @param boolean $boolean
     *
     * @return User
     */
    public function setCredentialsExpired($boolean)
    {
        $this->propertyChanged('credentialsExpired', $this->credentialsExpired, $boolean);

        return parent::setCredentialsExpired($boolean);
    }

    public function setEmail($email)
    {
        $this->propertyChanged('email', $this->email, $email);

        return parent::setEmail($email);
    }

    public function setEmailCanonical($emailCanonical)
    {
        $this->propertyChanged('emailCanonical', $this->emailCanonical, $emailCanonical);

        return parent::setEmailCanonical($emailCanonical);
    }

    public function setEnabled($boolean)
    {
        $this->propertyChanged('enabled', $this->enabled, (boolean)$boolean);

        return parent::setEnabled($boolean);
    }

    /**
     * Sets this user to expired.
     *
     * @param Boolean $boolean
     *
     * @return User
     */
    public function setExpired($boolean)
    {
        $this->propertyChanged('expired', $this->expired, (boolean)$boolean);

        return parent::setExpired($boolean);
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function setExpiresAt(\DateTime $date = null)
    {
        $this->propertyChanged('expiresAt', $this->expiresAt, $date);

        return parent::setExpiresAt($date);
    }

    public function setPassword($password)
    {
        $this->propertyChanged('password', $this->password, $password);

        return parent::setPassword($password);
    }

    public function setSuperAdmin($boolean)
    {
        $oldRoles = $this->roles;
        parent::setSuperAdmin($boolean);
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function setLastLogin(\DateTime $time = null)
    {
        $this->propertyChanged('lastLogin', $this->lastLogin, $time);

        return parent::setLastLogin($time);
    }

    public function setLocked($boolean)
    {
        $this->propertyChanged('locked', $this->locked, $boolean);

        return parent::setLocked($boolean);
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->propertyChanged('confirmationToken', $this->confirmationToken, $confirmationToken);

        return parent::setConfirmationToken($confirmationToken);
    }

    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        $this->propertyChanged('passwordRequestedAt', $this->passwordRequestedAt, $date);

        return parent::setPasswordRequestedAt($date);
    }

    public function setRoles(array $roles)
    {
        $oldRoles = $this->roles;
        parent::setRoles($roles);
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function setGroups(array $groups)
    {
        $oldGroups = $this->groups;
        $this->groups = $groups;
        $this->propertyChanged('groups', $oldGroups, $this->groups);

        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function getExpired()
    {
        return $this->expired;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Implementation of EquatableInterface
     *
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * Also implementation should consider that $user instance may implement
     * the extended user interface `AdvancedUserInterface`.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if ($user instanceof User) {
            // Check that the roles are the same, in any order
            $isEqual = count($this->getRoles()) == count($user->getRoles());
            if ($isEqual) {
                foreach ($this->getRoles() as $role) {
                    $isEqual = $isEqual && in_array($role, $user->getRoles());
                }
            }
            return $isEqual;
        }

        return false;
    }
}
