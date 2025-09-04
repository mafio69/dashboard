
const API_BASE_URL = 'http://localhost:8888';

// Pomocnicza funkcja do obsługi odpowiedzi HTTP
const handleResponse = (response) => {
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
};

// Pomocnicza funkcja do wykonywania żądań fetch z obsługą błędów
const fetchWithErrorHandling = (url, options = {}) => {
    return fetch(url, { ...options, credentials: 'include' })
        .then(handleResponse)
        .catch(error => {
            console.error(`Error fetching ${url}:`, error);
            throw error;
        });
};

/**
 * Sprawdza, czy użytkownik jest zalogowany, pobierając jego dane.
 * @returns {Promise<Object|null>} Dane użytkownika lub null.
 */
export const checkLoginStatus = () => {
    return fetchWithErrorHandling(`${API_BASE_URL}/auth/user-info`)
        .catch(() => null); // W przypadku błędu zwracamy null
};

/**
 * Pobiera adres URL do logowania przez Google.
 * @returns {Promise<string>} Adres URL do logowania.
 */
export const getLoginUrl = () => {
    return fetchWithErrorHandling(`${API_BASE_URL}/auth/login-url`)
        .then(data => {
            if (!data.authUrl) {
                throw new Error('Auth URL not found in response');
            }
            return data.authUrl;
        });
};

/**
 * Wylogowuje użytkownika.
 * @returns {Promise<void>}
 */
export const logout = () => {
    return fetchWithErrorHandling(`${API_BASE_URL}/auth/logout`, { method: 'POST' });
};

/**
 * Pobiera wydarzenia z kalendarza Google.
 * @returns {Promise<Array>} Lista wydarzeń.
 */
export const getCalendarEvents = () => {
    return fetchWithErrorHandling(`${API_BASE_URL}/auth/calendar-events`);
};

/**
 * Wysyła wiadomość do czatu i zwraca odpowiedź AI.
 * @param {string} message Wiadomość od użytkownika.
 * @returns {Promise<string>} Odpowiedź od AI.
 */
export const sendMessage = (message) => {
    return fetchWithErrorHandling(`${API_BASE_URL}/api/chat`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message }),
    }).then(data => data.reply);
};

/**
 * Wysyła błąd z frontendu na serwer w celu jego zalogowania.
 * @param {Object} error Obiekt błędu.
 * @param {Object} errorInfo Obiekt z informacjami o komponencie, w którym wystąpił błąd.
 * @returns {Promise<Response>}
 */
export const logError = (error, errorInfo) => {
    return fetchWithErrorHandling(`${API_BASE_URL}/api/log-error`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            error: error.toString(),
            errorInfo: errorInfo.componentStack
        }),
    });
};
