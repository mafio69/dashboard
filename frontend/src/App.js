import React, { useState, useEffect } from 'react';
import WelcomeScreen from './WelcomeScreen'; // Krok 1: Importujemy nowy komponent
import './App.css';

function App() {
  // --- Stany Aplikacji ---
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userInfo, setUserInfo] = useState(null); // Stan na dane użytkownika
  const [showWelcomeScreen, setShowWelcomeScreen] = useState(false); // Stan do kontrolowania ekranu powitalnego
  const [calendarEvents, setCalendarEvents] = useState([]);

  // --- Efekt Startowy ---
  // Uruchamia się raz, przy załadowaniu aplikacji, aby sprawdzić status logowania.
  useEffect(() => {
    // Zapytanie do nowego endpointu /api/user-info
    fetch('http://localhost:8888/auth/user-info', { credentials: 'include' })
      .then(response => {
        if (response.ok) {
          return response.json();
        }
        return null; // Jeśli nie jesteśmy zalogowani, serwer zwróci błąd, więc zwracamy null
      })
      .then(userData => {
        if (userData) {
          // Jeśli dostaliśmy dane użytkownika, to znaczy, że jest zalogowany
          setIsLoggedIn(true);
          setUserInfo(userData);
          setShowWelcomeScreen(true); // Aktywujemy ekran powitalny

          // Ustawiamy timer, który po 3 sekundach ukryje ekran powitalny
          setTimeout(() => {
            setShowWelcomeScreen(false);
          }, 3000);

          // Po pomyślnym zalogowaniu, pobieramy wydarzenia z kalendarza
          fetch('http://localhost:8888/auth/calendar-events', { credentials: 'include' })
            .then(res => res.json())
            .then(events => setCalendarEvents(events));
        }
      })
      .catch(error => console.error('Błąd podczas sprawdzania statusu logowania:', error));
  }, []); // Pusta tablica zależności [] oznacza, że efekt uruchomi się tylko raz

  // --- Funkcje Obsługi ---
  const handleGoogleLogin = () => {
    fetch('http://localhost:8888/auth/login-url', { credentials: 'include' })
      .then(response => response.json())
      .then(data => {
        if (data.authUrl) {
          window.location.href = data.authUrl;
        }
      })
      .catch(error => console.error('Błąd podczas pobierania adresu logowania:', error));
  };

  const handleLogout = () => {
    fetch('http://localhost:8888/auth/logout', { credentials: 'include' })
      .then(response => {
        if (response.ok) {
          setIsLoggedIn(false);
          setUserInfo(null);
          setCalendarEvents([]);
          // Po pomyślnym wylogowaniu na serwerze, przekierowujemy na stronę główną
          window.location.href = 'http://localhost:3000';
        } else {
          // Obsługa ewentualnych błędów wylogowania
          console.error('Błąd podczas wylogowywania na serwerze.');
        }
      })
      .catch(error => console.error('Błąd sieci podczas wylogowywania:', error));
  };

  // --- Renderowanie Komponentu ---
  const renderContent = () => {
    if (isLoggedIn) {
      if (showWelcomeScreen) {
        // 1. Zalogowany i ma być ekran powitalny
        return <WelcomeScreen name={userInfo?.given_name || userInfo?.name} />;
      } else {
        // 2. Zalogowany, a ekran powitalny już zniknął
        return (
          <div>
            <button onClick={handleLogout} style={{ padding: '10px 20px', fontSize: '16px', cursor: 'pointer' }}>
              Wyloguj się
            </button>
            <hr style={{ width: '80%', margin: '20px 0' }} />
            <h2>Nadchodzące wydarzenia z Kalendarza Google</h2>
            {calendarEvents.length > 0 ? (
              <ul style={{ textAlign: 'left', listStyle: 'none' }}>
                {calendarEvents.map(event => (
                  <li key={event.id} style={{ margin: '10px 0', padding: '10px', border: '1px solid #555', borderRadius: '5px' }}>
                    <strong>{event.summary}</strong>
                    <p>{new Date(event.start.dateTime || event.start.date).toLocaleString()}</p>
                    {event.description && <p>{event.description}</p>}
                  </li>
                ))}
              </ul>
            ) : (
              <p>Brak nadchodzących wydarzeń lub ładowanie...</p>
            )}
          </div>
        );
      }
    } else {
      // 3. Niezalogowany
      return (
        <button onClick={handleGoogleLogin} style={{ padding: '10px 20px', fontSize: '16px', cursor: 'pointer' }}>
          Zaloguj się z Google
        </button>
      );
    }
  };

  return (
    <div className="App">
      <header className="App-header">
        {/* Wywołujemy funkcję, która decyduje co pokazać */}
        {renderContent()}
      </header>
    </div>
  );
}

export default App;

