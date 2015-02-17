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


use CCMBenchmark\TingUserBundle\Model\Group\GroupRepository;
use FOS\UserBundle\Model\GroupInterface;

class GroupManager extends \FOS\UserBundle\Model\GroupManager
{
    protected $groupRepository = null;
    protected $groupClass = '';

    public function setGroupRepository(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function setGroupClass($groupClass)
    {
        $this->groupClass = $groupClass;
    }

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->groupClass;
    }

    /**
     * Deletes a group.
     *
     * @param GroupInterface $group
     *
     * @return void
     */
    public function deleteGroup(GroupInterface $group)
    {
        $this->groupRepository->delete($group);
    }

    /**
     * Finds one group by the given criteria.
     *
     * @param array $criteria
     *
     * @return GroupInterface
     */
    public function findGroupBy(array $criteria)
    {
        return $this->groupRepository->getOneByCriteria($criteria);
    }

    /**
     * Returns a collection with all user instances.
     *
     * @return \Traversable
     */
    public function findGroups()
    {
        return $this->groupRepository->getAll();
    }

    /**
     * Updates a group.
     *
     * @param GroupInterface $group
     *
     * @return void
     */
    public function updateGroup(GroupInterface $group)
    {
        $this->groupRepository->save($group);
    }
}
