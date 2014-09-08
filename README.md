Demo user management application
================================

[![Build Status](https://magnum.travis-ci.com/egils/UserManagementDemo.svg?token=yaf3qhXqQD2zHyWnwiET&branch=master)](https://magnum.travis-ci.com/egils/UserManagementDemo)

Demo application.

Installation
------------

* Clone repository
* Install dependencies via composer
* Configure database connection in ``app/config/parameters.yml``
* chmod 0755 / acl ``app/cache`` and ``app/logs``
* ``php app/console doctrine:schema:update --force``
* see the users at local project url ``http://PROJECT_HOST/api/users``

API
---

API documentation available at local project url ``http://PROJECT_HOST/api/doc``

Security
--------

API is now protected with basic HTTP authentication. To be removed and changed with more advanced OAuth v2 server-client.
Only authenticated Admin cant manage data protected by

TODO
----

* OAuth2 authentication
* Users and groups merged with OAuth2 clients and security roles.
* Style HTML responses with Foundation/Bootstrap/Compass or regular CSS depending on the needs.

LICENSE
-------

MIT. For full content see ``LICENSE`` file.