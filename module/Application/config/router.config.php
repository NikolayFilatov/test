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
				'type' => 'Segment',
				'options' => [
					'route' => '/menu[/:timestamp]',
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
            'order' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/order',
                    'defaults' => [
                        'controller' => 'Application\Controller\Order',
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
                    'removeDish' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/removeDish',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'removeDish',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'restoreDish' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/restoreDish',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'restoreDish',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'removeDishGroup' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/removeDishGroup',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'removeDishGroup',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'addDish' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/addDish',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'addDish',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'addDishGroup' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/addDishGroup',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'addDishGroup',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'createMenuCatalog' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/createMenuCatalog',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'createMenuCatalog',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'excludeMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/excludeMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'excludeMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'includeMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/includeMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'includeMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'addItemToOrder' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/addItemToOrder',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'addItemToOrder',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'removeItemFromOrder' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/removeItemFromOrder',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'removeItemFromOrder',
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