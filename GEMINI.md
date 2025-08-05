# Projekt: Personalizowany Dashboard

> **Wytyczne dotyczące pracy i kodu:**
> *   **Atomowe kroki:** Działamy w małych, atomowych krokach. Po każdej istotnej zmianie w kodzie od razu ją testujemy, aby upewnić się, że wszystko działa, zanim przejdziemy dalej.
> *   **Nazewnictwo:** Nazwy funkcji, zmiennych, klas i komponentów piszemy w języku **angielskim**.
> *   **Komentarze:** Komentarze wyjaśniające działanie kodu piszemy w języku **polskim**.

Jest to projekt osobistego dashboardu, który integruje dane z różnych usług (Google Calendar, Gmail) i udostępnia interfejs do rozmowy z AI.

## Plan Działania

### Faza 1: Przygotowanie Środowiska (Ukończona)

1.  ✅ **Stworzenie struktury projektu**
2.  ✅ **Przygotowanie backendu PHP**
3.  ✅ **Przygotowanie frontendu React**
4.  ✅ **Weryfikacja komunikacji**

### Faza 2: Integracja z API Google (Ukończona)

1.  ✅ **Konfiguracja Google Cloud i autoryzacji**
2.  ✅ **Implementacja logiki logowania i pobierania danych z Kalendarza**
3.  ✅ **Dodanie ekranu powitalnego z danymi użytkownika**

### Faza 3: Refaktoryzacja Backendu do Architektury MVC/DI (Ukończona)

Naszym celem jest przekształcenie kodu backendu w nowoczesną, skalowalną i łatwą w utrzymaniu architekturę opartą o wzorzec MVC i wstrzykiwanie zależności (DI).

1.  ✅ **Instalacja zależności:** Dodanie `php-di/php-di` do projektu.
2.  ✅ **Stworzenie nowej struktury plików:**
    *   Utworzenie katalogu `backend/app/` na pliki konfiguracyjne.
    *   Wydzielenie `dependencies.php` do konfiguracji kontenera DI.
    *   Wydzielenie `routes.php` do definicji tras.
3.  ✅ **Stworzenie "Bootstrapa":** Utworzenie pliku `app/bootstrap.php`, który będzie składał aplikację w całość.
4.  ✅ **Stworzenie "chudego" `public/index.php`:** Punkt wejścia do aplikacji będzie teraz zawierał tylko 2 linie kodu.
5.  ✅ **Sprzątanie:** Usunięcie starych plików i finalizacja struktury.

### Faza 4: Integracja z AI (Backend PHP)
(...)

### Faza 5: Rozwój i Dopracowanie
(...)

---

## Aktualny Krok

**Faza 3: Refaktoryzacja i Naprawa Błędów - Ukończona!**

Pomyślnie zakończyliśmy pełną refaktoryzację backendu do architektury MVC. Naprawiliśmy wszystkie krytyczne błędy, w tym problemy z CORS, błędy 500, logowanie i wylogowywanie. Aplikacja jest teraz stabilna i w pełni funkcjonalna.

**Następny krok:**
Sfinalizowanie i zabezpieczenie naszej pracy.
1.  **Commit zmian:** Zapisanie wszystkich wprowadzonych poprawek i refaktoryzacji w repozytorium Git.
2.  **Przegląd i sprzątanie:** Usunięcie z projektu zbędnych plików i katalogów (np. `_trash`), które są pozostałością po poprzedniej strukturze.