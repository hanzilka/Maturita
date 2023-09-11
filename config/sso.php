<?php

//config:

// URL SSO GATEWAY
$ssoconfig['gateway_url'] = 'https://titan.spsostrov.cz/ssogw/';

# Force use of https protocol when passing callback url to Gateway.
# optional, default false
# $ssoconfig['force_https'] = true;

# If you want to use built-in logon persistence framework,
# this is interface class name
# optional, default null
$ssoconfig['persistence-class'] = 'Auth_SSO_Persistence_Session';

# Configuration for persitence class
# optional, default null

# Auth_SSO_Persistence_Session
# Session base path - for the session security
$ssoconfig['persistence-config']['path'] = '/';

# Auth_SSO_Persistence_Session
# Session name
$ssoconfig['persistence-config']['name'] = 'ssosession';


### Basic authorization layer:

# At application level you can define many 'roles' and after successful
# logon check if current user is a member of given role.
# One use may be a member of several roles.
# Typical roles usage:
#  - access = ussers approved to use the application
#  - admin = administrators of the aplication

# There, in config, you set up mapping users and groups to 'roles'.
# If you define user-mapping and group-mapping rules for the same
# role, result is logical OR of these rules.

# Example - group list for role 'access':
$ssoconfig['roles']['access']['group'] = array('ucitele', 'thp');
# Example - login list for role 'access':
$ssoconfig['roles']['access']['login'] = array('ucitel2', 'rodimi');
# Example - login list for role 'admin':
$ssoconfig['roles']['admin']['login'] = array('stark', 'vlastik', 'michja');
