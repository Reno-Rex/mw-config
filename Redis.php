<?php

// Locally hosted and used for object caching
$wgObjectCaches['redis-local'] = [
	'class' => 'RedisBagOStuff',
	'servers' => [ '127.0.0.1:6379' ],
	'password' => $wmgRedisPassword,
	'persistent' => true,
	'loggroup' => 'redis',
	'reportDupes' => false,
];

// misc2 (used for sessions)
$wgObjectCaches['redis-central'] = [
	'class' => 'RedisBagOStuff',
	'servers' => [ '/run/nutcracker/nutcracker.sock' ],
	'password' => $wmgRedisPassword,
	'persistent' => true,
	'loggroup' => 'redis',
	'reportDupes' => false,
];

/*$wgMemCachedServers = [
	'127.0.0.1:11211'
];*/

$wgMainCacheType = 'redis-central';
$wgSessionCacheType = 'redis-central';
$wgSessionsInObjectCache = true;

$wgMessageCacheType = CACHE_DB;
$wgUseLocalMessageCache = true;
$wgParserCacheType = CACHE_DB;
$wgLanguageConverterCacheType = CACHE_DB;

$redisLocal = $wmgUseNewServers ? '51.89.160.135:6379' : '81.4.127.174:6379';

$wgJobTypeConf['default'] = [
	'class' => 'JobQueueRedis',
	'redisServer' => $redisLocal,
	'redisConfig' => [
		'connectTimeout' => 2,
		'password' => $wmgRedisPassword,
		'compression' => 'gzip',
	],
	'claimTTL' => 3600,
	'daemonized' => true,
];

$wgJobQueueAggregator = [
	'class' => 'JobQueueAggregatorRedis',
	'redisServers' => [ $redisLocal, $redisLocal ], // fake redis fallback
	'redisConfig' => [
		'connectTimeout' => 2,
		'password' => $wmgRedisPassword,
		'compression' => 'gzip',
	]
];
