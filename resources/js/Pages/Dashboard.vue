<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <span class="mr-4 text-lg inline-block" style="line-height: 34px">Saved searches</span>
                        <BreezeButton class="mt-4" @click="$inertia.visit(route('search.create'))">
                            Create new
                        </BreezeButton>


                        <ul class="mt-8 list-disc">
                            <li class="ml-4 cursor-pointer list-none" v-for="search in searches"
                                :key="search.id"
                                @click="$inertia.visit(route('search.edit', search.id))">
                                <span class="mr-2" :class="search.active ? 'text-green-300' : 'text-red-300'">•</span>
                                {{ search.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import BreezeButton from "@/Components/Button";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        Head,
    },

    props: {
        searches: Array,
    },

    methods: {
        createSearch() {
            this.$inertia.visit(this.route('search.create'));
        }
    },

}
</script>
