import React, { useState, useEffect } from 'react';
import * as api from '../services/api';

function CalendarWidget() {
    const [calendarEvents, setCalendarEvents] = useState([]);

    useEffect(() => {
        api.getCalendarEvents()
            .then(events => setCalendarEvents(events))
            .catch(error => console.error('Błąd podczas pobierania wydarzeń z kalendarza:', error));
    }, []);

    // CELOWY BŁĄD: Rzucany po wywołaniu hooków, ale przed renderowaniem JSX.
    // throw new Error('Testowy błąd logowania po stronie serwera!');

    return (
        <div>
            <h2 style={{ color: '#4A90E2' }}>Nadchodzące wydarzenia</h2>
            {calendarEvents.length > 0 ? (
                <ul style={{ textAlign: 'left', listStyle: 'none', padding: 0 }}>
                    {calendarEvents.map(event => (
                        <li
                            key={event.id}
                            style={{
                                margin: '10px 0',
                                padding: '10px',
                                border: '1px solid #4A90E2',  // niebieskie obramowanie
                                borderRadius: '5px',
                                backgroundColor: '#1A1F36',  // ciemne tło karty
                                color: '#E1E6F4'              // jasny kolor tekstu
                            }}
                        >
                            <strong style={{ color: '#FFFFFF' }}>{event.summary}</strong> {/* białe pogrubienie */}
                            <p style={{margin: '5px 0 0', fontSize: '0.9em', color: '#A0A8C1'}}>
                                {new Date(event.start.dateTime || event.start.date).toLocaleString()}
                            </p>
                            {event.description && (
                                <p style={{margin: '5px 0 0', fontSize: '0.8em', color: '#7D86A9'}}>
                                    {event.description}
                                </p>
                            )}
                        </li>
                    ))}
                </ul>
            ) : (
                <p style={{ color: '#8A8FB9' }}>Brak nadchodzących wydarzeń lub ładowanie...</p>
            )}
        </div>
    );
}

export default CalendarWidget;
