# Projekt: Personalizowany Dashboard

> **Wytyczne dotyczące pracy i kodu:**
> *   **Atomowe kroki:** Działamy w małych, atomowych krokach. Po każdej istotnej zmianie w kodzie od razu ją testujemy, aby upewnić się, że wszystko działa, zanim przejdziemy dalej.
> *   **Nazewnictwo:** Nazwy funkcji, zmiennych, klas i komponentów piszemy w języku **angielskim**.
> *   **Komentarze:** Komentarze wyjaśniające działanie kodu piszemy w języku **polskim**.
> *   **SOLID** To zasady których przestrzegamy

Jest to projekt osobistego dashboardu, który integruje dane z różnych usług (Google Calendar, Gmail) i udostępnia interfejs do rozmowy z AI.

## Plan Działania

### ✅ Faza 1: Przygotowanie Środowiska
### ✅ Faza 2: Integracja z API Google
### ✅ Faza 3: Refaktoryzacja Backendu do Architektury MVC/DI
### ✅ Faza 4: Integracja z AI (Backend PHP)
### ✅ Faza 5: Refaktoryzacja Frontendu i Granice Błędów

### Faza 6: Zintegrowany System Logowania Błędów

Naszym celem jest stworzenie mechanizmu, który będzie automatycznie zapisywał błędy z frontendu na backendzie. Dzięki temu będziemy mogli diagnozować problemy, które napotykają użytkownicy, bez potrzeby proszenia ich o zrzuty ekranu z konsoli.

*   [x] **Krok 1: Stworzenie endpointu na backendzie**
    *   [x] Zdefiniowanie nowej trasy `POST /api/log-error`.
    *   [x] Stworzenie `ErrorLogController`, który będzie przyjmował dane o błędzie.
    *   [x] Implementacja logiki zapisywania błędów do pliku (np. `logs/frontend_errors.log`).
*   [x] **Krok 2: Integracja z frontendem**
    *   [x] Stworzenie funkcji `logError` w `services/api.js`.
    *   [x] Modyfikacja komponentu `ErrorBoundary.js`, aby w metodzie `componentDidCatch` wywoływał nową funkcję `logError`, wysyłając szczegóły błędu na serwer.
*   [ ] **Krok 3: Testowanie**
    *   [ ] Ponowne zasymulowanie błędu w jednym z widgetów.
    *   [ ] Weryfikacja, czy na serwerze został utworzony i poprawnie zapisany plik z logiem błędu.

---

## Aktualny Krok

**Zakończyliśmy Fazę 5.** Aplikacja jest teraz odporna na błędy w poszczególnych widgetach dzięki architekturze komponentowej i mechanizmowi Granic Błędów (Error Boundaries).

**Następny krok:** Rozpoczynamy **Fazę 6**, czyli implementację systemu logowania błędów po stronie serwera.

---

## Stan prac na dzień 2025-08-05

**Problem:** Nadal występuje błąd `405 Method Not Allowed` dla żądań `POST` i `OPTIONS` do endpointów API (np. `/api/chat`, `/api/log-error`).
**Szczegóły błędu:** `Method not allowed. Must be one of: POST, OPTIONS`
**Ostatnia próba naprawy:** Modyfikacja `backend/src/Middleware/CorsMiddleware.php` w celu natychmiastowego zwracania odpowiedzi dla żądań `OPTIONS` przed przekazaniem ich do dalszych middleware i routingu. Problem nadal występuje, co sugeruje, że `CorsMiddleware` nie przerywa przetwarzania żądania `OPTIONS` wystarczająco wcześnie lub problem leży głębiej w konfiguracji Slim.
