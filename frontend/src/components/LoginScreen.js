import React from 'react';
import * as api from '../services/api';

function LoginScreen({ onLogin }) {

    const handleGoogleLogin = () => {
        api.getLoginUrl().then(authUrl => {
            if (authUrl) {
                window.location.href = authUrl;
            }
        }).catch(error => console.error('Błąd podczas pobierania adresu logowania:', error));
    };

    return (
        <div>
            <h1>Witaj w Personalizowanym Dashboardzie</h1>
            <p>Zaloguj się, aby kontynuować</p>
            <button onClick={handleGoogleLogin} style={{ padding: '10px 20px', fontSize: '16px', cursor: 'pointer' }}>
                Zaloguj się z Google
            </button>
        </div>
    );
}

export default LoginScreen;
