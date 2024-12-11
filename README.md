## REQUSITO:
Si richiede al candidato di realizzare un'API REST che resitiuisca un whois. 
L'API dev'essere realizzata in PHP ed esporre i dati in format JSON. Il servizio deve accettare richieste HTTP GET per eseguire query WHOIS sui domini. Se il dominio non è valido, non è un .com o si verifica un altro errore, deve restituire un errore con un codice di stato appropriato, conforme alle RFC API REST HTTP standard. Per ciascuno dei metodi dev'essere implementato il relativo Unit test, con un test per caso d'uso. Il codice dev'essere fornito tramite repository GIT a scelta del candidato. Il candidato è libero di utilizzare qualsiasi framework e/o libreria desideri. Incapsulamento Docker: il servizio deve essere fornito completamente funzionale all'interno di un contenitore Docker, pronto per l'esecuzione.

##
- PHP 8.1.10
- LARAVEL 10.48.25
- DOCKER 27.3.1

##
API DOCUMENTATION: http://localhost:8000/
##
API TEST: RUN > php artisan test --env=testing

##
WHOIS SERVICE: per ottenere le info sui domini è stato utilizzato un servizio gratuito https://who-dat.as93.net/


