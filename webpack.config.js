const path = require("path");
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            "@hooks": path.resolve("resources/js/utils/hooks"),
            "@helpers": path.resolve("resources/js/utils/helpers"),
            "@hocs": path.resolve("resources/js/utils/hocs")
        },
        // Add `.ts` and `.tsx` as a resolvable extension.
        extensions: [".ts", ".tsx", ".js", ".jsx"],
    },
    plugins: [
        new BundleAnalyzerPlugin({
            analyzerMode: 'static', // создает HTML-отчет на диске
            openAnalyzer: false, // если true, отчет будет автоматически открываться в браузере
            reportFilename: 'bundle-report.html', // имя файла отчета
        }),
    ],
};
