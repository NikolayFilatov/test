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
			'my' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/my',
					'defaults' => [
						'controller' => 'Application\Controller\My',
						'action'     => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'wall' => [
						'type'    => 'Zend\Mvc\Router\Http\Segment',
						'options' => [
							'route'    => '/wall[/:param]',
							'defaults' => [
								'controller' => 'Application\Controller\My',
								'action'     => 'wall',
							],
						],
						'may_terminate' => true,
					],
					'res' => [
						'type'    => 'Zend\Mvc\Router\Http\Segment',
						'options' => [
							'route'    => '/res[/:param]',
							'defaults' => [
								'controller' => 'Application\Controller\My',
								'action'     => 'res',
							],
						],
						'may_terminate' => true,
					],
					'sett' => [
						'type'    => 'Zend\Mvc\Router\Http\Segment',
						'options' => [
							'route'    => '/sett[/:param]',
							'defaults' => [
								'controller' => 'Application\Controller\My',
								'action'     => 'sett',
							],
						],
						'may_terminate' => true,
					],
					'spec' => [
						'type'    => 'Zend\Mvc\Router\Http\Segment',
						'options' => [
							'route'    => '/spec[/:param]',
								'defaults' => [
								'controller' => 'Application\Controller\My',
								'action'     => 'spec',
							],
						],
						'may_terminate' => true,
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
                    'firms' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/firms',
					'defaults' => [
						'controller' => 'Application\Controller\Index',
						'action'     => 'firms',
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
		            'walldelete' => [
			            'type'    => 'Zend\Mvc\Router\Http\Segment',
			            'options' => [
				            'route'    => '/walldelete',
				            'defaults' => [
					            'controller' => 'Application\Controller\Api',
					            'action'     => 'walldelete',
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