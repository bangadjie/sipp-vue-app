<!-- resources/js/Pages/Admin/ManagementGrup.vue -->
<script setup>
import TableGrup from './TableGrup.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Management grup" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Management grup
            </h2>
        </template>

        <main>
            <TableGrup />
        </main>
    </AuthenticatedLayout>
</template>
