<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User Table</h1>
        <button @click="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">Add User</button>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Password</th> -->
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Grup</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Instansi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ user.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ user.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ user.email }}</td>
                        <!-- <td class="px-6 py-4 text-sm text-gray-900">{{ user.password ? user.password : 'defaultPassword' }}</td> -->
                        <td class="px-6 py-4 text-sm text-gray-900">{{ user.grup.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ user.instanses.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button @click="editUser(user)"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">edit</button>
                            <button @click="deleteUser(user.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal for Add/Edit User -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-bold mb-4">{{ isEditMode ? 'Edit User' : 'Add User' }}</h2>
                <form @submit.prevent="isEditMode ? updateUser() : addUser()">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="formData.name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" v-model="formData.email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="grup" class="block text-sm font-medium text-gray-700">Grup</label>
                        <select id="grup" v-model="formData.grup_id" required>
                            <option v-for="grup in grups" :key="grup.id" :value="grup.id">{{ grup.name }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                        <select id="instansi" v-model="formData.instanses_id" required>
                            <option v-for="instansi in instansis" :key="instansi.id" :value="instansi.id">{{
                                instansi.name }}</option>
                        </select>
                    </div>

                    <div v-if="modalType === 'edit'" class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="text" id="password" v-model="formData.password"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="flex justify-end">
                        <button @click="closeModal" type="button"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
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
        const users = ref([]);
        const grups = ref([]);
        const instansis = ref([]);
        const isModalOpen = ref(false);
        const isEditMode = ref(false);
        const formData = ref({
            id: null,
            name: '',
            email: '',
            password: 'defaultPassword', // Set password default
            grup_id: null,
            instanses_id: null,
        });

        const fetchData = async () => {
            try {
                const response = await axios.get('/api/users');
                users.value = response.data;
            } catch (error) {
                console.error('Error getting users:', error);
            }
        };

        const fetchGrups = async () => {
            try {
                const response = await axios.get('/api/grups');
                grups.value = response.data;
            } catch (error) {
                console.error('Error getting grups:', error);
            }
        };

        const fetchInstansis = async () => {
            try {
                const response = await axios.get('/api/instanses');
                instansis.value = response.data;
            } catch (error) {
                console.error('Error getting instansis:', error);
            }
        };

        const openAddModal = () => {
            isModalOpen.value = true;
            isEditMode.value = false;
            formData.value = {
                id: null,
                name: '',
                email: '',
                // password: 'defaultPassword', // Set password default saat modal terbuka
                grup_id: null,
                instanses_id: null,
            };
        };

        const closeModal = () => {
            fetchData();
            isModalOpen.value = false;
            formData.value = {
                id: null,
                name: '',
                email: '',
                // password: 'defaultPassword', // Set password default saat modal ditutup
                grup_id: null,
                instanses_id: null,
            };
        };

        const addUser = async () => {
            try {
                const response = await axios.post('/api/users', formData.value);
                users.value.push(response.data);
                closeModal();
                fetchData();
            } catch (error) {
                console.error('Error adding user:', error);
            }
        };

        const editUser = (user) => {
            isModalOpen.value = true;
            isEditMode.value = true;
            formData.value = { ...user }; // Copy user data to formData for editing
            fetchData();
        };

        const updateUser = async () => {
            try {
                const response = await axios.put(`/api/users/${formData.value.id}`, formData.value);
                const index = users.value.findIndex(user => user.id === formData.value.id);
                if (index !== -1) {
                    users.value[index] = response.data;
                }
                closeModal();
                fetchData();
            } catch (error) {
                console.error('Error updating user:', error);
            }
        };

        const deleteUser = async (id) => {
            try {
                await axios.delete(`/api/users/${id}`);
                users.value = users.value.filter(user => user.id !== id);
                fetchData();
            } catch (error) {
                console.error('Error deleting user:', error);
            }
        };

        onMounted(() => {
            fetchData();
            fetchGrups();
            fetchInstansis();
        });

        return {
            users,
            grups,
            instansis,
            isModalOpen,
            isEditMode,
            formData,
            openAddModal,
            closeModal,
            addUser,
            editUser,
            updateUser,
            deleteUser,
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
