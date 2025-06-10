<template>
    <!-- Modal for Add/Edit -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="modal-content bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">{{ modalType === 'add' ? 'Add' : 'Edit' }} Permohonan</h2>
            <form @submit.prevent="handleSubmit">
                <!-- Instansi Field -->
                <div class="mb-4">
                    <label for="instanses" class="block text-sm font-medium text-gray-700">Instansi</label>
                    <select v-model="formData.instanses" id="instanses"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        <option v-for="instansi in instanses" :key="instansi.id" :value="instansi.id">{{ instansi.name
                            }}</option>
                    </select>
                </div>

                <!-- Category Field -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select v-model="formData.category" id="category"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name
                            }}</option>
                    </select>
                </div>

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="formData.name" type="text" id="name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required />
                </div>

                <!-- Deskripsi Field -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea v-model="formData.deskripsi" id="deskripsi"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required></textarea>
                </div>

                <!-- Status Field (Only for Edit) -->
                <div v-if="modalType === 'edit'" class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="formData.statuses" id="status"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}
                        </option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save</button>
                    <button @click="isModalOpen = false" type="button"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['permohonan', 'instanses', 'categories'],
    data() {
        return {
            formData: { ...this.permohonan }
        };
    },
    methods: {
        async handleEdit() {
            try {
                await this.$emit('editPermohonan', this.formData);
            } catch (error) {
                console.error('Error editing permohonan:', error.message);
            }
        }
    }
};
</script>
