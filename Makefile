SHELL := /bin/bash

tests:
	symfony php bin/phpunit $@
.PHONY: tests

deploy:
	gcloud run deploy password-generator --max-instances=1 --memory=128Mi --region=europe-west1 --allow-unauthenticated --source=.
.PHONY: deploy