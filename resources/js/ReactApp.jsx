import "@/assets/css/style.css";
import React from "react";
import ReactDOM from "react-dom/client";
import { HashRouter } from "react-router-dom";

// модули
import { Provider as SnackbarProvider } from "@/components/snackbar";
// утилиты
import Router from "@/utils/routes";
import background from "@/assets/paper6.png";

function ReactApp() {
    return (
            <SnackbarProvider autoHideDuration={1000}>
                <HashRouter>
                    <div
                        style={{
                            backgroundImage: `url(${background})`,
                            backgroundSize: "100% 100%",
                            backgroundRepeat: "no-repeat",
                            backgroundPositionX: "center",
                            width: "100%",
                            height: "100%",
                        }}
                    >
                        <Router />
                    </div>
                </HashRouter>
            </SnackbarProvider>
    );
}

export default ReactApp;
