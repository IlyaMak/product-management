import React, {Suspense} from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import {routes} from "./routes";

const root = ReactDOM.createRoot(document.getElementById('root'));
const Page = routes[window.location.pathname] ?? routes['/'];
root.render(
  <React.StrictMode>
    <App>
      <Suspense fallback={<div>Loading...</div>}>
        <Page/>
      </Suspense>
    </App>
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
