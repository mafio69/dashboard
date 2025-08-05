import React, { useState } from 'react';
import * as api from '../services/api';

function ChatWidget() {
    const [message, setMessage] = useState('');
    const [history, setHistory] = useState([]);

    const handleSendMessage = () => {
        if (!message.trim()) return;

        const newMessage = { role: 'user', text: message };
        setHistory(prev => [...prev, newMessage]);

        api.sendMessage(message)
            .then(reply => {
                const aiMessage = { role: 'ai', text: reply };
                setHistory(prev => [...prev, aiMessage]);
            })
            .catch(error => {
                console.error('Błąd podczas wysyłania wiadomości:', error);
                const errorMessage = { role: 'ai', text: 'Przepraszam, wystąpił błąd.' };
                setHistory(prev => [...prev, errorMessage]);
            });

        setMessage('');
    };

    return (
        <div>
            <h2>Czat z AI</h2>
            <div style={{ height: '400px', border: '1px solid #555', overflowY: 'auto', padding: '10px', marginBottom: '10px' }}>
                {history.map((msg, index) => (
                    <div key={index} style={{ textAlign: msg.role === 'user' ? 'right' : 'left', margin: '5px 0' }}>
                        <p style={{ display: 'inline-block', padding: '10px', borderRadius: '10px', backgroundColor: msg.role === 'user' ? '#007bff' : '#333' }}>
                            {msg.text}
                        </p>
                    </div>
                ))}
            </div>
            <div style={{ display: 'flex' }}>
                <input
                    type="text"
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                    onKeyPress={(e) => e.key === 'Enter' && handleSendMessage()}
                    style={{ flex: 1, padding: '10px' }}
                />
                <button onClick={handleSendMessage} style={{ padding: '10px 20px' }}>Wyślij</button>
            </div>
        </div>
    );
}

export default ChatWidget;
