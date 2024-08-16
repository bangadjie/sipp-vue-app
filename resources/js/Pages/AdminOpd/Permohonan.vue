<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FormPermohonan from './FormPermohonan.vue';
import TablePermohonan from './TablePermohonan.vue';
import TableUser from './TableUser.vue';
import TableGrup from './TableGrup.vue';
import Tableinstansi from './Tableinstansi.vue';
</script>


<template>

    <Head title="Permohonan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Permohonan</h2>
        </template>
        <div>
            <main>
                <div>
                    <!-- <FormPermohonan /> -->
                    <TablePermohonan />
                    <TableUser />
                    <TableGrup />
                    <Tableinstansi />
                </div>
            </main>
        </div>

    </AuthenticatedLayout>

</template>
