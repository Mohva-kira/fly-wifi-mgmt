import { configureStore } from "@reduxjs/toolkit"
import authReducer, { authApi } from "../slices/auth"
import messageReducer from "../slices/message"

export const store = configureStore({
    reducer: {
        auth: authReducer,
        message: messageReducer,
        [authApi.reducerPath]: authApi.reducer
    },

    middleware: (getDefaultMiddleware) => getDefaultMiddleware({
        serializableCheck: false,
    }).concat(authApi.middleware,),

    devTools: true
})


