import React from 'react';
import CalendarWidget from './CalendarWidget';
import ChatWidget from './ChatWidget';
import BlogWidget from './BlogWidget';

const Dashboard = ({ onLogout }) => {
    return (
        <div className="dashboard">
            <header>
                <h1>Twój Osobisty Dashboard</h1>
                <button onClick={onLogout}>Wyloguj się</button>
            </header>
            <div className="widget-container">
                <CalendarWidget />
                <ChatWidget />
                <BlogWidget />
            </div>
        </div>
    );
};

export default Dashboard;