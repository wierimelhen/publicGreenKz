import React from "react";
import ReactDOM from "react-dom/client";
import ReactApp from "./ReactApp";

if (document.getElementById("user")) {
    const rootElement = document.getElementById("user");
    const root = ReactDOM.createRoot(rootElement);

    root.render(
        <React.StrictMode>
        <ReactApp />
    </React.StrictMode>
    )
    ;
}

