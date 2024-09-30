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
import background from '@/assets/paper3.png'

function ReactApp() {
    return (
        <StoreProvider>
            <SnackbarProvider autoHideDuration={1000}>
                <HashRouter>
                    <Box
                        sx={{
                            backgroundImage: `url(${background})`,
                            backgroundColor: "#183132",
                                backgroundSize: "100% 100%",
                                backgroundRepeat: "no-repeat",
                                backgroundPositionX: "center",
                                // backgroundPositionY: "10vh",
                                width: "100%",
                                // overflow: "auto",
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
