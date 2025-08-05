import React from 'react';

// To jest komponent funkcyjny. Przyjmuje on jeden argument, obiekt `props` (właściwości).
// Używamy tutaj "destrukturyzacji", żeby od razu wyciągnąć `name` z tego obiektu: { name }.
function WelcomeScreen({ name }) {
  return (
    <div className="App-header">
      <h1>Witaj, {name}!</h1>
      <p>Ładowanie Twojego dashboardu...</p>
    </div>
  );
}

export default WelcomeScreen;
