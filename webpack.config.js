const path = require("path");

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            "@hooks": path.resolve("resources/js/utils/hooks"),
            "@helpers": path.resolve("resources/js/utils/helpers"),
            "@hocs": path.resolve("resources/js/utils/hocs"),
            "react/jsx-runtime": "react/jsx-runtime.js",
        },
        // Add `.ts` and `.tsx` as a resolvable extension.
        extensions: [".ts", ".tsx", ".js", ".jsx"],
    },
};
