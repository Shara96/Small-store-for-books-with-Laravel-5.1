<?php

return array(
	# Account credentials from developer portal
	'Account' => array(
		'ClientId' => 'Af7UQVY3s6YJDjkrcJmWvzimaYpbGB2WM6dNLkNn5-cGE-TIRLywMmjV2KnHBGca5rbkDiUv4oZzbzXY',
		'ClientSecret' => 'ENMe0F93_lxV_26dmw8Be3Grey4IAGDJjWlqsH2VotWHi5m0VEhS1g5THDmZ3ML7VzLp8r8-l2uFkGvM',
	),

	# Connection Information
	'Http' => array(
        'ConnectionTimeOut' => 30,
		'Retry' => 1,
		//'Proxy' => 'http://[username:password]@hostname[:port][/path]',
	),

	# Service Configuration
	'Service' => array(
		# For integrating with the live endpoint,
		# change the URL to https://api.paypal.com!
		'EndPoint' => 'https://api.sandbox.paypal.com',
	),


	# Logging Information
	'Log' => array(
		'LogEnabled' => true,

		# When using a relative path, the log file is created
		# relative to the .php file that is the entry point
		# for this request. You can also provide an absolute
		# path here
		'FileName' => '../PayPal.log',

		# Logging level can be one of FINE, INFO, WARN or ERROR
		# Logging is most verbose in the 'FINE' level and
		# decreases as you proceed towards ERROR
		'LogLevel' => 'FINE',
	),
);
