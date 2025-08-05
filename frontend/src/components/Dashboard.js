import React from 'react';
import CalendarWidget from './CalendarWidget';
import ChatWidget from './ChatWidget';
import GmailWidget from './GmailWidget';
import ErrorBoundary from './ErrorBoundary'; // Importujemy nasz ErrorBoundary
import * as api from '../services/api';

function Dashboard({ onLogout }) {

    const handleLogout = () => {
        api.logout().then(response => {
            if (response.ok) {
                onLogout(); // Wywołujemy funkcję przekazaną z App.js
            }
        }).catch(error => console.error('Błąd sieci podczas wylogowywania:', error));
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
                <h1>Twój Osobisty Dashboard</h1>
                <button onClick={handleLogout} style={{ padding: '10px 20px', fontSize: '16px', cursor: 'pointer' }}>
                    Wyloguj się
                </button>
            </div>
            <div style={{ display: 'flex', gap: '20px' }}>
                <div style={{ flex: 1 }}>
                    <ErrorBoundary>
                        <CalendarWidget />
                    </ErrorBoundary>
                    <br />
                    <ErrorBoundary>
                        <GmailWidget />
                    </ErrorBoundary>
                </div>
                <div style={{ flex: 1 }}>
                    <ErrorBoundary>
                        <ChatWidget />
                    </ErrorBoundary>
                </div>
            </div>
        </div>
    );
}

export default Dashboard;
