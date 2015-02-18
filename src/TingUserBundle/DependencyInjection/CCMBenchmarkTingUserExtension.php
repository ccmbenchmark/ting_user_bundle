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


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CCMBenchmarkTingUserExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['TingBundle']) === false || isset($bundles['FOSUserBundle']) === false) {
            throw new \RuntimeException(
                'You need to start CCMBenchmarkTingBundle and FosUserBundle to use this bundle'
            );
        }

        $configs = $container->getExtensionConfig($this->getAlias());

        $config = $this->processConfiguration(new Configuration($container->getParameter('kernel.debug')), $configs);

        /**
         *  Now we define options for fos. Reference:
         *
         *     db_driver:            ~ # Required
         *     user_class:           ~ # Required
         *     group:
         *        group_class:       ~ # Required
         *        group_manager:     fos_user.group_manager.default
         *     service:
         *        user_manager:      fos_user.user_manager.default
         */

        $fosUserConfig = [
            'db_driver' => 'custom',
            'user_class' => $config['user']['class'],
            'group' => [
                'group_class' => $config['group']['class'],
                'group_manager' => 'ccmbenchmark_tinguserbundle.group_manager'
            ],
            'service' => [
                'user_manager' => 'ccmbenchmark_tinguserbundle.user_manager',
            ],

        ];
        $container->prependExtensionConfig('fos_user', $fosUserConfig);


        // We need to get a reflection on the user repository to add it to ting conf
        $userRepositoryReflection = new \ReflectionClass($config['user']['repository']);
        $userRepositoryNamespace = $userRepositoryReflection->getNamespaceName();

        $tingConfig = $this->addNamespaceToTingConfiguration(
            [],
            $userRepositoryReflection,
            $config['options']['connection'],
            $config['options']['database']
        );


        $groupRepositoryReflection = new \ReflectionClass($config['group']['repository']);
        $groupRepositoryNamespace = $groupRepositoryReflection->getNamespaceName();

        // If the group and user repositories are in the same namespace : we don't need to define the conf twice
        if ($groupRepositoryNamespace !== $userRepositoryNamespace) {
            $tingConfig = $this->addNamespaceToTingConfiguration(
                $tingConfig,
                $groupRepositoryReflection,
                $config['options']['connection'],
                $config['options']['database']
            );
        }
        $container->prependExtensionConfig('ting', ['repositories' => $tingConfig]);
    }

    protected function addNamespaceToTingConfiguration(
        array $tingConfig,
        \ReflectionClass $class,
        $connection,
        $database
    ) {
        /**
         *
         * Default configuration for ting:
         *
         * repositories:
         *   namespace:            ~ # Required
         *   directory:            ~ # Required
         *   glob:                 '*Repository.php'
         *   options:
         *     connection:           ~
         *     database:             ~
         *
         */

        $namespace = $class->getNamespaceName();

        $directory = dirname($class->getFileName());

        /**
         * Glob is set to the filename : in this way, only
         * this repository will be loaded with this configuration
         */
        $filename = basename($class->getFileName());

        $tingConfig[] = [
            'namespace' => $namespace,
            'directory' => $directory,
            'glob'      => $filename,
            'options' => [
                'default' => [
                    'connection' => $connection,
                    'database'   => $database
                ]
            ]
        ];

        return $tingConfig;
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('ting_user.user_repository', $config['user']['repository']);
        $container->setParameter('ting_user.user_class', $config['user']['class']);
        $container->setParameter('ting_user.group_repository', $config['group']['repository']);
        $container->setParameter('ting_user.group_class', $config['group']['class']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
