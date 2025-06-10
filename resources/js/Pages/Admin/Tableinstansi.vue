<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Instansi Table</h1>
        <button @click="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">Add Instansi</button>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="instansi in instansis" :key="instansi.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ instansi.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ instansi.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button @click="openEditModal(instansi)"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Edit
                            </button>
                            <button @click="deleteInstansi(instansi.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-1">
                                Delete
                            </button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add Instansi Modal -->
        <div v-if="isAddModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-bold mb-4">Add Instansi</h2>
                <form @submit.prevent="addInstansi">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="newInstansi.name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>
                    <div class="flex justify-end">
                        <button @click="closeAddModal" type="button"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Instansi Modal -->
        <div v-if="isEditModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-bold mb-4">Edit Instansi</h2>
                <form @submit.prevent="updateInstansi">
                    <div class="mb-4">
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="edit-name" v-model="editInstansi.name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>
                    <div class="flex justify-end">
                        <button @click="closeEditModal" type="button"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const instansis = ref([]);
        const isAddModalOpen = ref(false);
        const newInstansi = ref({ name: '' });
        const isEditModalOpen = ref(false);
        const editInstansi = ref({ id: null, name: '' });

        const fetchData = async () => {
            try {
                const response = await axios.get('/api/instanses');
                instansis.value = response.data;
            } catch (error) {
                console.error('Error getting data:', error);
            }
        };

        const openAddModal = () => {
            isAddModalOpen.value = true;
        };

        const closeAddModal = () => {
            isAddModalOpen.value = false;
            newInstansi.value.name = '';
        };

        const addInstansi = async () => {
            try {
                const response = await axios.post('/api/instanses', newInstansi.value);
                instansis.value.push(response.data);
                closeAddModal();
                fetchData();
            } catch (error) {
                console.error('Error adding instansi:', error);
            }
        };

        const openEditModal = (instansi) => {
            editInstansi.value = { ...instansi }; // Copy data to edit
            isEditModalOpen.value = true;
        };

        const closeEditModal = () => {
            isEditModalOpen.value = false;
            editInstansi.value = { id: null, name: '' };
        };

        const updateInstansi = async () => {
            try {
                const response = await axios.put(`/api/instanses/${editInstansi.value.id}`, editInstansi.value);
                const index = instansis.value.findIndex(instansi => instansi.id === editInstansi.value.id);
                instansis.value[index] = response.data; // Update the instansi in the list
                closeEditModal();
                fetchData();
            } catch (error) {
                console.error('Error updating instansi:', error);
            }
        };

        const deleteInstansi = async (id) => {
            try {
                await axios.delete(`/api/instanses/${id}`);
                instansis.value = instansis.value.filter(instansi => instansi.id !== id);
                fetchData();
            } catch (error) {
                console.error('Error deleting instansi:', error);
            }
        };

        onMounted(() => {
            fetchData();
        });

        return {
            instansis,
            isAddModalOpen,
            newInstansi,
            isEditModalOpen,
            editInstansi,
            openAddModal,
            closeAddModal,
            addInstansi,
            openEditModal,
            closeEditModal,
            updateInstansi,
            deleteInstansi,
        };
    },
};
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

th,
td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

thead {
    background-color: #f9fafb;
}

tbody tr:nth-child(even) {
    background-color: #f3f4f6;
}
</style>
