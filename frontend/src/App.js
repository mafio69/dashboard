import React, { useState, useEffect } from 'react';
import './App.css';

function App() {
  // Definiujemy stan dla naszych danych z backendu.
  // `data` będzie przechowywać pobrane informacje, a `setData` to funkcja do ich aktualizacji.
  // Początkowo stan jest pusty (null).
  const [data, setData] = useState(null);

  // `useEffect` to hook, który uruchamia kod po zamontowaniu komponentu.
  // Pusta tablica `[]` jako drugi argument oznacza, że efekt uruchomi się tylko raz.
  useEffect(() => {
    // Używamy funkcji `fetch`, aby pobrać dane z naszego API w PHP.
    fetch('http://localhost:8888')
      .then(response => response.json()) // Przekształcamy odpowiedź na format JSON.
      .then(fetchedData => setData(fetchedData)) // Zapisujemy pobrane dane w stanie komponentu.
      .catch(error => console.error('Błąd podczas pobierania danych:', error)); // Obsługa ewentualnych błędów.
  }, []); // Pusta tablica zależności - efekt uruchomi się tylko raz, po pierwszym renderowaniu.

  return (
    <div className="App">
      <header className="App-header">
        <h1>Mój Personalizowany Dashboard</h1>
        {/* Sprawdzamy, czy dane zostały już załadowane. */}
        {data ? (
          <div>
            {/* Jeśli tak, wyświetlamy powitanie pobrane z backendu. */}
            <h2>{data.message}</h2>
            <p>Projekt: {data.project}</p>
            <p>Czas serwera: {data.timestamp}</p>
          </div>
        ) : (
          // Jeśli dane się jeszcze ładują, wyświetlamy komunikat.
          <p>Ładowanie danych z serwera PHP...</p>
        )}
      </header>
    </div>
  );
}

export default App;