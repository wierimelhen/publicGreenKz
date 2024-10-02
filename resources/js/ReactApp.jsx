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
import background from "@/assets/paper6.png";
import background2 from "@/assets/paper2.png";

function ReactApp() {
    return (
        <StoreProvider>
            <SnackbarProvider autoHideDuration={1000}>
                <HashRouter>
                    <Box
                        sx={{
                            backgroundImage: `url(${background})`,
                            backgroundSize: "100% 100%",
                            backgroundRepeat: "no-repeat",
                            backgroundPositionX: "center",
                            width: "100%",
                            height: "100%",
                        }}
                    >
                        {/* <Box
                            sx={{
                                backgroundImage: `url(${background2})`,
                                backgroundSize: "cover",
                                backgroundRepeat: "no-repeat",
                                backgroundPositionX: "center",
                                width: "90%",
                                height: "95%",
                                borderBottomLeftRadius: "10px",
                                borderBottomRightRadius: "10px",
                                margin: "auto",
                                boxShadow: "3px 5px 20px 1px #141b27",
                                borderRight: '3px solid #81735d',
                                borderBottom: '3px solid #81735d'
                            }}
                        > */}
                            <Router />
                        {/* </Box> */}
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
