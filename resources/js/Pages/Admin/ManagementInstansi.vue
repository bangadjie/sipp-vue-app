<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tableinstansi from '../Admin/Tableinstansi.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Management instansi" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Management instansi</h2>
        </template>
        <div>
            <main>
                <div>
                    <Tableinstansi />
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
