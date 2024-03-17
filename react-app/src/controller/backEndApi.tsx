import axios, {AxiosInstance} from "axios";

const apiClient =  axios.create({
    baseURL: 'http://localhost:8080',
    timeout: 30000,
});

export function getApiClient(): AxiosInstance {
    const token = localStorage.getItem('jwtToken');
    apiClient.defaults.headers.common['Content-Type'] = 'application/ld+json';
    if (token) {
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }
    return apiClient;
}

