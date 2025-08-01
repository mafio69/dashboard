> **Notatka dla Gemini (Adam):** Pamiętaj, aby po każdym kroku zaktualizować sekcję `## Aktualny Krok` na końcu tego pliku.

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

### Faza 2: Integracja z API Google (W trakcie)

1.  ✅ **Konfiguracja Google Cloud:** Utworzenie projektu, włączenie API, wygenerowanie kluczy `credentials.json`.
2.  ✅ **Instalacja zależności PHP:** Zainstalowanie biblioteki `google/apiclient` za pomocą Composera.
3.  ✅ **Implementacja logiki autoryzacji:**
    *   Stworzenie skryptu `get-login-url.php` do generowania linku logowania.
    *   Podłączenie linku do przycisku "Zaloguj się z Google" w aplikacji React.
4.  **Obsługa odpowiedzi od Google (OAuth Callback):**
    *   Stworzenie skryptu `oauth-callback.php`, który przechwyci kod autoryzacyjny od Google.
    *   Wymiana kodu na token dostępu (`access token`) i zapisanie go (np. w sesji).
5.  **Pobranie danych z API:**
    *   Stworzenie skryptu `get-calendar-events.php`, który użyje zapisanego tokenu do pobrania wydarzeń z kalendarza.
    *   Wyświetlenie wydarzeń w aplikacji React.

### Faza 3: Integracja z AI (Backend PHP)
(...)

### Faza 4: Rozwój i Dopracowanie
(...)

---

## Aktualny Krok

**Jesteśmy w trakcie Fazy 2. Pomyślnie zintegrowaliśmy proces rozpoczynania logowania.**

Udało nam się:
*   Wygenerować link autoryzacyjny po stronie PHP.
*   Dodać przycisk w aplikacji React, który po kliknięciu poprawnie przekierowuje na stronę logowania Google.

**Następny krok po przerwie:**
Naszym celem będzie stworzenie pliku `oauth-callback.php`. Będzie on odpowiedzialny za "złapanie" odpowiedzi od Google po tym, jak użytkownik się zaloguje i wyrazi zgodę. Skrypt ten odbierze specjalny, jednorazowy kod i wymieni go na `access token` – magiczny klucz, który pozwoli nam na wysyłanie zapytań bezpośrednio do API Kalendarza.
