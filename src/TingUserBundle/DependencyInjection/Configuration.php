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

namespace CCMBenchmark\TingUserBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ccm_benchmark_ting_user');

        $rootNode
            ->children()
                ->arrayNode('user')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('CCMBenchmark\TingUserBundle\Model\User\User')->end()
                        ->scalarNode('repository')
                            ->defaultValue('CCMBenchmark\TingUserBundle\Model\User\UserRepository')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('group')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('CCMBenchmark\TingUserBundle\Model\Group\Group')->end()
                        ->scalarNode('repository')
                            ->defaultValue('CCMBenchmark\TingUserBundle\Model\Group\GroupRepository')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('options')
                    ->isRequired()
                    ->children()
                        ->scalarNode('connection')->isRequired()->end()
                        ->scalarNode('database')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
