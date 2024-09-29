/* eslint-disable no-param-reassign */
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
	searchConfig_1: {
		name: '',
	},

	search_result_1: [],
};

const useSlice = createSlice({
	name: 'searchSlice',
	initialState,
	reducers: {
		setSearchResult1: (state, action) => {
			state.search_result_1 = action.payload;
		},
		setConfigKey_1: (state, action) => {
			console.log(action.payload.key);
			console.log(action.payload.value);

			state.searchConfig_1[action.payload.key] = action.payload.value;
		},
	},
});

export const { setSearchResult1, setConfigKey_1 } = useSlice.actions;

export default useSlice.reducer;
