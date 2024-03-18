import axios, {AxiosInstance} from "axios";
import {redirect} from "react-router-dom";

export function getApiClient(withToken = true): AxiosInstance {
    const token = localStorage.getItem('jwtToken');
    const apiClient =  axios.create({
        baseURL: 'http://localhost:8080',
        timeout: 30000,
    });

    apiClient.defaults.headers.common['Content-Type'] = 'application/ld+json';
    if (withToken && token) {
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    apiClient.interceptors.response.use(
        (response) => response,
        (error) => {
            if (error.response.data.code === 401) {
                window.location.href = '/login';
            } else if (error.response.data.code === 422) {
                alert(error.response.data);
            } else {
                return error;
            }
        }
    );
    return apiClient;
}

