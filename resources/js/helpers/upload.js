/**
 * Uploads a file to the Orchid file endpoint.
 *
 * @param {string} url Upload endpoint URL.
 * @param {File} file File selected by the user.
 * @param {{field?: string, data?: Object}} options Upload options.
 * @returns {Promise<Object>}
 */
export function uploadFile(url, file, options = {}) {
    const form = new FormData();
    const field = options.field ?? "file";
    const data = options.data ?? {};

    form.append(field, file);

    Object.entries(data).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== "") {
            form.append(key, value);
        }
    });

    return axios.post(url, form).then(response => response.data);
}
