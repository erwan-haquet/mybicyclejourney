# Tests
Tests are split into 3 categories :
- `Application` : Checks the integration of all the different layers of the application (from the routing to the views).

## Setup
To run Application tests, you'll first need to perform a database schema update for test database :
```bash
$ bin/console doctrine:migration:migrate --env=test
```

To run test :
```bash
$ make test                         # Run all tests
$ make test --testsuite=application # Run application tests
```
