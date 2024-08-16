<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">User Table</h1>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 bg-white shadow-md rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Grup</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Instansi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm text-gray-900">{{ user.id }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ user.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ user.email }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ user.grup.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ user.instanses.name }}</td>
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
      const users = ref([]);

      const fetchData = async () => {
        try {
          const response = await axios.get('/api/users');
          users.value = response.data;
        } catch (error) {
          console.error('Error getting data:', error);
        }
      };

      onMounted(() => {
        fetchData();
      });

      return {
        users,
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
