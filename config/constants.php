<?php

return [
	'DEFAULT_PASSWORD' =>'password',
	'USER_ROLE_ID' => 1,
	'USER_ROLE' => 'Super Administrator',
	'PAGE_LENGTH' => 10,
	'DATE_FORMATE' => 'm/d/Y',
	'DB_DATE_FORMATE' => 'Y-m-d',
	'LEFT_MENU' =>[
		'Trips' => [
			'routename' => 'trips.index',
			'subMenu' => [],
			'icon' => 'far fa-compass',
			'id' => 'trips',
		],
		'Cabins' => [
			'routename' => 'assignment.cabins',
			'subMenu' => [],
			'icon' => 'far fa-list-alt',
			'id' => 'cabins',
		],
		/*'Scheduling' => [
			'routename' => 'schedule.index',
			'subMenu' => [
				'Student Scheduling' => 'schedule.student',
			],
			'icon' => 'fa-user-alt',
			'id' => 'schedule',
		],'Reports' => [
			'routename' => 'reports.index',
			'subMenu' => [],
			'icon' => 'fa-user-alt',
			'id' => 'Reports',
		],*/
		'Records' => [
			'routename' => 'records',
			'subMenu' => [
				'Role Management' => 'roles.index',
				'User Management' => 'users.index',
				'District Management' => 'districts.index',
				'School Administrator' => 'administrators.index',
				'School Management' => 'schools.index',
				'Email Template' => 'emailTemplates.index',
				'Cabin Management' => 'cabins.index'
			],
			'icon' => 'fa-user-alt',
			'id' => 'records',
		],
		'Admin' => [
			'routename' => 'admins',
			'subMenu' => [
				'Staff Assignment' => 'staffAssignments.index',
			],
			'icon' => 'fa-user-alt',
			'id' => 'admins',
		]
	],
	'schoolTypes' => [
		'B' => '5th & 6th',
		'F' => '5th',
		'H' => 'High School',
		'J' => 'Junior High',
		'S' => '6th',
	],
	'weekDays' => [
		'' => '',
		//'1' => '1 Day',
		'3' => '3 Day Week',
		'4' => '4 Day Week',
		'5' => '5 Day Week',
	],
	'villageTypes' => [
		'Bear_Creek' => [
			'name' => 'BEAR CREEK',
			'per_cabin' => 3,
			'trail' => 5,
		],
		'Eagle_Point' => [
			'name' => 'EAGLE POINT',
			'per_cabin' => 4,
			'trail' => 4,
		],
	],
	'administratorTitles' => [
		'A' => 'Administrator',
		'AP' => 'Assistant Principal',
		'D' => 'Director',
		'LT' => 'Lead Teacher',
		'P' => 'Principal',
		'S' => 'Superintendent',
	],
	'administratorPositions' => [
		'A' => 'Administrator',
		'P' => 'Principal',
		'S' => 'Superintendent',
	],
	'teacherCabins' =>[
		'Male' =>['A','B','C','D','E','F','G','H','I'],
		'Female' =>['J','K','L','M','N','O','P','Q','R'],
	]
];