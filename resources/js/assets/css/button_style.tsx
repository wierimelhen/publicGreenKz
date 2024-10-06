
import button from '@/assets/texture_header.png'

const StylesModule = {
	ContentStyle: {},

	css_1: {
        height: '80%',
        width: '80%',
        display: "flex",
        alignContent: "center",
        justifyContent: "space-between",
        alignItems: "center"
	},

    css_2: {
        boxShadow: "inset 0px 3px 7px 2px #141b27",
        backgroundImage: `url(${button})`,
        borderRadius: "13px",
        border: "1px solid #385536",
        display: "inline-block",
        cursor: "pointer",
        color: "#53514d",
        fontFamily: "Arial",
        fontSize: "1.3em",
        fontWeight: '900',
        padding: "8px 63px",
        textDecoration: "none",
	},
};

export default StylesModule;
