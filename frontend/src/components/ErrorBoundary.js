import React, { Component } from 'react';

class ErrorBoundary extends Component {
  // Krok 1: Inicjalizujemy stan. Domyślnie zakładamy, że błędu nie ma.
  constructor(props) {
    super(props);
    this.state = { hasError: false, error: null };
  }

  // Krok 2: Ta specjalna metoda cyklu życia jest wywoływana, gdy potomek (komponent wewnątrz ErrorBoundary) rzuci błąd.
  // Pozwala nam zaktualizować stan, co spowoduje ponowne renderowanie i wyświetlenie interfejsu zastępczego.
  static getDerivedStateFromError(error) {
    // Aktualizujemy stan, aby następne renderowanie pokazało UI zastępcze.
    return { hasError: true, error: error };
  }

  // Krok 3: Ta metoda jest wywoływana po wystąpieniu błędu.
  // Jest to idealne miejsce na wykonanie "efektów ubocznych", np. wysłanie logów o błędzie do zewnętrznego serwisu.
  componentDidCatch(error, errorInfo) {
    // Na razie po prostu wyświetlimy błąd w konsoli.
    // W prawdziwej aplikacji moglibyśmy wysłać to do serwisu monitorującego błędy.
    console.error("ErrorBoundary złapał błąd:", error, errorInfo);
  }

  // Krok 4: Metoda renderowania decyduje, co pokazać.
  render() {
    // Jeśli stan `hasError` jest `true`, renderujemy nasz interfejs zastępczy.
    if (this.state.hasError) {
      return (
        <div style={{ padding: '20px', border: '1px dashed red', borderRadius: '5px', backgroundColor: '#3c2f2f' }}>
          <h4>Ups! Coś poszło nie tak w tym widgecie.</h4>
          <p>Pracujemy nad rozwiązaniem problemu. Pozostałe części aplikacji działają normalnie.</p>
          {/* Opcjonalnie: Możemy wyświetlić szczegóły błędu w trybie deweloperskim */}
          {process.env.NODE_ENV === 'development' && (
            <details style={{ whiteSpace: 'pre-wrap', marginTop: '10px' }}>
              <summary>Szczegóły błędu</summary>
              {this.state.error && this.state.error.toString()}
            </details>
          )}
        </div>
      );
    }

    // Jeśli nie ma błędu, po prostu renderujemy komponenty-dzieci, które zostały do niego przekazane.
    return this.props.children;
  }
}

export default ErrorBoundary;
