<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Permohonan Table</h1>

        <div class="mb-4 flex space-x-4">
            <div>
                <button @click="showModal('add')"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add New Permohonan</button>
            </div>
            <div>
                <button @click="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                    :disabled="!selectedItems.length">Delete Selected Permohonan</button>
            </div>
            <div class="mb-4">
                <input type="text" v-model="searchQuery" placeholder="Search Permohonan..."
                    class="px-4 py-2 border border-gray-300 rounded-md" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <input type="checkbox" @click="toggleSelectAll">
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Pemohon</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Instansi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Category</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Waktu</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">terakhir di ubah</th> -->
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="permohonan in filteredPermohonans" :key="permohonan.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <input type="checkbox" v-model="selectedItems" :value="permohonan.id"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.user?.name || 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.instanses?.name || 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.category?.name || 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.deskripsi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ timeAgo(permohonan.created_at) }}</td>
                        <!-- <td class="px-6 py-4 text-sm text-gray-900">{{ formatDate(permohonan.created_at) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ formatDate(permohonan.updated_at) }}</td> -->
                        <td class="px-6 py-4 text-sm text-gray-900">{{ permohonan.status?.name || 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 flex space-x-2">
                            <div v-if="isAdmin">
                                <button @click="showModalEdit('edit', permohonan)"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Edit
                                </button>
                            </div>
                            <button @click="confirmDelete(permohonan.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal for Add/Edit -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-bold mb-4">{{ modalType === 'add' ? 'Add Permohonan' : 'Edit Permohonan' }}</h2>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-4">
                        <label for="instanses" class="block text-sm font-medium text-gray-700">Instansi</label>
                        <select v-model="formData.instanses_id" id="instanses"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option v-for="instansi in instanses" :key="instansi.id" :value="instansi.id">{{
                                instansi.name }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select v-model="formData.category_id" id="category"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                category.name }}</option>
                        </select>
                    </div>
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

                    <!-- Field Status hanya untuk edit -->
                    <div v-if="modalType === 'edit'" class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select v-model="formData.status_id" id="status"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}
                            </option>
                        </select>
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

        <!-- Modal for Delete Confirmation -->
        <div v-if="isDeleteModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                <p class="mb-4">Are you sure you want to delete the selected permohonan?</p>
                <div class="flex space-x-4">
                    <button @click="confirmDeleteMultiple"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                    <button @click="isDeleteModalOpen = false" type="button"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
import { computed } from 'vue';


