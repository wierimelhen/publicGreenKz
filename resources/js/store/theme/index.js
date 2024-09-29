/* eslint-disable no-param-reassign */
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
	themeConfig: {
		mode: 'dark',
		stickyHeader: true,
		pageTransitions: false,
		fontFamily: 'Rubik',
		borderRadius: 2,
	},

	headerHeight: 50,
};

// console.log(initialState);
// const THEME_CONFIG_KEY = 'SLIM_MUI_THEME_DATA';

// const getInitialState = () => {
// 	const localStorageData = localStorage.getItem(THEME_CONFIG_KEY);

// 	console.log(localStorageData);
// 	console.log(JSON.parse(localStorageData));

// 	if (localStorageData) {
// 		return { themeConfig: JSON.parse(localStorageData) };
// 	}
// 	return initialState;
// };

const useSlice = createSlice({
	name: 'themeSlice',
	// initialState: getInitialState(),
	initialState,
	reducers: {
		setDefaultConfig: (state) => {
			state.themeConfig = initialState.themeConfig;
		},
		setConfig: (state, action) => {
			state.themeConfig = action.payload;
		},
		setConfigKey: (state, action) => {
			state.themeConfig[action.payload.key] = action.payload.value;
		},
		setHeaderHeight: (state, action) => {
			state.headerHeight = action.payload;
		},
	},
});

export const { setConfig, setDefaultConfig, setConfigKey, setHeaderHeight } = useSlice.actions;

export default useSlice.reducer;
