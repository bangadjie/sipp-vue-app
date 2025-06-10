<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Grup Table</h1>
        <button @click="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">Add Grup</button>
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
                    <tr v-for="grup in grups" :key="grup.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ grup.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ grup.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button @click="openEditModal(grup)"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Edit</button>
                            <button @click="deleteGrup(grup.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add Modal -->
        <div v-if="isAddModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-bold mb-4">Add Grup</h2>
                <form @submit.prevent="addGrup">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="newGrup.name"
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

        <!-- Edit Modal -->
        <div v-if="isEditModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-bold mb-4">Edit Grup</h2>
                <form @submit.prevent="updateGrup">
                    <div class="mb-4">
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="edit-name" v-model="editGrup.name"
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
        const grups = ref([]);
        const isAddModalOpen = ref(false);
        const isEditModalOpen = ref(false);
        const newGrup = ref({ name: '' });
        const editGrup = ref({ id: null, name: '' });

        const fetchData = async () => {
            try {
                const response = await axios.get('/api/grups');
                grups.value = response.data;
            } catch (error) {
                console.error('Error getting data:', error);
            }
        };

        const openAddModal = () => {
            isAddModalOpen.value = true;
        };

        const closeAddModal = () => {
            isAddModalOpen.value = false;
            newGrup.value.name = '';
        };

        const addGrup = async () => {
            try {
                const response = await axios.post('/api/grup', {
                    name: newGrup.value.name,
                });

                grups.value.push(response.data); // Add the new grup to the list
                closeAddModal();
                fetchData();
            } catch (error) {
                console.error('Error adding grup:', error);
            }
        };

        const openEditModal = (grup) => {
            editGrup.value = { id: grup.id, name: grup.name };
            isEditModalOpen.value = true;
        };

        const closeEditModal = () => {
            isEditModalOpen.value = false;
            editGrup.value = { id: null, name: '' };
        };

        const updateGrup = async () => {
            try {
                const response = await axios.put(`/api/grup/${editGrup.value.id}`, {
                    name: editGrup.value.name,
                });

                const index = grups.value.findIndex(g => g.id === editGrup.value.id);
                grups.value[index] = response.data; // Update the grup in the list
                closeEditModal();
                fetchData();
            } catch (error) {
                console.error('Error updating grup:', error);
            }
        };

        const deleteGrup = async (id) => {
            try {
                await axios.delete(`/api/grup/${id}`); // Ubah di sini
                grups.value = grups.value.filter(grup => grup.id !== id);
                fetchData();
            } catch (error) {
                console.error('Error deleting grup:', error);
            }
        };


        onMounted(() => {
            fetchData();
        });

        return {
            grups,
            isAddModalOpen,
            isEditModalOpen,
            newGrup,
            editGrup,
            openAddModal,
            closeAddModal,
            addGrup,
            openEditModal,
            closeEditModal,
            updateGrup,
            deleteGrup,
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
