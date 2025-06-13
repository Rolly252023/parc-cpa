.PHONY: cc ccnow ccp install cities start

# Vider le cache (en dev)
cc:
	php bin/console cache:clear

# Vider le cache (en dev) no warmup
ccnow:
	php bin/console cache:clear --no-warmup

# Vider le cache en prod
ccp:
	php bin/console cache:clear --env=prod --no-debug

# Installer les dépendances
install:
	composer install

cities:
	curl -L -o imports/cities.csv https://www.data.gouv.fr/fr/datasets/villes-de-france/#/resources/51606633-fb13-4820-b795-9a2a575a72f1
	
start:
	symfony server:start