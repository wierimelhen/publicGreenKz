export const selectThemeConfig = (state) => state.theme.themeConfig;
export const selectThemeMode = (state) => state.theme.themeConfig.mode;
export const selectHeaderHeight = (state) => state.theme.headerHeight;

export default { selectThemeConfig, selectThemeMode, selectHeaderHeight };
