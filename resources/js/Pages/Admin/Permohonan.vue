<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableUser from './TableUser.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Permohonan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seluruh permohonan</h2>
        </template>
        <!-- <div>
            <main>
                <div>
                    <TableUser />
                </div>
            </main>
        </div> -->
    </AuthenticatedLayout>
</template>
