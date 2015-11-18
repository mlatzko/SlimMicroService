<?php

namespace SlimMicroService\Serializer;

class EntitySerializer
{
    public static function toArray(array $fields, $args, $entity)
    {
        $record = array(
            'uri' => '/' . $args['resource'] . '/' . $entity->getId(),
        );

        foreach ($fields as $key => $value) {
            $methodName = 'get' . ucfirst($valuasde['fieldName']);

            $record[$value['fieldName']] = $entity->$methodName();

            if('datetime' === $value['type']) {
                $record[$value['fieldName']] = $entity->$methodName()->format('c');
            }
        }

        unset($record['id']);

        return $record;
    }
}
