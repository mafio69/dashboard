# Instrukcja Uruchomienia i Nauki - Dashboard

Ten plik opisuje kroki, które podjęliśmy, aby skonfigurować i uruchomić projekt personalizowanego dashboardu. Możesz go używać jako przewodnika, aby samodzielnie odtworzyć całe środowisko od zera.

## Architektura Projektu

Nasz projekt składa się z dwóch głównych części:

1.  **Backend (w katalogu `/backend`)**: Prosta aplikacja API napisana w PHP. Jej zadaniem jest dostarczanie danych.
2.  **Frontend (w katalogu `/frontend`)**: Aplikacja napisana w React. Jej zadaniem jest wyświetlanie interfejsu użytkownika i komunikacja z backendem.

---

## Jak Uruchomić Projekt Krok po Kroku

Aby uruchomić projekt, potrzebujesz dwóch terminali (konsol) – jednego dla backendu i jednego dla frontendu.

### Krok 1: Uruchomienie Backendu (Serwer PHP)

Nasz backend to na razie pojedynczy plik `index.php`, który zwraca proste dane w formacie JSON. Aby był on dostępny dla naszej aplikacji, musimy uruchomić wbudowany serwer PHP.

1.  Otwórz terminal.
2.  Przejdź do katalogu backendu:
    ```bash
    cd /home/mariusz/projects/dashboard/backend
    ```
3.  Uruchom serwer PHP na porcie **8888**:
    ```bash
    php -S localhost:8888
    ```

> **Ważne:** Ten serwer musi być uruchomiony przez cały czas, gdy chcesz korzystać z aplikacji. Terminal, w którym go uruchomiłeś, będzie zajęty przez ten proces.

### Krok 2: Uruchomienie Frontendu (Serwer React)

Frontend to aplikacja stworzona za pomocą `create-react-app`. Posiada ona własny serwer deweloperski, który automatycznie odświeża stronę po każdej zmianie w kodzie.

1.  Otwórz **drugi** terminal.
2.  Przejdź do katalogu frontendu:
    ```bash
    cd /home/mariusz/projects/dashboard/frontend
    ```
3.  Jeśli uruchamiasz projekt po raz pierwszy (lub po sklonowaniu go z repozytorium), zainstaluj wszystkie potrzebne zależności (pakiety):
    ```bash
    npm install
    ```
4.  Uruchom serwer deweloperski React:
    ```bash
    npm start
    ```

> Po chwili w Twojej domyślnej przeglądarce powinna automatycznie otworzyć się nowa karta pod adresem **http://localhost:3000**.

### Krok 3: Weryfikacja

Jeśli oba serwery działają poprawnie, na stronie `http://localhost:3000` powinieneś zobaczyć:

1.  Tytuł: `Mój Personalizowany Dashboard`.
2.  Komunikat `Ładowanie danych z serwera PHP...`.
3.  Po chwili komunikat ten powinien zostać zastąpiony przez dane pobrane z backendu, czyli:
    *   `Witaj, Mariusz! Dane prosto z backendu PHP.`
    *   Nazwę projektu i dokładny czas z serwera.

Jeśli widzisz te informacje, oznacza to, że **komunikacja między frontendem (React) a backendem (PHP) działa poprawnie!**

---

## Podsumowanie Techniczne (Co zrobiliśmy?)

*   **W pliku `backend/index.php`:**
    *   Ustawiliśmy nagłówki `Content-Type: application/json`, aby klient wiedział, że dostaje dane JSON.
    *   Ustawiliśmy `Access-Control-Allow-Origin: *` (CORS), aby przeglądarka zezwoliła aplikacji React (działającej na porcie 3000) na odpytywanie serwera PHP (działającego na porcie 8888).
    *   Używamy `json_encode()`, aby zamienić tablicę PHP na tekst w formacie JSON.

*   **W pliku `frontend/src/App.js`:**
    *   Używamy hooka `useState`, aby stworzyć "pudełko" w pamięci komponentu na dane, które pobierzemy.
    *   Używamy hooka `useEffect`, aby wykonać kod (pobranie danych) tylko raz, zaraz po tym, jak komponent pojawi się na ekranie.
    *   Używamy wbudowanej w przeglądarkę funkcji `fetch()`, aby wysłać żądanie HTTP GET do naszego serwera PHP pod adresem `http://localhost:8888`.
    *   Wyświetlamy dane w HTML za pomocą składni `{}` (nazywanej JSX), dynamicznie pokazując treść w zależności od tego, czy dane już się załadowały.
