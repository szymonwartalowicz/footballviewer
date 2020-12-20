let baseUrl;

export async function $fetch(url, options = null) {
  const response = await fetch(`${baseUrl}${url}`, options);
  if (response.ok) {
    const data = await response.json();
    return data;
  } else {
    const message = await response.text();
    const error = new Error(message);
    error.response = response;
    throw error;
  }
}

export default {
  install(Vue, options) {
    baseUrl = options.baseUrl;
    Vue.prototype.$fetch = $fetch;
  }
};
