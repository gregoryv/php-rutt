all: test

test:
	./vendor/bin/phpunit 

coverage:
	./vendor/bin/phpunit --coverage-html /tmp/coverage 

api:
	apigen generate --source src --destination api.new

pages: api
	git checkout gh-pages
	rm -rf api
	mv api.new api
