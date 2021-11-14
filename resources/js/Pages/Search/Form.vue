<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Search
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <BreezeValidationErrors class="mb-4" />

                        <form @submit.prevent="submit">

                            <h1 class="mb-8">{{ edit ? 'Edit' : 'Create' }} Search</h1>

                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-5/12" v-model="form.name" required autofocus autocomplete="search-name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="search-url" value="Search Url" />
                                <BreezeInput id="search-url" type="text" class="mt-1 block w-5/12" v-model="form.search_url" required autocomplete="search-url" />
                            </div>

                            <div class="mt-4">
                                <label class="flex items-center">
                                    <BreezeCheckbox name="remember" v-model:checked="form.active" />
                                    <span class="ml-2 text-sm text-gray-600">Enabled</span>
                                </label>
                            </div>

                            <div class="flex items-center mt-4">
                                <BreezeButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save
                                </BreezeButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {Head} from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button";
import BreezeCheckbox from "@/Components/Checkbox";
import BreezeInput from "@/Components/Input";
import BreezeLabel from "@/Components/Label";
import BreezeValidationErrors from "@/Components/ValidationErrors";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
    },

    data() {
        return {
            edit: false,
            form: this.$inertia.form({
                name: '',
                search_url: '',
                active: false
            })
        }
    },

    props: {
        search: Object,
    },

    methods: {
        submit() {
            if (this.edit) {
                this.form.put(this.route('search.update', this.search.id))
            } else {
                this.form.post(this.route('search.store'));
            }
        }
    },


    created() {
        if (this.search) {
            this.edit = true;
            this.form.name = this.search.name;
            this.form.search_url = this.search.search_url;
            this.form.active = this.search.active === 1;
        }
    }
}
</script>

<style scoped>

</style>
