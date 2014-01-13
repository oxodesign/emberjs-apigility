<?php
return array(
    'router' => array(
        'routes' => array(
            'todo-api.rest.todos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/todos[/:todos_id]',
                    'defaults' => array(
                        'controller' => 'TodoApi\\V1\\Rest\\Todos\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'todo-api.rest.todos',
        ),
    ),
    'zf-rest' => array(
        'TodoApi\\V1\\Rest\\Todos\\Controller' => array(
            'listener' => 'TodoApi\\V1\\Rest\\Todos\\TodosResource',
            'route_name' => 'todo-api.rest.todos',
            'identifier_name' => 'todos_id',
            'collection_name' => 'todos',
            'resource_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'TodoApi\\V1\\Rest\\Todos\\TodosEntity',
            'collection_class' => 'TodoApi\\V1\\Rest\\Todos\\TodosCollection',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'TodoApi\\V1\\Rest\\Todos\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'TodoApi\\V1\\Rest\\Todos\\Controller' => array(
                0 => 'application/vnd.todo-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'TodoApi\\V1\\Rest\\Todos\\Controller' => array(
                0 => 'application/vnd.todo-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'TodoApi\\V1\\Rest\\Todos\\TodosEntity' => array(
                'identifier_name' => 'todos_id',
                'route_name' => 'todo-api.rest.todos',
                'hydrator' => 'ArraySerializable',
            ),
            'TodoApi\\V1\\Rest\\Todos\\TodosCollection' => array(
                'identifier_name' => 'todos_id',
                'route_name' => 'todo-api.rest.todos',
            ),
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(
            'TodoApi\\V1\\Rest\\Todos\\TodosResource' => array(
                'adapter_name' => 'Demo\\Apigility\\TodoApi',
                'table_name' => 'todos',
                'hydrator_name' => 'ArraySerializable',
                'controller_service_name' => 'TodoApi\\V1\\Rest\\Todos\\Controller',
                'table_service' => 'TodoApi\\V1\\Rest\\Todos\\TodosResource\\Table',
            ),
        ),
    ),
);
