<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';

const updateForm = useForm({
    name: '',
    email: '',
    address: '',
    phone_number: '',
});
const deleteForm = useForm({
    name: '',
    email: '',
    address: '',
    phone_number: '',
});

const getCustomer = () => {
    axios.get(`/api/customers/${route().params.id}`).then(res => {
        console.log('form', res, updateForm)
        updateForm.name = res.data.data.name
        updateForm.email = res.data.data.email
        updateForm.address = res.data.data.address
        updateForm.phone_number = res.data.data.phone_number
    });
}
getCustomer()

const submitEdit = () => {
    axios.put(route('customers.update', route().params.id), updateForm)
    .then(function (response) {
        window.location.href = route('dashboard')
    })
};
const submitDelete = () => {
    axios.delete(route('customers.update', route().params.id), deleteForm)
    .then(function (response) {
        window.location.href = route('dashboard')
    })
};
</script>

<template>
    <Head title="Update Customer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Customer</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitEdit">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="updateForm.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="updateForm.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="updateForm.email"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="updateForm.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="address" value="Address" />

                            <TextInput
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="updateForm.address"
                                required
                                autocomplete="address"
                            />

                            <InputError class="mt-2" :message="updateForm.errors.address" />
                        </div>

                        <div>
                            <InputLabel for="phone_numnber" value="Phone Numnber" />

                            <TextInput
                                id="phone_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="updateForm.phone_number"
                                required
                                autocomplete="phone_number"
                            />

                            <InputError class="mt-2" :message="updateForm.errors.phone_number" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link
                                :href="route('dashboard')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Back
                            </Link>

                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': updateForm.processing }" :disabled="updateForm.processing">
                                Update
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitDelete">
                        <DangerButton class="ms-4" :class="{ 'opacity-25': deleteForm.processing }" :disabled="deleteForm.processing">
                                Delete Customer
                        </DangerButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
