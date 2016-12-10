export default (url, error, response) => {
    console.error(url, error.status, error.response.statusText);
}