export default {
    setup() {
        const { props } = usePage();
        const user = props.auth.user;
        const permohonans = ref([]);
        const instanses = ref([]);
        const categories = ref([]);
        const statuses = ref([]);
        const selectedItems = ref([]);
        const isModalOpen = ref(false);
        const isDeleteModalOpen = ref(false);
        const modalType = ref('');
        const searchQuery = ref('');
        const formData = ref({
            id: null,
            user_id: user.id,
            instanses_id: '',
            category_id: '',
            name: '',
            deskripsi: '',
            status_id: '',
        });
        const itemIdToDelete = ref(null);

        // const formatDate = (date) => {
        //     return new Date(date).toLocaleString(); // Formatkan tanggal sesuai keinginanmu
        // }

        const isAdmin = computed(() => user.grup_id === 1 || user.grup_id === 2);

        const fetchData = async () => {
            try {
                const response = await axios.get('/api/permohonan', {
                    params: {
                        instanses_id: user.instanses_id,
                        grup_id: user.grup_id,
                        user_id: user.id,
                    }
                });
                permohonans.value = response.data;
                console.log(response.data)
                // Swal.fire('Sukses', 'Data Permohonan Berhasil di Muat', 'success');
            } catch (error) {
                console.error('Error getting data:', error);
            }
        };

        const fetchListInstanses = async () => {
            try {
                const instansesResponse = await axios.get('/api/instanses');
                instanses.value = instansesResponse.data;
            } catch (error) {
                console.error('Error getting instanses:', error);
            }
        };

        const fetchListCategory = async () => {
            try {
                const categoriesResponse = await axios.get('/api/categories');
                categories.value = categoriesResponse.data;
            } catch (error) {
                console.error('Error getting categories:', error);
            }
        };

        const fetchListStatus = async () => {
            try {
                const statusesResponse = await axios.get('/api/statuses');
                statuses.value = statusesResponse.data;
            } catch (error) {
                console.error('Error getting statuses:', error);
            }
        };

        const showModal = (type, permohonan = null) => {
            modalType.value = type;
            formData.value = permohonan ? { ...permohonan } : {
                id: null,
                user_id: user.id,
                instanses_id: '',
                category_id: '',
                name: '',
                deskripsi: '',
            };
            isModalOpen.value = true;
        };

        const showModalEdit = (type, permohonan = null) => {
            modalType.value = type;
            formData.value = permohonan ? { ...permohonan } : {
                id: null,
                instanses_id: '',
                category_id: '',
                name: '',
                deskripsi: '',
                status_id: '',
            };
            isModalOpen.value = true;
        };

        const handleSubmit = async () => {
            try {
                const dataToSend = { ...formData.value };
                if (modalType.value === 'add') {
                    await axios.post('/api/permohonan', dataToSend);
                    Swal.fire('Sukses', 'Data Permohonan Berhasil di Tambah', 'success');
                } else if (modalType.value === 'edit') {
                    await axios.put(`/api/permohonan/${formData.value.id}`, formData.value);

                    Swal.fire('Sukses', 'Data Permohonan Berhasil di Edit', 'success');
                }
                await fetchData();
                isModalOpen.value = false;
            } catch (error) {
                Swal.fire('Error', 'Data Permohonan Gagal di Tambah', 'error');
                console.error('Error saving data:', error.response.data);
            }
        };

        const confirmDelete = (id = null) => {
            itemIdToDelete.value = id;
            isDeleteModalOpen.value = true;
        };

        const handleDelete = async () => {
            try {
                await axios.delete(`/api/permohonan/${itemIdToDelete.value}`);
                await fetchData();
                isDeleteModalOpen.value = false;
            } catch (error) {
                console.error('Error deleting data:', error);
            }
        };

        const confirmDeleteMultiple = async () => {
            try {
                await Promise.all(selectedItems.value.map(id => axios.delete(`/api/permohonan/${id}`)));
                await fetchData();
                selectedItems.value = [];
                isDeleteModalOpen.value = false;
            } catch (error) {
                console.error('Error deleting multiple:', error);
            }
        };

        const toggleSelectAll = () => {
            if (selectedItems.value.length === permohonans.value.length) {
                selectedItems.value = [];
            } else {
                selectedItems.value = permohonans.value.map(permohonan => permohonan.id);
            }
        };


        const filteredPermohonans = computed(() => {
            return permohonans.value.filter((permohonan) => {
                return (
                    permohonan.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    (permohonan.user?.name || '').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    (permohonan.instanses?.name || '').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    (permohonan.category?.name || '').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    permohonan.deskripsi.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            });
        });


        onMounted(() => {
            fetchData();
            fetchListInstanses();
            fetchListCategory();
            fetchListStatus();
        });

        return {
            permohonans,
            instanses,
            categories,
            statuses,
            selectedItems,
            isModalOpen,
            isDeleteModalOpen,
            modalType,
            formData,
            showModal,
            showModalEdit,
            handleSubmit,
            confirmDelete,
            handleDelete,
            confirmDeleteMultiple,
            toggleSelectAll,
            isAdmin,
            searchQuery,
            filteredPermohonans,
            timeAgo: (date) => {
                const now = new Date();
                const past = new Date(date);
                const seconds = Math.floor((now - past) / 1000);
                if (seconds < 60) return `${seconds} seconds ago`;
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) return `${minutes} minutes ago`;
                const hours = Math.floor(minutes / 60);
                return hours < 24 ? `${hours} hours ago` : `${Math.floor(hours / 24)} days ago`;
            }
            // formatDate
        };
    }
};
</script>

<style scoped>
.modal-content {
    max-width: 500px;
}
</style>
