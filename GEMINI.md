# Projekt: Personalizowany Dashboard

> **Wytyczne dotyczące kodu:**
> *   Nazwy funkcji, zmiennych, klas i komponentów piszemy w języku **angielskim**.
> *   Komentarze wyjaśniające działanie kodu piszemy w języku **polskim**.

Jest to projekt osobistego dashboardu, który integruje dane z różnych usług (Google Calendar, Gmail) i udostępnia interfejs do rozmowy z AI.

## Architektura

*   **Backend:** Aplikacja API napisana w PHP. Odpowiada za logikę biznesową, komunikację z zewnętrznymi usługami (Google, Gemini AI) i udostępnianie danych w formacie JSON.
*   **Frontend:** Aplikacja napisana w React (stworzona za pomocą `create-react-app`). Odpowiada za interfejs użytkownika, komunikację z backendem PHP i wyświetlanie danych.

## Plan Działania

### Faza 1: Przygotowanie Środowiska (Ukończona)

1.  ✅ **Stworzenie struktury projektu:** Utworzenie głównego katalogu `dashboard` z podkatalogami `backend` i `frontend`.
2.  ✅ **Backend (PHP):**
    *   Stworzenie prostego serwera w PHP w katalogu `backend`.
    *   Przygotowanie endpointu, który zwraca przykładowe dane w formacie JSON (np. `/api/test`).
3.  ✅ **Frontend (React):**
    *   Użycie `npx create-react-app frontend` w katalogu `dashboard` do stworzenia aplikacji React.
    *   Stworzenie prostego komponentu, który pobiera dane z endpointu `/api/test` backendu PHP i wyświetla je.
4.  ✅ **Uruchomienie i weryfikacja:** Uruchomienie obu serwerów (PHP i deweloperskiego serwera React) i potwierdzenie, że komunikacja między nimi działa.

### Faza 2: Integracja z API Google (Backend PHP)

1.  **Konfiguracja Google Cloud:** Utworzenie projektu w Google Cloud Platform, włączenie API dla Google Calendar i Gmail oraz wygenerowanie kluczy OAuth 2.0.
2.  **Implementacja w PHP:**
    *   Dodanie do backendu biblioteki klienckiej Google API dla PHP.
    *   Zaimplementowanie logiki autoryzacji OAuth 2.0.
    *   Stworzenie endpointów API (np. `/api/calendar/events`, `/api/gmail/tasks`), które będą pobierać dane z Google.
3.  **Implementacja we Frontendzie (React):**
    *   Stworzenie komponentów do wyświetlania wydarzeń z kalendarza i zadań z Gmaila.
    *   Dodanie przycisku "Zaloguj się z Google", który będzie inicjował proces autoryzacji.

### Faza 3: Integracja z AI (Backend PHP)

1.  **Implementacja w PHP:**
    *   Dodanie do backendu obsługi zapytań do Gemini API.
    *   Stworzenie endpointu (np. `/api/ai/chat`), który przyjmuje zapytanie od użytkownika, dołącza do niego kontekst (dane z Google) i wysyła do Gemini.
2.  **Implementacja we Frontendzie (React):**
    *   Stworzenie interfejsu czatu.
    *   Podłączenie formularza czatu do endpointu `/api/ai/chat` w backendzie.
    *   Wyświetlanie odpowiedzi od AI w oknie czatu.

### Faza 4: Rozwój i Dopracowanie

1.  **Stylizacja:** Dopracowanie wyglądu interfejsu za pomocą biblioteki komponentów (np. React Bootstrap, Material UI).
2.  **Obsługa błędów:** Zaimplementowanie solidnej obsługi błędów po stronie frontendu i backendu.
3.  **Funkcje zaawansowane:** Rozważenie dodatkowych funkcji, takich jak odświeżanie danych w czasie rzeczywistym czy analiza dashboardu przez AI (wysyłanie zrzutu ekranu).

---

## Aktualny Krok

**Teraz rozpoczynamy Fazę 2: Integracja z API Google.**

Naszym najbliższym celem jest skonfigurowanie projektu w Google Cloud Platform, włączenie niezbędnych API (Google Calendar) i wygenerowanie kluczy dostępowych (OAuth 2.0), które pozwolą naszej aplikacji PHP na bezpieczne pobieranie danych w Twoim imieniu.