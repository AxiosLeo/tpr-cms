import logo from './logo.svg';
import './App.css';

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          developing...
        </p>
        <a
          className="App-link"
          href="/admin.php"
          target="_blank"
          rel="noopener noreferrer"
        >
          Admin
        </a>
        <a
          className="App-link"
          href="/api.php"
          target="_blank"
          rel="noopener noreferrer"
        >
          API
        </a>
      </header>
    </div>
  );
}

export default App;
