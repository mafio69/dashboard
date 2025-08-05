import { render, screen, waitFor } from '@testing-library/react';
import App from './App';
import * as api from './services/api';

// Mockujemy cały moduł api
jest.mock('./services/api');

describe('App Component', () => {

  beforeEach(() => {
    // Resetujemy mocki przed każdym testem, aby zapewnić izolację
    jest.clearAllMocks();
  });

  test('renders login screen when user is not logged in', () => {
    // Symulujemy odpowiedź API, że użytkownik nie jest zalogowany
    api.checkLoginStatus.mockResolvedValue(null);
    render(<App />);
    expect(screen.getByText(/Zaloguj się z Google/i)).toBeInTheDocument();
  });

  test('renders dashboard when user is logged in', async () => {
    // Symulujemy odpowiedzi API dla zalogowanego użytkownika
    const mockUserData = { name: 'Test User', given_name: 'Test' };
    api.checkLoginStatus.mockResolvedValue(mockUserData);
    // Kluczowa zmiana: mockujemy też inne potrzebne wywołania API
    api.getCalendarEvents.mockResolvedValue([]); // Symulujemy pustą listę wydarzeń
    api.logout.mockResolvedValue({ ok: true }); // Symulujemy pomyślne wylogowanie

    render(<App />);

    // Czekamy, aż zniknie ekran powitalny i pojawi się Dashboard
    await waitFor(() => {
      expect(screen.getByText(/Twój Osobisty Dashboard/i)).toBeInTheDocument();
    }, { timeout: 3500 });

    // Sprawdzamy, czy kluczowe elementy Dashboardu są na miejscu
    expect(screen.getByText(/Wyloguj się/i)).toBeInTheDocument();
    expect(screen.getByText(/Nadchodzące wydarzenia/i)).toBeInTheDocument();
    expect(screen.getByText(/Czat z AI/i)).toBeInTheDocument();
  });
});
