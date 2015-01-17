<?php
/***********************************************************************
 *
 * TingUserBundle
 * ==========================================
 *
 * Copyright (C) 2014 CCM Benchmark Group. (http://www.ccmbenchmark.com)
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

namespace CCMBenchmark\TingUserBundle\Model;


use CCMBenchmark\Ting\Repository\Metadata;
use CCMBenchmark\Ting\Repository\Repository;
use CCMBenchmark\Ting\Serializer\SerializerFactoryInterface;
use CCMBenchmark\TingUserBundle\RuntimeException;

abstract class UserRepository extends Repository
{
    /**
     * @var null : This value have to be defined in your own class. Valid values are :
     *  - CCMBenchmark\Ting\Driver\Mysqli\Serializer\Bool
     *  - CCMBenchmark\Ting\Driver\Pgsql\Serializer\Bool
     *  - or any other class implementing CCMBenchmark\Ting\Serializer\SerializerInterface
     *      and managing boolean correctly
     */
    protected static $booleanSerializer = null;

    /**
     * This method needs to be overriden in the following way:
     *
     * public static function initMetadata(SerializerFactoryInterface $serializerFactory, $options = [])
     * {
     *      $metadata = parent::initMetadata($serializerFactory, $options);
     *      $metadata->setConnectionName('myConnectionName');
     *      $metadata->setDatabase('myDatabase');
     *      $metadata->setTable('myTableUsers');
     *      $metadata->setEntity('myEntity');
     *
     *      return $metadata;
     * }
     *
     * @param SerializerFactoryInterface $serializerFactory
     * @param array                      $options
     * @return Metadata
     * @throws \CCMBenchmark\Ting\Exception
     */
    public static function initMetadata(SerializerFactoryInterface $serializerFactory, $options = [])
    {
        if (static::$booleanSerializer === null) {
            throw new RuntimeException(
                'The boolean serializer is null. Please extends this class and define it ' .
                '(using the one from MySQL Driver or PgSQL Driver according to your database format).'
            );
        }

        $metadata = new Metadata($serializerFactory);

        $metadata->addField([
            'primary'       => true,
            'autoincrement' => true,
            'fieldName'     => 'id',
            'columnName'    => 'id',
            'type'          => 'int'
        ]);

        $metadata->addField([
            'fieldName'     => 'username',
            'columnName'    => 'username',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'usernameCanonical',
            'columnName'    => 'username_canonical',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'email',
            'columnName'    => 'email',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'emailCanonical',
            'columnName'    => 'email_canonical',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'enabled',
            'columnName'    => 'enabled',
            'type'          => 'boolean',
            'serializer'    => static::$booleanSerializer
        ]);

        $metadata->addField([
            'fieldName'     => 'salt',
            'columnName'    => 'salt',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'password',
            'columnName'    => 'password',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'lastLogin',
            'columnName'    => 'last_login',
            'type'          => 'datetime',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\DateTime'
        ]);

        $metadata->addField([
            'fieldName'     => 'confirmationToken',
            'columnName'    => 'confirmation_token',
            'type'          => 'string'
        ]);

        $metadata->addField([
            'fieldName'     => 'passwordRequestedAt',
            'columnName'    => 'password_requested_at',
            'type'          => 'datetime',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\DateTime'
        ]);

        /*$metadata->addField([
            'fieldName'     => 'groups',
            'columnName'    => 'groups',
            'type'          => 'string',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\Json'
        ]);*/

        $metadata->addField([
            'fieldName'     => 'locked',
            'columnName'    => 'locked',
            'type'          => 'boolean',
            'serializer'    => static::$booleanSerializer
        ]);

        $metadata->addField([
            'fieldName'     => 'expired',
            'columnName'    => 'expired',
            'type'          => 'boolean',
            'serializer'    => static::$booleanSerializer
        ]);

        $metadata->addField([
            'fieldName'     => 'expiresAt',
            'columnName'    => 'expires_at',
            'type'          => 'datetime',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\DateTime'
        ]);

        $metadata->addField([
            'fieldName'     => 'roles',
            'columnName'    => 'roles',
            'type'          => 'string',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\Json'
        ]);

        $metadata->addField([
            'fieldName'     => 'credentialsExpired',
            'columnName'    => 'credentials_expired',
            'type'          => 'boolean',
            'serializer'    => static::$booleanSerializer
        ]);

        $metadata->addField([
            'fieldName'     => 'credentialsExpireAt',
            'columnName'    => 'credentials_expire_at',
            'type'          => 'datetime',
            'serializer'    => '\CCMBenchmark\Ting\Serializer\DateTime'
        ]);

        return $metadata;
    }
}
