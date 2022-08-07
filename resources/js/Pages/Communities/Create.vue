<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/Label.vue';

defineProps({
    errors: Object,
})

const form = useForm({
    name: '',
    description: '',
    slug: '',
});

const submit = () => {
    form.post(route('communities.store'));
};
</script>


<template>
    <Head title="Communities" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Community
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                                <BreezeInputError :message="errors.name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="description" value="Description" />
                                <BreezeInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" required autocomplete="description" />
                                <BreezeInputError :message="errors.description" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="slug" value="Slug" />
                                <BreezeInput id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" required autocomplete="slug" />
                                <BreezeInputError :message="errors.slug" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
