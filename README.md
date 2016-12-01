ting-user-bundle

This bundle is an integration for Ting PHP Datamapper with Ting.

1. Installation
===============

 * ```composer require ccmbenchmark/ting_user_bundle```
 * Add these 2 lines into your AppKernel:

    ```
        new FOS\UserBundle\FOSUserBundle(),
        new CCMBenchmark\TingUserBundle\CCMBenchmarkTingUserBundle(),
    ```

 * Let's now configure your just pretty new bundle
 
2. Configuration
================

Minimal configuration:

    ```
        ccm_benchmark_ting_user:
            options:              # Required
                connection:           ~ # Required. Please give the connection name to use
                database:             ~ # Required. Please give the database name to use
        
        fos_user:
            firewall_name: main
    ```

The default configuration refers to Mysql. If you want to use Postgresql, please add these line to your configuration file :

    ```
        ccm_benchmark_ting_user:
            user:
                repository:           CCMBenchmark\TingUserBundle\Model\User\PgsqlUserRepository
    ```

This bundle defines the minimal configuration for FosUserBundle.
You can follow FosUserBundle tutorials to override templates or any other change.

3. Schemas
==========

Here is one sample schema for mysql:

    ```
        CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `enabled` tinyint(1) NOT NULL,
          `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `last_login` datetime DEFAULT NULL,
          `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
          `password_requested_at` datetime DEFAULT NULL,
          `roles` longtext COLLATE utf8_unicode_ci NOT NULL,
          `groups` longtext COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
          UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        
        CREATE TABLE `groups` (
          `id` int NOT NULL,
          `roles` longtext NOT NULL,
          `name` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ```