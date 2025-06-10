<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Create New Permohonan</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                    <select id="instansi" v-model="form.instansiId"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required>
                        <option value="" disabled>Select Instansi</option>
                        <option v-for="instansi in instansis" :key="instansi.id" :value="instansi.id">
                            {{ instansi.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" v-model="form.categoryId"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required>
                        <option value="" disabled>Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" v-model="form.name" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required />
            </div>
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" v-model="form.deskripsi"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    rows="4" required></textarea>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" v-model="form.statusId"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                    <option value="" disabled>Select Status</option>
                    <option v-for="status in statuses" :key="status.id" :value="status.id">
                        {{ status.name }}
                    </option>
                </select>
            </div>
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Submit
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const form = ref({
            instansiId: '',
            categoryId: '',
            name: '',
            deskripsi: '',
            statusId: '',
        });

        const instansis = ref([]);
        const categories = ref([]);
        const statuses = ref([]);

        const fetchData = async () => {
            try {
                const [instansiResponse, categoryResponse, statusResponse] = await Promise.all([
                    axios.get('/api/instansis'),
                    axios.get('/api/categories'),
                    axios.get('/api/statuses'),
                ]);
                instansis.value = instansiResponse.data;
                categories.value = categoryResponse.data;
                statuses.value = statusResponse.data;
            } catch (error) {
                console.error('Error getting data:', error);
            }
        };

        const submitForm = async () => {
            try {
                await axios.post('/api/permohonan', form.value);
                // Reset form or redirect as needed
                form.value = {
                    instansiId: '',
                    categoryId: '',
                    name: '',
                    deskripsi: '',
                    statusId: '',
                };
                alert('Permohonan submitted successfully!');
            } catch (error) {
                console.error('Error submitting form:', error);
            }
        };

        onMounted(() => {
            fetchData();
        });

        return {
            form,
            instansis,
            categories,
            statuses,
            submitForm,
        };
    },
};
</script>

<style scoped>
form {
    max-width: 800px;
}
</style>
