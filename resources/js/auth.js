let access_token = localStorage.getItem('token');
window.axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;

window.App = {
    // write logic for authentication. If user is loggd in or not
    signedIn: true
}
