DCSOpauthBundle
===============

**DCSOpauthBundle** is a Symfony2 bundle that enables support for many authentication providers through the [Opauth](http://opauth.org/) framework.

## Installation

### a) Download and install DCSOpauthBundle

To install DCSOpauthBundle run the following command

	bash $ php composer.phar require damianociarla/opauth-bundle

### b) Install Opauth strategy

To install the Opauth strategy, you need find the required package on Packagist or on GitHub and add it to the require list of your project's composer.json file.

This is an example of the Facebook strategy:

    bash $ php composer.phar require opauth/facebook

### b) Enable the bundle

To enable it add the bundle instance in the kernel:

	<?php
	// app/AppKernel.php

	public function registerBundles()
	{
	    $bundles = array(
        	// ...
        	new DCS\OpauthBundle\DCSOpauthBundle(),
    	);
	}

### c) Configure the bundle

Now that you have properly enabled the DCSOpauthBundle, the next step is to configure the bundle to work with the specific needs of your application.

Add the following configuration to your config.yml file according the types of strategies you want to use in your application.

    # app/config/config.yml

    dcs_opauth:
        strategies:
            # The name of the strategy is personal. es: google, facebook, google_app_2 etc...
            google:
                id:             YOUR_CLIENT_ID
                secret:         YOUR_CLIENT_SECRET
                strategy_class: Google

            # Facebook example with option scope
            facebook:
                id:             YOUR_APP_ID
                secret:         YOUR_APP_SECRET
                strategy_class: Facebook
                options:
                    scope: "email"

For a list of the configurations of the strategies refer to the original configuration of Opauth library.

### d) Import DCSOpauthBundle routing files

Now that you have activated and configured the bundle, all that is left to do is import the DCSOpauthBundle routing files:

    # app/config/routing.yml

    dcs_opauth_connect:
        resource: "@DCSOpauthBundle/Resources/config/routing/connect.xml"
        prefix: /connect

    dcs_opauth_response:
        resource: "@DCSOpauthBundle/Resources/config/routing/response.xml"
        prefix: /connect

## How does it work?

DCSOpauthBundle logs on the selected provider and provides a token to use in the user's session.

### How to log on the provider?

You must perform a redirect on the route `dcs_opauth_connect` passing the parameter {provider}

    # twig example

    <a href="{{ url('dcs_opauth_connect', {'provider' : 'google'}) }}">Login with Google</a>

## Complete configuration

    dcs_opauth:
        debug_mode: false                                       # (boolean) Whether debug messages are to be displayed
        callback_transport: session                             # ('session','post','get') HTTP transport type, for sending of Auth response
        security_iteration: 300                                 # (int) The number of times hashing is done to sign auth response
        security_timeout: 2 minutes                             # (string) Time limit allowed for an auth response to be considered valid
        authentication_roles: [ROLE_USER]                       # (array) Roles to associate with the token
        redirect_after_response: ~                              # (string) Path or view_name to redirect user after login
        error_view: DCSOpauthBundle:Response:error.html.twig    # (string) View name to display the errors if the login fails
        logic:
            strategy_parser: dcs_opauth.configuration.strategy_parser.default   # Service name to retrieve the config for a specific strategy
            response_parser: dcs_opauth.response.response_parser.default        # Service name to parse the Opauth's response
            authenticator: dcs_opauth.security.authenticator.default            # Service name that autenticates user
        strategies:
            NAME:
                id:                 SECRET_ID
                secret:             SECRET_KEY
                strategy_class:     STRATEGY_CLASS
                options:            STRATEGY OPTIONS
