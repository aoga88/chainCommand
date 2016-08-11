ChainCommand Test Project
==========

Symfony 2 project to test command chain.

Add more commands to chain
==========================

To add more commands to foo:hello chain, just need to add them to `src/FooBundle/Resources/config/services.yml` in the getChain array.
```Yaml
- [getChain, [['bar:hi']]]
```

Install
=======

- composer install
- php app/console foo:hello
- php app/console bar:hi Can't be executed by itself, it's part of foo:hello chain

Test
====
- phpunit -c app/phpunit.xml.dist
