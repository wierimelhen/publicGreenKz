import axios from "axios";

const instance = axios.create({
  baseURL: "http://192.168.224.99:8000",
  timeout: 60000,
  withCredentials: true,
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
  headers: {
    Accept: "application/json",
    Cookies: "auth_login_token;",
  },
});

export default instance;
