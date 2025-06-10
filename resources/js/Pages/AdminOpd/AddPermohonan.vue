<template>
    <form @submit.prevent="handleAdd">
        <div class="mb-4">
            <label for="instanses" class="block text-sm font-medium text-gray-700">Instansi</label>
            <select v-model="formData.instanses" id="instanses"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <option v-for="instansi in instanses" :key="instansi.id" :value="instansi.id">{{ instansi.name }}
                </option>
            </select>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select v-model="formData.category" id="category"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
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

        <div class="flex space-x-4 mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add</button>
            <button @click="$emit('closeModal')" type="button"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</template>

<script>
export default {
    props: ['instanses', 'categories'],
    data() {
        return {
            formData: {
                instanses: '',
                category: '',
                name: '',
                deskripsi: ''
            }
        };
    },
    methods: {
        async handleAdd() {
            try {
                await this.$emit('addPermohonan', this.formData);
            } catch (error) {
                console.error('Error adding permohonan:', error.message);
            }
        }
    }
};
</script>
