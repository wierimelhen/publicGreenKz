/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    PageLanguage: "ru",
    ShowMessages: false,
    UserChangeData: {},
};

const useSlice = createSlice({
    name: "actionsSlice",
    initialState,
    reducers: {
        setPageLanguage: (state, action) => {
            state.PageLanguage = action.payload;
        },
        setUserChangeData: (state, action) => {
            state.UserChangeData = action.payload;
        },
        setShowMessages: (state, action) => {
            state.ShowMessages = action.payload;
        },
    },
});

export const { setPageLanguage, setUserChangeData, setShowMessages } =
    useSlice.actions;

export default useSlice.reducer;
