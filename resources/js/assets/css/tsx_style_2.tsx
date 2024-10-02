import header from "@/assets/header.png";
import { positions } from "@mui/system";

const StylesModule = {
    ContentStyle: {},

    css_1: {
        height: "10vh",
        backgroundImage: `url(${header})`,
        backgroundColor: "#183132",
        backgroundSize: "100% 100%",
        backgroundRepeat: "no-repeat",
        backgroundPositionX: "center",
        width: "100vw",
        boxShadow: "0px 5px 5px 2px rgba(0,0,0,0.76)",
        display: "flex",
        alignContent: "center",
        justifyContent: "center",
        alignItems: "center",
    },
};

export default StylesModule;
