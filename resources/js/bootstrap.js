// import axios from "axios";

// window.axios = axios;

// const token = document
//     .querySelector('meta[name="csrf-token"]')
//     ?.getAttribute("content");

// if (token) {
//     window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
// }

// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
// window.axios.defaults.withCredentials = true;

import axios from "axios";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
// window.axios.defaults.withCredentials = true;

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://127.0.0.1:8000";

const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}
