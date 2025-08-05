import React, { useState, useEffect } from 'react';
import Dashboard from './components/Dashboard';
import LoginScreen from './components/LoginScreen';
import WelcomeScreen from './components/WelcomeScreen';
import * as api from './services/api';
import './App.css';

function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userInfo, setUserInfo] = useState(null);
  const [showWelcomeScreen, setShowWelcomeScreen] = useState(false);

  useEffect(() => {
    api.checkLoginStatus().then(userData => {
      if (userData) {
        setIsLoggedIn(true);
        setUserInfo(userData);
        setShowWelcomeScreen(true);
        setTimeout(() => {
          setShowWelcomeScreen(false);
        }, 3000);
      }
    }).catch(error => console.error('Błąd podczas sprawdzania statusu logowania:', error));
  }, []);

  const handleLogout = () => {
    setIsLoggedIn(false);
    setUserInfo(null);
    window.location.href = 'http://localhost:3000';
  };

  return (
    <div className="App">
      <header className="App-header">
        {isLoggedIn ? (
          showWelcomeScreen ? (
            <WelcomeScreen name={userInfo?.given_name || userInfo?.name} />
          ) : (
            <Dashboard onLogout={handleLogout} />
          )
        ) : (
          <LoginScreen />
        )}
      </header>
    </div>
  );
}

export default App;



