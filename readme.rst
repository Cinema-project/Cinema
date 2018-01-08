###################
Po instalacji
###################
Odpalamy www.example.com/index.php?/Update/update w celu uaktualnienia i zainicjowania bazy danych.
Operacja ta może potrać nawet kilkanaście minut. 

###################
Jak dokumentować kod PHP
###################
https://4programmers.net/PHP/Dokumentacja_kodu_PHP

###################
Konfiguracja PHP
###################
Wymagane do poprawnego działania modelu Multikina.
Odkomentować linijkę w pliku konfiguracyjnym php.ini:
extension=php_openssl.dll
Wymagane do działania bazy danych:
Odkomentować linijkę w pliku konfiguracyjnym php.ini:
extension=php_mysqli.dll

###################
Instalacja
###################
-  1.Pobieramy <https://www.apachefriends.org/pl/download.html> dla wersji 7.1
- 2.Instalujemy
- 3.C: ->xampp->htdocs wrzucamy cały folder "Cinema"
- 4.Odpalamy xamppa
- 5. Apache Start (musi sie zapalic na zielono)
- 6. Wpisujemy "localhost" w przeglądarke - wywali nas najprawdopodobniej do http://localhost/dashboard/ więc wpisujemy localhost/cinema

Plik do logowania to login.php

Rejestracja to register.php

Wyprowadziłem z reacta wartości do tych plików i zrobiłem testowe echo.
