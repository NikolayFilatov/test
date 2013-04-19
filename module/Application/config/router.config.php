<?php
return [
	'router' => [
		'routes' => [
			'home' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/',
					'defaults' => [
						'controller' => 'Application\Controller\Index',
						'action'     => 'index',
					],
				],
			],
            'deny' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/deny',
					'defaults' => [
						'controller' => 'Application\Controller\Index',
						'action'     => 'deny',
					],
				],
				'may_terminate' => true,
			],
            'menu' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/menu',
					'defaults' => [
						'controller' => 'Application\Controller\Menu',
						'action'     => 'index',
					],
				],
				'may_terminate' => true,
			],
            'orders' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/orders',
                    'defaults' => [
                        'controller' => 'Application\Controller\Orders',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
            'catalog' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/catalog',
                    'defaults' => [
                        'controller' => 'Application\Controller\Catalog',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
			/*
			 * API Controllers
			*/
			'api' => [
				'type'    => 'Literal',
				'options' => [
					'route'    => '/api',
					'defaults' => [
						'controller' => 'Application\Controller\My',
						'action'     => 'index',
					],
				],
				'may_terminate' => false,
				'child_routes' => [
		            'updateCatalog' => [
			            'type'    => 'Zend\Mvc\Router\Http\Segment',
			            'options' => [
				            'route'    => '/updateCatalog',
				            'defaults' => [
					            'controller' => 'Application\Controller\Api',
					            'action'     => 'updateCatalog',
				            ],
			            ],
			            'may_terminate' => true,
		            ],
				],
			],
			
			
			// The following is a route to simplify getting started creating
			// new controllers and actions without needing to create a new
			// module. Simply drop new controllers in, and you can access them
			// using the path /application/:controller/:action
			'application' => [
				'type'    => 'Literal',
				'options' => [
					'route'    => '/application',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type'    => 'Segment',
						'options' => [
							'route'    => '/[:controller[/:action]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults' => [
							],
						],
					],
				],
			],
		],
	],
];