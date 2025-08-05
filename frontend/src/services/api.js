// Ten plik będzie zawierał wszystkie funkcje do komunikacji z backendem.

const API_BASE_URL = 'http://localhost:8888';

// --- Funkcje API ---

/**
 * Sprawdza, czy użytkownik jest zalogowany, pobierając jego dane.
 * @returns {Promise<Object|null>} Dane użytkownika lub null.
 */
export const checkLoginStatus = () => {
    return fetch(`${API_BASE_URL}/auth/user-info`, { credentials: 'include' })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            return null;
        });
};

/**
 * Pobiera adres URL do logowania przez Google.
 * @returns {Promise<string>} Adres URL do logowania.
 */
export const getLoginUrl = () => {
    return fetch(`${API_BASE_URL}/auth/login-url`, { credentials: 'include' })
        .then(response => response.json())
        .then(data => data.authUrl);
};

/**
 * Wylogowuje użytkownika.
 * @returns {Promise<Response>} Odpowiedź z serwera.
 */
export const logout = () => {
    return fetch(`${API_BASE_URL}/auth/logout`, { credentials: 'include' });
};

/**
 * Pobiera wydarzenia z kalendarza Google.
 * @returns {Promise<Array>} Lista wydarzeń.
 */
export const getCalendarEvents = () => {
    return fetch(`${API_BASE_URL}/auth/calendar-events`, { credentials: 'include' })
        .then(res => res.json());
};

/**
 * Wysyła wiadomość do czatu i zwraca odpowiedź AI.
 * @param {string} message Wiadomość od użytkownika.
 * @returns {Promise<string>} Odpowiedź od AI.
 */
export const sendMessage = (message) => {
    return fetch(`${API_BASE_URL}/api/chat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message }),
        credentials: 'include',
    })
    .then(response => response.json())
    .then(data => data.reply);
};
