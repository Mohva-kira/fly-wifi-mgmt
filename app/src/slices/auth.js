import { createSlice } from "@reduxjs/toolkit";
import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/dist/query/react"
const user = JSON.parse(localStorage.getItem("user"));

const APIL_URL = "http://localhost:8000/api/"

 export const authApi = createApi({
    reducerPath: "authApi",
    baseQuery: fetchBaseQuery({baseUrl: APIL_URL}),
    endpoints: (builder) => ({
        addUser: builder.mutation({
            query: (data) => ({
                url: 'otp.php',
                method: 'POST',
                body: data
            })
        }),
        login: builder.mutation({
            query: (data) => ({
                url: 'otp.php',
                method: 'POST',
                body: data
            })
        })
    })
 })

const initialState = user 
    ? {isLoggedIn: true, user}
    : {isLoggedIn: false, user: null }

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {},
    extraReducers: (builder) => {
        builder.addMatcher(authApi.endpoints.addUser.matchFulfilled, (state, action)=>  {
           
        });
         builder.addMatcher(authApi.endpoints.login.matchFulfilled, (state, action)=>  {
            state.isLoggedIn = true
        });
        builder.addMatcher(authApi.endpoints.addUser.matchRejected, (state, action)=>  {
            state.isLoggedIn = false
        })
    }

})


export const { useAddUserMutation, useLoginMutation } = authApi
export default authSlice.reducer