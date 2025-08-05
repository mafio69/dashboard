import React, { useState, useEffect } from 'react';
import * as api from '../services/api';

function CalendarWidget() {
    const [calendarEvents, setCalendarEvents] = useState([]);

    useEffect(() => {
        api.getCalendarEvents()
            .then(events => setCalendarEvents(events))
            .catch(error => console.error('Błąd podczas pobierania wydarzeń z kalendarza:', error));
    }, []);

    return (
        <div>
            <h2>Nadchodzące wydarzenia</h2>
            {calendarEvents.length > 0 ? (
                <ul style={{ textAlign: 'left', listStyle: 'none', padding: 0 }}>
                    {calendarEvents.map(event => (
                        <li key={event.id} style={{ margin: '10px 0', padding: '10px', border: '1px solid #555', borderRadius: '5px' }}>
                            <strong>{event.summary}</strong>
                            <p style={{margin: '5px 0 0', fontSize: '0.9em'}}>{new Date(event.start.dateTime || event.start.date).toLocaleString()}</p>
                            {event.description && <p style={{margin: '5px 0 0', fontSize: '0.8em', color: '#ccc'}}>{event.description}</p>}
                        </li>
                    ))}
                </ul>
            ) : (
                <p>Brak nadchodzących wydarzeń lub ładowanie...</p>
            )}
        </div>
    );
}

export default CalendarWidget;
