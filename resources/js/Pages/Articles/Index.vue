<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm, Head } from '@inertiajs/vue3';
import Article from "@/Components/Article.vue";

defineProps(['articles']);

const form = useForm({
    title: '',
    body: '',
});
</script>

<template>
    <Head title="Articles" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('articles.store'), { onSuccess: () => form.reset() })">
                <input v-model="form.title"
                       placeholder="Title"
                       class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.title" class="mt-2" />
                <textarea
                    v-model="form.body"
                    placeholder="What are we writing about today?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.body" class="mt-2" />
                <PrimaryButton class="mt-4">Publish New</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Article
                    v-for="article in articles"
                    :key="article.id"
                    :article="article"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
