<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Permohonan Table</h1>

        <div class="mb-4 flex space-x-4">
            <div class="mb-4">
                <button @click="showModal('add')"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add New Permohonan</button>
            </div>
            <div class="mb-4">
                <button @click="showModal('delete')"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete Permohonan</button>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Instansi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Category</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="permohonan in permohonans" :key="permohonan.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.instanses.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.category.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.deskripsi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.status.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button @click="showModaledit('edit', permohonan)"
                                class="text-blue-500 hover:underline">Edit</button>
                            <button @click="confirmDelete(permohonan.id)"
                                class="text-red-500 hover:underline ml-4">Delete</button>
                        </td>
                        <td><input type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="remember"></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-bold mb-4">{{ modalType === 'add' ? 'Add' : 'Edit' }} Permohonan</h2>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input v-model="formData.name" type="text" id="name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required />
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea v-model="formData.deskripsi" id="deskripsi"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save</button>
                        <button @click="isModalOpen = false" type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="isDeleteModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                <p class="mb-4">Are you sure you want to delete this permohonan?</p>
                <div class="flex space-x-4">
                    <button @click="handleDelete"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                    <button @click="isDeleteModalOpen = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const permohonans = ref([]);
        const isModalOpen = ref(false);
        const isDeleteModalOpen = ref(false);
        const modalType = ref('');
        const formData = ref({
            id: null,
            instanses: '',
            category: '',
            name: '',
            deskripsi: '',
            status: '',
            // Add other fields as needed
        });
        const itemIdToDelete = ref(null);

        const fetchData = async () => {
            try {
                const response = await axios.get('/api/permohonan');
                permohonans.value = response.data;
            } catch (error) {
                console.error('Error getting data:', error);
            }
        };

        const showModaledit = (type, permohonan = {}) => {
            modalType.value = type;
            formData.value = { ...permohonan };
            isModalOpen.value = true;
        };

        const showModal = (type, permohonan = {}) => {
            modalType.value = type;
            formData.value = { ...permohonan };
            isModalOpen.value = true;
        };

        const confirmDelete = (id) => {
            itemIdToDelete.value = id;
            isDeleteModalOpen.value = true;
        };

        const handleSubmit = async () => {
            try {
                if (modalType.value === 'add') {
                    await axios.post('/api/permohonan', formData.value);
                } else if (modalType.value === 'edit') {
                    await axios.put(`/api/permohonan/${formData.value.id}`, formData.value);
                }
                isModalOpen.value = false;
                fetchData();
            } catch (error) {
                console.error('Error processing request:', error);
            }
        };

        const handleDelete = async () => {
            try {
                await axios.delete(`/api/permohonan/${itemIdToDelete.value}`);
                isDeleteModalOpen.value = false;
                fetchData();
            } catch (error) {
                console.error('Error deleting data:', error);
            }
        };

        onMounted(() => {
            fetchData();
        });

        return {
            permohonans,
            isModalOpen,
            isDeleteModalOpen,
            modalType,
            formData,
            showModal,
            showModaledit,
            handleSubmit,
            handleDelete,
            confirmDelete,
        };
    },
};
</script>

<style scoped>
.modal-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 500px;
    width: 100%;
}
</style>
