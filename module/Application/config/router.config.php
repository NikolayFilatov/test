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
            'newMenu' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/newMenu[/:timestamp]',
                    'defaults' => [
                        'controller' => 'Application\Controller\Menu',
                        'action'     => 'newMenu',
                    ],
                ],
                'may_terminate' => true,
            ],
            'allorder' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/allorder',
                    'defaults' => [
                        'controller' => 'Application\Controller\Orders',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'dish' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/dish[/:timestamp]',
                            'defaults' => [
                                'controller' => 'Application\Controller\Orders',
                                'action'     => 'dish',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'user' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/user[/:timestamp]',
                            'defaults' => [
                                'controller' => 'Application\Controller\Orders',
                                'action'     => 'user',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'getFile' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/getFile[/:timestamp]',
                            'defaults' => [
                                'controller' => 'Application\Controller\Orders',
                                'action'     => 'getFile',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'catalog' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/catalog',
                    'defaults' => [
                        'controller' => 'Application\Controller\Catalog',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'group' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/group/:id',
                            'defaults' => [
                                'controller' => 'Application\Controller\Catalog',
                                'action'     => 'group',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'order' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/order[/:timestamp]',
                    'defaults' => [
                        'controller' => 'Application\Controller\Order',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
            'eating' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/eating[/:timestamp]',
                    'defaults' => [
                        'controller' => 'Application\Controller\Eating',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
            'test' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/test',
                    'defaults' => [
                        'controller' => 'Application\Controller\Order',
                        'action'     => 'test',
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
                    'updateUserColor' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/updateUserColor',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'updateUserColor',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'updateUserBack' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/updateUserBack',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'updateUserBack',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'updateUserName' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/updateUserName',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'updateUserName',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'closeOrder' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/closeOrder',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'closeOrder',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'openOrder' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/openOrder',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'openOrder',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'getAjaxMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/getAjaxMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'getAjaxMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'getAjaxList' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/getAjaxList',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'getAjaxList',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'removeItemMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/removeItemMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'removeItemMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'changeItemById' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/changeItemById',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'changeItemById',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'addItemToMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/addItemToMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'addItemToMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'addGroupItemToMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/addGroupItemToMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'addGroupItemToMenu',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'removeAllItemFromMenu' => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => '/removeAllItemFromMenu',
                            'defaults' => [
                                'controller' => 'Application\Controller\Api',
                                'action'     => 'removeAllItemFromMenu',
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
