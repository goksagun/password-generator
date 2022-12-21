SHELL := /bin/bash

tests:
	symfony php bin/phpunit $@
.PHONY: tests