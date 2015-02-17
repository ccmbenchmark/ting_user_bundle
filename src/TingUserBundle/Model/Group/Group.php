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

namespace CCMBenchmark\TingUserBundle\Model\Group;


use CCMBenchmark\Ting\Entity\NotifyProperty;
use CCMBenchmark\Ting\Entity\NotifyPropertyInterface;

class Group extends \FOS\UserBundle\Model\Group implements NotifyPropertyInterface
{
    use NotifyProperty;

    public function setId($id)
    {
        $this->propertyChanged('id', $this->id, $id);

        $this->id = $id;

        return $this;
    }

    public function addRole($role)
    {
        $oldRoles = $this->roles;
        if (!$this->hasRole($role)) {
            $this->roles[] = strtoupper($role);
        }
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function removeRole($role)
    {
        $oldRoles = $this->roles;

        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $this;
    }

    public function setName($name)
    {
        $this->propertyChanged('name', $this->name, $name);

        return parent::setName($name);
    }

    public function setRoles(array $roles)
    {
        $oldRoles = $this->roles;
        $return = parent::setRoles($roles);
        $this->propertyChanged('roles', $oldRoles, $this->roles);

        return $return;
    }
}
