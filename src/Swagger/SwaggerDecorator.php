<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Token'] = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['Credentials'] = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'email@hmail.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'mystrongpassword',
                ],
            ],
        ];


        $docs['components']['schemas']['Credentials2'] = [
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'e@mail.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'mystrongpassword',
                ],
            ],
        ];

        $docs['components']['schemas']['U'] = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'email@hmail.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'mystrongpassword',
                ],
                'firstname' => [
                    'type' => 'string',
                    'example' => 'Firstname (optional)'
                ],
                'lastname' => [
                    'type' => 'string',
                    'example' => 'Lastname (optional)'
                ],
            ]
        ];

        $docs['components']['schemas']['Us'] = [
            'type' => 'object',
            'properties' => [
                'success' => [
                    'type' => 'boolean',
                    'example' => 'true',
                ],
                'user' => [
                    '$ref' => '#/components/schemas/User',
                ]
            ]
        ];

        $docs['components']['schemas']['Us2'] = [
            'type' => 'object',
            'properties' => [
                'error' => [
                    'type' => 'boolean',
                    'example' => 'true',
                ],
                'message' => [
                    'type' => 'string',
                    'example' => "L'email est déjà utilisée",
                ]
            ]
        ];

        $docs['components']['schemas']['Cities'] = [
            'type' => 'array',
            'properties' => [
                'city' => [
                    'type' => 'string',
                    'example' => 'Compiègne',
                ],
                'nbTrips' => [
                    'type' => 'int',
                    'example' => "3",
                ]
            ]
        ];

        $tokenDocumentation = [
            'paths' => [
                '/api/trips/cities' => [
                    'get' => [
                        'tags' => ['Trip'],
                        'operationId' => 'getCities',
                        'summary' => 'Get cities used in trips',
                        'requestBody' => [
                            'description' => 'Get cities used in trips',
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Cities',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Cities',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/me' => [
                    'get' => [
                        'tags' => ['User'],
                        'operationId' => 'getMe',
                        'summary' => 'Get user logged in',
                        'requestBody' => [
                            'description' => 'Get current user',
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'User',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/User',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/password' => [
                    'post' => [
                        'tags' => ['User'],
                        'operationId' => 'checkPassword',
                        'summary' => 'Check if password correspond to current user',
                        'requestBody' => [
                            'description' => 'Check if password correspond to current user',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'password' => [
                                                'type' => 'string',
                                                'example' => 'mystrongpassword',
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'User',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'valid' => [
                                                    'type' => 'boolean',
                                                    'example' => 'true',
                                                ],
                                            ]
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/login_check' => [
                    'post' => [
                        'tags' => ['Token'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Credentials2',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/register' => [
                    'post' => [
                        'tags' => ['User'],
                        'operationId' => 'postUser',
                        'summary' => 'Create a new account',
                        'requestBody' => [
                            'description' => 'Create new account',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/U',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Success',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Us',
                                        ],
                                    ],
                                ],
                            ],
                            Response::HTTP_FORBIDDEN => [
                                'description' => 'Error',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Us2',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}