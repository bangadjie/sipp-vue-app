<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-500 flex flex-col justify-between">
                    <h1 class="text-lg font-bold">{{ totalPermohonan }}</h1>
                    <p>Total Permohonan</p>
                </div>
                <div
                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500 flex flex-col justify-between">
                    <h1 class="text-lg font-bold">{{ permohonanBelumdikerjakan }}</h1>
                    <p>Permohonan Belum Dikerjakan</p>
                </div>
                <div
                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500 flex flex-col justify-between">
                    <h1 class="text-lg font-bold">{{ permohonanSedangDikerjakan }}</h1>
                    <p>Permohonan Sedang Dikerjakan</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500 flex flex-col justify-between">
                    <h1 class="text-lg font-bold">{{ permohonanSelesai }}</h1>
                    <p>Permohonan Selesai</p>
                </div>
            </div>
        </div>

        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <BarChart :chartData="chartData" />
        </div> -->

        <!-- <div class="w-1/2">
            <PieChart :chartData="chartData" />
        </div> -->
    </AuthenticatedLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import BarChart from './BarChart.vue';
import PieChart from './PieChart.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user;

// Mendefinisikan variabel reaktif
const totalPermohonan = ref(0);
const permohonanBelumdikerjakan = ref(0);
const permohonanSedangDikerjakan = ref(0);
const permohonanSelesai = ref(0);

// Fungsi untuk mengambil data dari backend
const fetchData = async () => {
    try {
        const response = await axios.get('/api/dashboard', {
            params: {
                instanses_id: user.instanses_id,
                grup_id: user.grup_id,
                user_id: user.id,
            },
        });
        const data = response.data;
        console.log("data dashboard", data);
        totalPermohonan.value = data.totalPermohonan;
        permohonanBelumdikerjakan.value = data.permohonanBelumdikerjakan;
        permohonanSedangDikerjakan.value = data.permohonanSedangDikerjakan;
        permohonanSelesai.value = data.permohonanSelesai;

        // Perbarui data grafik setelah mengambil data
        chartData.value.datasets[0].data = [
            totalPermohonan.value,
            permohonanBelumdikerjakan.value,
            permohonanSedangDikerjakan.value,
            permohonanSelesai.value,
        ];
    } catch (error) {
        console.error('Error getting data:', error);
    }
};

// Mendefinisikan chartData
const chartData = ref({
    labels: ['Total Permohonan', 'Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'],
    datasets: [
        {
            label: 'Jumlah Permohonan',
            data: [
                totalPermohonan.value,
                permohonanBelumdikerjakan.value,
                permohonanSedangDikerjakan.value,
                permohonanSelesai.value,
            ],
            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0'],
            hoverBackgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0'],
        },
    ],
});

onMounted(() => {
    fetchData();
});
</script>
