### Installation

The project is dockerized and configured to work with docker-compose
- to run the container, use `docker compose up -d`
- use `docker compose exec -T app_mysql mysql -u root --password=mysql_root_password app_db < migrations/up/000000001.sql` to set up database

### Commands
- add Group 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console user:create-group group_1`
- add User 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console user:create-user user_1 group_1`
- add Module 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console module:create-module module_1`
- add ModuleFunction 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console module:create-module-function module_function_1 module_1`
- add Permission 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console permission:create-permission view`
- connect Permission to Module
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console permission:connect-permission-to-module view --module=module_1`
- assign ModulePermission to User
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console permission:assign-module-permission-to-user --module=module_1 --group=group_1`
- check Permission 
- `docker compose run --rm -e XDEBUG_MODE=off app_php php bin/console permission:check-permission user_1 module_function_1`