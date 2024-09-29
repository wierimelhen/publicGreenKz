import "@/assets/css/style.css";

import React from "react";
import ReactDOM from "react-dom";
import { HashRouter } from "react-router-dom";

// moduls
import { Provider as SnackbarProvider } from "@/components/snackbar";
import StoreProvider from "@/store";
// utils
import Router from "@/utils/routes";
import Box from "@mui/material/Box";

function ReactApp() {
    return (
        <StoreProvider>
            <SnackbarProvider autoHideDuration={1000}>
                <HashRouter>
                    <Box
                        sx={{
                            // backgroundImage: `url(${logo})`,
                            background:
                                "radial-gradient(circle, rgba(121,96,36,1) 18%, rgba(76,61,30,1) 100%)",
                        }}
                    >
                        <Router />
                    </Box>
                </HashRouter>
            </SnackbarProvider>
        </StoreProvider>
    );
}

export default ReactApp;

if (document.getElementById("user")) {
    ReactDOM.render(<ReactApp />, document.getElementById("user"));
}
