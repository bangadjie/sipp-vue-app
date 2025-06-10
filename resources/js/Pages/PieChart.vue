<!-- <template>
    <div style="height: 400px;">
        <Pie id="pychart" :options="options" :data="chartData" />
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Pie } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement
} from 'chart.js';
import axios from 'axios';  // Using axios to make API requests

// Register the required elements for Chart.js
ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default {
    components: {
        Pie
    },
    setup() {
        // Use ref to create reactive variables
        const chartData = ref({
            labels: ['Selesai', 'Belum', 'Progres'],  // Start with empty labels
            datasets: [
                {
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'], // Adjust colors
                    data: dataChart.value  // Start with empty data
                }
            ]
        });

        const options = ref({
            responsive: true,
            maintainAspectRatio: false
        });

        // Method to fetch data from the API
        const fetchChartData = async () => {
            try {
                const response = await axios.get('/api/permohonan/getPermohonanChartData');

                // Extract labels and values from the API response
                const { selesai, belum, progres } = response.data;

                const labels = ['Selesai', 'Belum', 'Progres'];
                const values = [selesai, belum, progres];


                console.log("Data label", values);
            } catch (error) {
                console.error('Error fetching chart data:', error);
            }
        };

        // Call fetchChartData when the component is mounted
        onMounted(() => {
            fetchChartData();
        });

        return {
            chartData,
            options
        };
    }
};
</script> -->


<template>
    <div style="height: 400px;">
        <!-- Tampilkan loading saat data sedang diambil -->
        <div v-if="isLoading" class="loading-spinner">
        </div>
        <!-- Tampilkan grafik jika data sudah siap -->
        <Pie v-else id="pychart" :options="options" :data="chartData" />
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Pie } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement
} from 'chart.js';
import axios from 'axios';  // Menggunakan axios untuk permintaan API

// Mendaftarkan elemen yang diperlukan untuk Chart.js
ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default {
    components: {
        Pie
    },
    setup() {
        // Menggunakan ref untuk membuat variabel reaktif
        const dataLabel = ref([]);  // Inisialisasi sebagai array kosong
        const dataChart = ref([]);   // Inisialisasi sebagai array kosong
        const isLoading = ref(true);  // Status loading awalnya true
        const chartData = ref({
            labels: dataLabel.value,  // Gunakan array reaktif dataLabel
            datasets: [
                {
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF'], // Warna yang disesuaikan
                    data: dataChart.value  // Gunakan array reaktif dataChart
                }
            ]
        });

        const options = ref({
            responsive: true,
            maintainAspectRatio: false
        });

        // Metode untuk mengambil data dari API
        const fetchChartData = async () => {
            try {
                const response = await axios.get('/api/permohonan/getPermohonanChartData');

                // Ekstrak data dari respons API
                const { selesai, belum, progres } = response.data;

                // Membuat array label dan nilai
                const labels = ['Selesai', 'Belum', 'Progres'];
                const values = [selesai, belum, progres];

                // Memperbarui variabel reaktif
                dataLabel.value = labels;  // Memperbarui label
                dataChart.value = values;  // Memperbarui data

                // Memperbarui objek chartData
                chartData.value.labels = dataLabel.value;
                chartData.value.datasets[0].data = dataChart.value;

                console.log("Label data:", selesai);
                console.log("Data pie:", belum);
            } catch (error) {
                console.error('Terjadi kesalahan saat mengambil data grafik:', error);
            } finally {
                // Setelah data diambil, hentikan status loading
                isLoading.value = false;
            }
        };

        // Panggil fetchChartData saat komponen dimuat
        onMounted(() => {
            fetchChartData();
        });

        return {
            chartData,
            options,
            isLoading // Menyediakan isLoading untuk digunakan dalam template
        };
    }
};
</script>

<style>
/* Tambahkan beberapa gaya dasar untuk status loading */
.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    font-size: 18px;
    color: #888;
}
</style>
