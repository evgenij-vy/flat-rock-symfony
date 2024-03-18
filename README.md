# flat-rock-symfony

### SETUP:
* check if the following packages are installed (install if needed):
  * make
  * yarn
  * docker (with rootless)
  * docker-compose
* run command: `make setup`

### USAGE:
- after setup, the app will be starting:
  - api-doc: http://localhost:8080/docs
  - app: http://localhost:3000
- for stop app use command `make down`
- all next starts of app use `make up`
- the first registered user will be the admin
