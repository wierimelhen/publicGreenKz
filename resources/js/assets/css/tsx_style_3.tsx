import zIndex from "@mui/material/styles/zIndex";
import { fontSize, positions } from "@mui/system";
import { right } from "@popperjs/core";

const StylesModule = {
    ContentStyle: {},

    box_1_1: {
        height: "100vh",
        //   paddingTop: "20px",
        paddingBottom: "40px",

        position: "fixed",
        zIndex: "2",
        display: "inline-flex",
        background: "#1b1b1b",
        // position: 'fixed',
        // zIndex: '2',
        justifyContent: "center",
        float: "left",
    },
    box_1_2: {
        height: "100vh",
        //   paddingTop: "20px",
        paddingBottom: "40px",

        position: "fixed",
        zIndex: "2",
        display: "inline-flex",
        background: "#1b1b1b00",
        alignItems: "center",
        justifyContent: "center",
        float: "left",
    },
    box_2_1: {
        height: "100vh",
        // paddingTop: "20px",
        // paddingBottom: "40px",
        width: "11vw",
        display: "grid",
        background: "#92af0d",
        border: "1px solid #18550f",
        boxShadow: "rgb(26 27 28 / 74%) 20px 0px 20px 0px",
        alignItems: "center",
        // position: "fixed",
        // top: "0",
        // right: "20%",
        justifyContent: "center",
        float: "left",
    },
    box_2_2: {
        height: "10vh",
        borderTopRightRadius: "20px",
        borderBottomRightRadius: "20px",
        width: "7vw",
        display: "grid",
        background: "#92af0d",
        border: "1px solid #18550f",
        alignItems: "center",
        // position: "fixed",
        // top: "0",
        // right: "20%",
        justifyContent: "center",
        float: "left",
    },
    box_3: {
        height: "100vh",
        paddingBottom: "40px",
        display: "grid",
        background: "#1b1b1b",
        WebkitBoxPack: "center",
        msFlexPack: "center",
        WebkitJustifyContent: "center",
        justifyContent: "center",
        width: "70vw",
    },
    IconButton: {
        color: "#fff",
        paddingTop: "10px",
        background: "#555",
        marginTop: "10px",
        borderRadius: "50%",
        paddingBottom: "10px",
        width: "fit-content",
    },

    Icon: {
        height: "100%",
        width: "auto",
        fontSize: "small",
    },
};

export default StylesModule;
