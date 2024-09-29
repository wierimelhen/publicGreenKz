export const selectSearchResult1 = (state) => state.search.search_result_1;
export const selectSearchConfig = (state) => state.search.searchConfig_1;
export const selectSearchName = (state) => state.search.searchConfig_1.name;

export default { selectSearchResult1, selectSearchConfig, selectSearchName };
