<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Grup Table</h1>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="grup in grubs" :key="grup.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm text-gray-900">{{ grup.id }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ grup.name }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';

  export default {
    setup() {
      const grubs = ref([]);

      const fetchData = async () => {
        try {
          const response = await axios.get('/api/grups');
          grubs.value = response.data;
        } catch (error) {
          console.error('Error getting data:', error);
        }
      };

      onMounted(() => {
        fetchData();
      });

      return {
        grubs,
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
  th, td {
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
