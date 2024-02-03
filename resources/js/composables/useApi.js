// src/composables/useAxios.js
import { ref, onMounted } from 'vue';
import axios from 'axios';

const axiosInstance = axios.create({
    baseURL:  "http://127.0.0.1:8000" //"https://admin.comfortwing.com"
});

export default function useAxios() {
    const loading = ref(false);
    const error = ref(null);

    const sendRequest = async (config) => {
        loading.value = true;

        try {
            const response = await axiosInstance(config);
            return response.data;
        } catch (err) {
            error.value = err;
        } finally {
            loading.value = false;
        }
    };

    // Example of using onMounted to perform an action when the component is mounted
    // onMounted(() => {
    //     console.log('Component is mounted');
    // });

    return {
        loading,
        error,
        sendRequest,
    };
}
